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
require_once(EGW_INCLUDE_ROOT. '/spireapi/inc/class.area_so.inc.php');	

class area_bo extends area_so{
	
	/**
	 * Constructeur
	 *
	 */
	function area_bo(){
		parent::area_so();
	}
	
	function get_info($id){
	/**
	 * Retourne les infos d'une zone
	 *
	 * @return array
	 */
		$info = $this->so_area->read($id);
		
		return $info;
	}

	function get_rows($query,&$rows,&$readonlys){
	/**
	 * R�cup�re et filtre les zones
	 *
	 * @param array $query avec des clefs comme 'start', 'search', 'order', 'sort', 'col_filter'. Pour d�finir d'autres clefs comme 'filter', 'cat_id', vous devez cr�er une classe fille
	 * @param array &$rows lignes compl�t�s
	 * @param array &$readonlys pour mettre les lignes en read only en fonction des ACL, non utilis� ici (� utiliser dans une classe fille)
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

		// Filtre sur l'application courante
		if(!empty($GLOBALS['egw_info']['flags']['currentapp'])){
			$query['col_filter']['area_appname'][] = $GLOBALS['egw_info']['flags']['currentapp'];

			if(!in_array('global',$query['col_filter']['area_appname'])){
				$query['col_filter']['area_appname'][] = 'global';
			}
		}

		$rows = $this->so_area->search($search,'',$order,'',$wildcard,false,$op,$start,$query['col_filter'],$join);

		if(!$rows){
			$rows = array();
		}

		$order = $query['order'];

		return $this->so_area->total;	
    }
}
?>