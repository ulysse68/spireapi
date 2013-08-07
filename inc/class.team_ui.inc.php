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
require_once(EGW_INCLUDE_ROOT. '/spireapi/inc/class.team_bo.inc.php');

class team_ui extends team_bo{
	
	var $public_functions = array(
		'index'	=> true,
		'edit' 	=> true,
	);
	
	/**
	 * Constructeur
	 *
	 */
	function team_ui(){
		parent::team_bo();
		
		/* Gestion des droits */
		$config = CreateObject('phpgwapi.config');
		$obj_config = $config->read('spireapi');
	}
	
	function index($content = null){
	/**
	 * Charge le template index
	 *
	 */
		if(isset($_GET['msg'])){
			$msg = $_GET['msg'];
		}
		
		// Suppression
		if(isset($content['nm']['rows']['delete'])){
			list($id) = @each($content['nm']['rows']['delete']);
			
			if($this->so_team->delete($id)){
				$msg = lang('team deleted');
			}
			unset($content['nm']['rows']['delete']);
		}
		
		if (!is_array($content['nm']))
		{
			$default_cols='team_id,team_parent,team_label,team_rate,team_appname,team_active,creation_date';
			$content['nm'] = array(                           // I = value set by the app, 0 = value on return / output
				'get_rows'       	=>	'spireapi.team_bo.get_rows',	// I  method/callback to request the data for the rows eg. 'notes.bo.get_rows'
				'bottom_too'     	=> false,		// I  show the nextmatch-line (arrows, filters, search, ...) again after the rows
				'never_hide'     	=> true,		// I  never hide the nextmatch-line if less then maxmatch entrie
				'no_cat'         	=> true,
				'filter_no_lang' 	=> false,		// I  set no_lang for filter (=dont translate the options)
				'filter2_no_lang'	=> false,		// I  set no_lang for filter2 (=dont translate the options)
				'lettersearch'   	=> false,
				'no_filter2'		=> true,
				'no_filter'			=> true,
				'options-cat_id' 	=> false,
				'start'          	=>	0,			// IO position in list
				'cat_id'         	=>	'',			// IO category, if not 'no_cat' => True
				'search'         	=>	'',// IO search pattern
				'order'          	=>	'team_id',	// IO name of the column to sort after (optional for the sortheaders)
				'sort'           	=>	'ASC',		// IO direction of the sort: 'ASC' or 'DESC'
				'col_filter'     	=>	array(),	// IO array of column-name value pairs (optional for the filterheaders)
				'filter_label'   	=>	lang('team'),	// I  label for filter    (optional)
				'filter'         	=>	'',	// =All	// IO filter, if not 'no_filter' => True
				'default_cols'   	=> $default_cols,
				'filter_onchange' 	=> "this.form.submit();",
				'filter2_onchange' 	=> "this.form.submit();",
				'no_csv_export'		=> true,
				'csv_fields'		=> false,
			);
		}
	
		$tpl = new etemplate('spireapi.team.index');
		$content['nm']['header_right'] = 'spireapi.team.index.right';
		$GLOBALS['egw_info']['flags']['app_header'] = lang('teams management');
		$content['msg'] = $msg;

		// Listes
		$sel_options = array(
			'team_parent' => $this->get_possible_parent(),
		);
		
		$tpl->read('spireapi.team.index');
		$tpl->exec('spireapi.team_ui.index', $content, $sel_options, $readonlys, array('nm' => $content['nm']));
	}
	
	function edit($content = null){
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
					$msg = $this->add_update_team($content);
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
			$id = $this->so_team->data['team_id'];
			
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
				$GLOBALS['egw_info']['flags']['app_header'] = lang('Add team');
				$content['team_active'] = true;
			}else{
				// Existant
				$content += $this->get_info($id);
				$GLOBALS['egw_info']['flags']['app_header'] = lang('Edit team');
			}
		}

		// Listes
		$sel_options = array(
			'team_parent' => $this->get_possible_parent($content['team_id']),
		);

		$tpl = new etemplate('spireapi.team.edit');
		$tpl->read('spireapi.team.edit');
		$tpl->exec('spireapi.team_ui.edit', $content, $sel_options, $readonlys, $content,2);
	}
}
?>