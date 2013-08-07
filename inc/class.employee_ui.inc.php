<?php
/**
 * eGroupware - Spireapi - 
 * SpireAPI : Module and functions set to manage referentials in eGroupware 
 *
 * @link http://www.spirea.fr
 * @package spireapi
 * @author Spirea SARL <contact@spirea.fr>
 * @copyright (c) 2012-10 by Spirea
 * @license http://opensource.org/licenses/gpl-license.php GPL - GNU General Public License
  */
require_once(EGW_INCLUDE_ROOT. '/spireapi/inc/class.employee_bo.inc.php');

class employee_ui extends employee_bo{
	
	var $public_functions = array(
		'index'	=> true,
		'edit' 	=> true,
		'edit_data' => true,
	);
	
	/**
	 * Constructeur
	 *
	 */
	function employee_ui(){
		parent::employee_bo();
	}
	
	function index($content = null){
	/**
	 * Charge le template index
	 */
		if(isset($_GET['msg'])){
			$msg = $_GET['msg'];
		}

		// Suppression
		if(isset($content['nm']['rows']['delete'])){
			list($id) = @each($content['nm']['rows']['delete']);

			if($this->so_employee->delete(array('account_id' => $id))){
				$msg = lang('Employee deleted');
			}
			unset($content['nm']['rows']['delete']);

			// Récupération de l'application courante
			$app = $content['nm']['appname'];
		}
		
		if (!is_array($content['nm']))
		{
			$default_cols='account_id,n_given,n_family,employee_number,employee_active,creation_date';
			$content['nm'] = array(                           // I = value set by the app, 0 = value on return / output
				'get_rows'       	=> 'spireapi.employee_bo.get_rows',	// I  method/callback to request the data for the rows eg. 'notes.bo.get_rows'
				'bottom_too'     	=> false,		// I  show the nextmatch-line (arrows, filters, search, ...) again after the rows
				'never_hide'     	=> true,		// I  never hide the nextmatch-line if less then maxmatch entrie
				'no_cat'         	=> true,
				'filter_no_lang' 	=> false,		// I  set no_lang for filter (=dont translate the options)
				'filter2_no_lang'	=> false,		// I  set no_lang for filter2 (=dont translate the options)
				'lettersearch'   	=> true,
				'no_filter2'		=> true,
				'options-cat_id' 	=> false,
				'start'          	=>	0,			// IO position in list
				'cat_id'         	=>	'',			// IO category, if not 'no_cat' => True
				'search'         	=>	'',// IO search pattern
				'order'          	=>	'account_id',	// IO name of the column to sort after (optional for the sortheaders)
				'sort'           	=>	'ASC',		// IO direction of the sort: 'ASC' or 'DESC'
				'col_filter'     	=>	array(''),	// IO array of column-name value pairs (optional for the filterheaders)
				'filter_label'   	=>	lang('active'),	// I  label for filter    (optional)
				'filter'         	=>	'',	// =All	// IO filter, if not 'no_filter' => True
				'default_cols'   	=> $default_cols,
				'filter_onchange' 	=> "this.form.submit();",
				'filter2_onchange' 	=> "this.form.submit();",
				'no_csv_export'		=> true,
				'csv_fields'		=> false,
			);
		}
		
		$content['msg'] = $msg;

		// Si on arrive depuis une autre appli alors on recupère l'appname pour faire le menu de gauche
		$app = empty($app) ? get_var('appname',array('GET','POST')) : $app;
		if(!empty($app)){
			$GLOBALS['egw_info']['flags']['currentapp'] = $app;
			$content['nm']['appname'] = $app;
		}else{
			$content['nm']['hideglobal'] = true;
		}

		// Listes
		$sel_options = array(
			'filter'=> array(''=>lang('All status'),'1'=>lang('Active'),'0'=>lang('Inactive')),
			'employee_site'	=> $this->get_sites(false),
			'employee_function' => $this->get_functions(false),
			'employee_team' => $this->get_teams(false),
		);
		
		$tpl = new etemplate('spireapi.employee.index');
		$content['nm']['header_right'] = 'spireapi.employee.index.right';
		$GLOBALS['egw_info']['flags']['app_header'] = lang('Employee management');
		$tpl->read('spireapi.employee.index');
		$tpl->exec('spireapi.employee_ui.index', $content, $sel_options, $readonlys, array('nm' => $content['nm']));
	}
	
