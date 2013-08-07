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
require_once(EGW_INCLUDE_ROOT. '/spireapi/inc/class.vat_so.inc.php');	

class vat_bo extends vat_so{
	
	/**
	 * Constructeur
	 *
	 */
	function vat_bo(){
		parent::vat_so();
	}
	
	function get_info($id){
	/**
	 * Retourne les infos d'un taux
	 *
	 * @return array
	 */
		$info = $this->so_vat->read($id);
		
		return $info;
	}

	function get_vat(){
	/**
	 * Retourne la liste des taux
	 *
	 * @return array
	 */
		$return = array();
		$so_vat = new so_sql('spireapi','spireapi_vat');

		$info = $so_vat->search(array('vat_appname' => array('global',$GLOBALS['egw_info']['flags']['currentapp']), 'vat_active' => true),false);
		foreach((array)$info as $data){
			$return[$data['vat_id']] = $data['vat_label'];
		}

		return $return;
	}

	function get_source(){
	/**
	 * Retourne la liste des sources pour un taux de tva
	 *
	 * @return array
	 */
		$return = array(
			'0' => lang('National'),
			'1' => lang('Intracommunity'),
			'2' => lang('Export'),
			'3' => lang('Misc.').' 1',
			'4' => lang('Misc.').' 2',
		);

		return $return;
	}

	function get_rows($query,&$rows,&$readonlys){
	/**
	 * Récupère et filtre les taux
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

		// Filtre application
		if(!empty($GLOBALS['egw_info']['flags']['currentapp'])){
			$query['col_filter']['vat_appname'][] = $GLOBALS['egw_info']['flags']['currentapp'];

			if(!in_array('global',$query['col_filter']['vat_appname'])){
				$query['col_filter']['vat_appname'][] = 'global';
			}
		}

		$rows = $this->so_vat->search($search,'',$order,'',$wildcard,false,$op,$start,$query['col_filter'],$join);

		if(!$rows){
			$rows = array();
		}

		$order = $query['order'];
		return $this->so_vat->total;	
    }
}
?>