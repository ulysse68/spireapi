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

require_once(EGW_INCLUDE_ROOT. '/spireapi/inc/class.acl_spireapi.inc.php');

class spireapi_hooks
{

	static function search_link($location)
	{
	/**
	* Méthode initialisant les variables globales des tickets, et les paramètres d'affichage de l'utilisateur
	*
	* NOTE : $location ne sert à rien
	* 
	* @param int $location paramètres locaux à charger
	* @return array
	
	*/
		$appname = 'spireapi';
		/* Récupération des droits d'accès ACL */
		$acl = CreateObject($appname.'.acl_'.$appname);
		
		return array(
			'query' => 'spireapi.spireapi_bo.link_query',
			'title' => 'spireapi.spireapi_bo.link_title',
			'titles' => 'spireapi.spireapi_bo.link_titles',
			'view'  => array(
				'menuaction' => 'spireapi.spireapi_ui.edit',
			),
			'view_id' => 'id',
			'view_popup'  => '930x700',
			'add' => array(
				'menuaction' => 'spireapi.spireapi_ui.edit',
			),
			'add_app'    => 'link_app',
			'add_id'     => 'link_id',
			'add_popup'  => '930x700',
		);
	}

	static function all_hooks($args){
	/**
	* Méthode initialisant les variables globales des tickets et chargeant les préférences paramétrées.
	* Permet aussi d'afficher le menu et de créer des liens dirigés vers son contenu
	*
	* \version 
	*
	* @param array $args tableau contenant l'index location définissant l'endroit où l'utilisateur se trouve : spireapi menu,spireapi,admin,... (on en déduit ainsi les paramètres à afficher)
	*/
		$appname = 'spireapi';
		$location = is_array($args) ? $args['location'] : $args;
		
		/* Spirea YLF - Gestion des droits */
		$config = CreateObject('phpgwapi.config');
		$obj_config = $config->read('spireapi');
		
		// Récupération des groupes de l'utilisateur
		$groupeUser = array_keys($GLOBALS['egw']->accounts->memberships($GLOBALS['egw_info']['user']['account_id']));
		

		/*********************/

		if ($location == 'sidebox_menu'){
			$file = array();
			display_sidebox($appname,lang('Menu'),$file);
		}
		
		if (($GLOBALS['egw_info']['user']['apps']['spireapi'] || $GLOBALS['egw_info']['user']['spireapiLevel'] >= 100) && $location != 'admin' && $location != 'referentiel'){
			$file = array();
			
			$file['Employees']=$GLOBALS['egw']->link('/index.php','menuaction=spireapi.employee_ui.index');
			$file['Functions']=$GLOBALS['egw']->link('/index.php','menuaction=spireapi.function_ui.index');
			$file['Teams']=$GLOBALS['egw']->link('/index.php','menuaction=spireapi.team_ui.index');
				
			if ($location == 'repository'){
				display_section($appname,$file);
			}else{
				display_sidebox($appname,lang('HR repository'),$file);
			}
		}

		if (($GLOBALS['egw_info']['user']['apps']['spireapi'] || $GLOBALS['egw_info']['user']['spireapiLevel'] >= 100) && $location != 'admin' && $location != 'referentiel'){
			$file = array();
			
			$file['Sites']=$GLOBALS['egw']->link('/index.php','menuaction=spireapi.site_ui.index');
			$file['Areas']=$GLOBALS['egw']->link('/index.php','menuaction=spireapi.area_ui.index');
				
			if ($location == 'repository'){
				display_section($appname,$file);
			}else{
				display_sidebox($appname,lang('Company repository'),$file);
			}
		}

		if (($GLOBALS['egw_info']['user']['apps']['spireapi'] || $GLOBALS['egw_info']['user']['spireapiLevel'] >= 100) && $location != 'admin' && $location != 'referentiel'){
			$file = array();

			$file['Vat']=$GLOBALS['egw']->link('/index.php','menuaction=spireapi.vat_ui.index');
				
			if ($location == 'repository'){
				display_section($appname,$file);
			}else{
				display_sidebox($appname,lang('Financial repository'),$file);
			}
		}

		if (($GLOBALS['egw_info']['user']['apps']['spireapi'] || $GLOBALS['egw_info']['user']['spireapiLevel'] >= 100) && $location != 'admin' && $location != 'referentiel'){
			$file = array();

			$file['Translations']=$GLOBALS['egw']->link('/index.php','menuaction=spireapi.trans_ui.index');
				
			if ($location == 'repository'){
				display_section($appname,$file);
			}else{
				display_sidebox($appname,lang('Repository'),$file);
			}
		} 

		if ($location != 'admin' && $location != 'preferences' && $location != 'spireapi'){
			$file = array();
			$file[lang('About').' spireapi']=$GLOBALS['egw']->link('/index.php','menuaction=spireapi.spireapi_ui.about');
			display_sidebox($appname,lang('About'),$file);
		}
	}
	
	static function home(){
	/**
	 * Crée l'écran d'accueil avec les paramètres par défaut
	 */
		if($GLOBALS['egw_info']['user']['preferences']['spireapi']['mainscreen_show_spireapi'])
		{
			$content =& ExecMethod('spireapi.spireapi_ui.home');
			$title="Tickets spireapi";
			$portalbox =& CreateObject('phpgwapi.listbox',array(
				'title'	=> $title,
				'primary'	=> $GLOBALS['egw_info']['theme']['navbar_bg'],
				'secondary'	=> $GLOBALS['egw_info']['theme']['navbar_bg'],
				'tertiary'	=> $GLOBALS['egw_info']['theme']['navbar_bg'],
				'width'	=> '100%',
				'outerborderwidth'	=> '0',
				'header_background_image'	=> $GLOBALS['egw']->common->image('phpgwapi/templates/default','bg_filler')
			));
			$GLOBALS['egw_info']['flags']['app_header'] = $save_app_header;
			unset($save_app_header);

			$GLOBALS['portal_order'][] = $app_id = $GLOBALS['egw']->applications->name2id('spireapi');
			foreach(array('up','down','close','question','edit') as $key)
			{
				$portalbox->set_controls($key,Array('url' => '/set_box.php', 'app' => $app_id));
			}
			$portalbox->data = Array();
			echo '<!-- BEGIN spireapi info -->'."\n".$portalbox->draw($content)."\n".'<!-- END spireapi info -->'."\n";
		}
		else
		{
			echo '<!-- BEGIN spireapi info -->'."\nTU AS CHOISI DE NE RIEN AFFICHER\n".'<!-- END spireapi info -->'."\n";
		}
	}

}
?>