	function edit($content = null){
	/**
	 * Charge le template edit
	 */
		$tabs = 'general|rate|note';
		$current_tab = $content[$tabs];

		$msg=$_GET['msg'];
	
		// Appuie sur un bouton (apply/save)
		if(is_array($content)){
			list($button) = @each($content['button']);
			switch($button){
				case 'save':
				case 'apply':
					$msg = $this->add_update_employee($content);
					if($button=='save'){
						echo "<html><body><script>var referer = opener.location;opener.location.href = referer+(referer.search?'&':'?')+'msg=".
							addslashes(urlencode($msg))."'; window.close();</script></body></html>\n";
						$GLOBALS['egw']->common->egw_exit();
					}
					$GLOBALS['egw_info']['flags']['java_script'] .= "<script language=\"JavaScript\">
						var referer = opener.location;
						opener.location.href = referer+(referer.search?'&':'?')+'msg=".addslashes(urlencode($msg))."';</script>";
					break;
			}
			$id = $this->so_employee->data['employee_id'];
			
			$content['msg']=$msg;
		}else{
			if(isset($_GET['id'])){
				$id=$_GET['id'];
			}else{
				$id='';
				
			}
		}
		if(isset($id)){
			$content = array(
				'msg'         => $msg,
			);
			if(empty($id)){
				// Nouveau
				$GLOBALS['egw_info']['flags']['app_header'] = lang('Add employee');
				$content['employee_active'] = true;
				$readonlys[$tabs]['rate'] = true;

			}else{
				// Existant
				$content += $this->get_info($id);
				$content['data'] = $this->get_data($id);
				$GLOBALS['egw_info']['flags']['app_header'] = lang('Edit employee');	
			}
		}

		// Listes
		$sel_options = array(
			'employee_site'	=> $this->get_sites(),
			'employee_area'	=> $this->get_areas(),
			'employee_function' => $this->get_functions(),
			'employee_team' => $this->get_teams(),
		);

		$content[$tabs] = $current_tab;

		$tpl = new etemplate('spireapi.employee.edit');
		$tpl->read('spireapi.employee.edit');
		$tpl->exec('spireapi.employee_ui.edit', $content, $sel_options, $readonlys, $content,2);
	}

	function edit_data($content=null){
	/**
	 * Charge le template edit
	 */
		$msg='';
		// Appuie sur un bouton (apply/save)
		if(is_array($content)){
			list($button) = @each($content['button']);
			switch($button){
				case 'save':
				case 'apply':
					$msg = $this->add_update_employee_data($content);
					if($button=='save'){
						echo "<html><body><script>var referer = opener.location;opener.location.href = referer+(referer.search?'&':'?')+'msg=".
							addslashes(urlencode($msg))."'; window.close();</script></body></html>\n";
						$GLOBALS['egw']->common->egw_exit();
					}
					$GLOBALS['egw_info']['flags']['java_script'] .= "<script language=\"JavaScript\">
						var referer = opener.location;
						opener.location.href = referer+(referer.search?'&':'?')+'msg=".addslashes(urlencode($msg))."';</script>";
					break;
			}
			$id = $this->so_employee_data->data['employee_data_id'];
			
			$content['msg']=$msg;
		}else{
			if(isset($_GET['id'])){
				$id=$_GET['id'];
			}else{
				$id='';
				
			}
		}

		if(isset($id)){
			$content = array(
				'msg'         => $msg,
			);
			if(empty($id)){
				// Nouveau
				$GLOBALS['egw_info']['flags']['app_header'] = lang('Add employee data');
				$content['account_id'] = $_GET['emp_id'];
			}else{
				// Existant
				$content += $this->get_info_data($id);
				$GLOBALS['egw_info']['flags']['app_header'] = lang('Edit employee data');	
			}
		}

		$tpl = new etemplate('spireapi.employee.edit.data');
		$tpl->read('spireapi.employee.edit.data');
		$tpl->exec('spireapi.employee_ui.edit_data', $content, $sel_options, $readonlys, $content,2);
	}
}
?>