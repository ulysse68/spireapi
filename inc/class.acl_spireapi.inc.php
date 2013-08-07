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
class acl_spireapi {

	function __construct(){
	/**
	 * Méthode appelée directement par le constructeur. Charge les ACL de l'application
	 */		
		$obj = CreateObject('phpgwapi.config');
		$config = $obj->read('spifiling');
		
		// $groupUser : array => liste des groupes du user en cours
		$accounts = CreateObject('phpgwapi.accounts');
		$groupeUser = $accounts->memberships($GLOBALS['egw_info']['user']['account_id'],true);
				
		$this->admin = $GLOBALS['egw_info']['user']['apps']['admin'] || in_array($config['ManagementGroup'],$groupeUser);
	}
	
	function acl_spifiling(){
	/**
	 * Constructeur
	 */
		self::__construct();
	}
}

?>