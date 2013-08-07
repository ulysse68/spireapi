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
  
require_once(EGW_INCLUDE_ROOT. '/spireapi/inc/class.admin_bo.inc.php');

class admin_ui extends admin_bo{
	
	var $public_functions = array(
		'index'	=> true,
		'edit' 	=> true,
	);
	
	
	function admin_ui(){
	/**
	 * Constructeur
	 *
	 */
		parent::admin_bo();
	}
	
	function index($content = null){
	/**
	 * Charge le template index
	 *
	 */ 
		$msg='';
		if(is_array($content)){
			list($button) = @each($content['button']);
			switch($button){
				case 'save':
				case 'apply':
					$msg=$this->add_update_config($content);
					$GLOBALS['egw_info']['flags']['java_script'] .= "<script language=\"JavaScript\">
						var referer = opener.location;
						opener.location.href = referer+(referer.search?'&':'?')+'msg=".addslashes(urlencode($msg))."';</script>";
					break;
				default:
				case 'cancel':
					echo "<html><body><script>window.close();</script></body></html>\n";
					$GLOBALS['egw']->common->egw_exit();
					break;
			}
		}
		
		$content = $this->config;
		
		$sel_options = array(
			'DefaultStatus' => $this->get_statut(),
			'PendingStatus' => $this->get_statut(),
			'TerminatedStatus' => $this->get_statut(),
			'ArchivedStatus' => $this->get_statut(),
			
			'DefaultFichier' => $this->get_statut_fichier(),
		);
		
		$tpl = new etemplate('spireapi.admin.general');
		$tpl->exec('spireapi.admin_ui.index', $content,$sel_options,$no_button, $content);
	}
}
?>