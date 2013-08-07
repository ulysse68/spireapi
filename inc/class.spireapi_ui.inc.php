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

class spireapi_ui{
	/**
	 * Methods callable via menuaction
	 *
	 * @var array
	 */
	var $public_functions = array(
		'about' 		=> true,
	);

	/**
	 * Constructor
	 *
	 */
	function spireapi_ui(){
	}

	function about(){
	/**
	* Affiche le boite de dialogue 'A propos ...'
	*/
		$lg = 'en';
		if ($GLOBALS['egw_info']['user']['preferences']['common']['lang'] == 'fr'){
			$lg = 'fr';
		}

		$content=$sel_options=$readonlys=array();
		$lines = file(EGW_INCLUDE_ROOT.'/spireapi/about/about_'.$lg.'.txt');
		
		$content['about']="";
		foreach ($lines as $line_num => $line) {
			$content['about'].=htmlspecialchars($line) . "<br />\n";
		}
				
		$tpl = new etemplate('spireapi.about');
		$tpl->exec('spireapi.spireapi_ui.about', $content,$sel_options,$readonlys,$content,0);
	}
}
?>