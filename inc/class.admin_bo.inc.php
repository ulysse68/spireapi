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
require_once(EGW_INCLUDE_ROOT. '/spireapi/inc/class.admin_so.inc.php');	

class admin_bo extends admin_so{
	
		
	function admin_bo(){
	/**
	 * Constructeur
	 *
	 */
		parent::admin_so();
	}
	
	function add_update_config($info){
	/**
	 * Routine permettant de créer/modifier la config
	 *
	 * @param array $content=null
	 * @return string
	 */
		$obj = CreateObject('phpgwapi.config');
		foreach((array)$info as $id => $value){
			$obj->save_value($id,$value,'spireapi');
		}
		$this->config=$obj->read('spireapi');
		return lang('Configuration updated');
	}
	
	function get_statut(){
	/**
	 * Fonction permettant la récupération des statuts
	 *
	 * @return array
	 */
		$retour = array();
		// $info = $this->so_statut->search('',false,'statut_label');
		foreach((array)$info as $key => $data){
			$retour[$data['statut_id']] = $data['statut_label'];
		}
		return $retour;
	}	
	
	function get_statut_fichier(){
	/**
	 * Fonction permettant la récupération des statuts
	 *
	 * @return array
	 */
		$retour = array();
		// $info = $this->so_statut_fichier->search('',false,'statut_label');
		foreach((array)$info as $key => $data){
			$retour[$data['statut_id']] = $data['statut_label'];
		}
		return $retour;
	}	
}
?>