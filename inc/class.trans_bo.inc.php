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
require_once(EGW_INCLUDE_ROOT. '/spireapi/inc/class.trans_so.inc.php');	

class trans_bo extends trans_so{
	
	/**
	 * Constructeur
	 *
	 */
	function trans_bo(){
		parent::trans_so();
	}
	
	function get_info($id){
	/**
	 * Retourne les infos d'un traduction
	 *
	 * @return array
	 */
		$info = $this->so_trans->read($id);
		
		return $info;
	}

	function get_apps(){
	/**
	 * Retourne la liste des applications disponible pour l'utilisateur courant
	 *
	 * @return array
	 */
		$return = array();
		$apps = array_keys($GLOBALS['egw_info']['user']['apps']);

		// $db =$GLOBALS['egw']->db;
		// $applications = $db->select('egw_applications','app_id,app_name','app_enabled != 3 and app_enabled > 0',__LINE__,__FILE__,false,'ORDER BY app_name ASC','spiadmin');

		$return['global'] = 'global';

		$applications = array_keys($GLOBALS['egw_info']['user']['apps']);
		foreach((array)$applications as $row)
		{
			// if(in_array($row['app_name'],$apps)){
				$return[$row]=$row;
			// }
		}
		ksort($return);
		return $return;
	}

	function get_rows($query,&$rows,&$readonlys){
	/**
	 * Récupère et filtre les traductions
	 *
	 * @param array $query avec des clefs comme 'start', 'search', 'order', 'sort', 'col_filter'. Pour définir d'autres clefs comme 'filter', 'cat_id', vous devez créer une classe fille
	 * @param array &$rows lignes complétés
	 * @param array &$readonlys pour mettre les lignes en read only en fonction des ACL, non utilisé ici (à utiliser dans une classe fille)
	 * @return int
	 */
		if(!is_array($query['col_filter']) && empty($query['col_filter'])){
			$query['col_filter']=array();
		}
		
		$order=$query['order'].' '.$query['sort'];
		$id_only=false;
		$start=array(
			(int)$query['start'],
			(int) $query['num_rows']
		);
		$wildcard = '%';

		// Recherche champ texte		
		if(!is_array($query['search'])){
			$search = $this->construct_search($query['search']);
		}else{
			$search=$query['search'];
		}

		$rows = $this->so_trans->search($search,'',$order,'',$wildcard,false,$op,$start,$query['col_filter'],$join);

		if(!$rows){
			$rows = array();
		}

		$order = $query['order'];

		return $this->so_trans->total;	
    }
}
?>