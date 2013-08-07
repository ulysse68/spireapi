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
require_once(EGW_INCLUDE_ROOT. '/spireapi/inc/class.site_so.inc.php');	

class site_bo extends site_so{
	
	/**
	 * Constructeur
	 *
	 */
	function site_bo(){
		parent::site_so();
	}
	
	function formatted_list(){
	/**
	 * retourne une liste formatter html
	 *
	 * @return String
	 */
		$return .= '<option value=>'.lang('All sites').'</option>';

		$sites = $this->so_site->search('',false);

		foreach((array)$sites as $site){
			$return .= '<option value='.$site['site_id'].'>'.$site['site_label'].'</option>';
		}

		return $return;
	}

	function get_info($id){
	/**
	 * returnne les infos d'un site
	 *
	 * @return array
	 */
		$info = $this->so_site->read($id);
		
		return $info;
	}

	function get_root_sites(){
	/**
	 * retourne la liste des sites qui n'ont pas de parent 
	 *
	 * @return array
	 */
		$return = array();
		$sites = $this->so_site->search('',false);

		foreach((array)$sites as $site){
			if(empty($site['site_parent'])){
				$return[$site['site_id']] = $site['site_id'];
			}
		}

		return $return;
	}

	function get_possible_parents($level){
	/**
	 * Liste des parents possible pour un site
	 *
	 * @return array
	 */
		$return = array();
		$root_sites = $this->get_root_sites();
		$sites = $this->so_site->search('',false,'site_label');

		foreach((array)$sites as $site){
			if(in_array($site['site_id'],$root_sites)){
				$temp[$site['site_id']][$site['site_id']] = $site['site_label'];
			}elseif(in_array($site['site_parent'],$root_sites)){
				if($level){
					$temp[$site['site_parent']][$site['site_id']] = '-- '.$site['site_label'];
				}else{
					$temp[$site['site_parent']][$site['site_id']] = $site['site_label'];
				}
			}
		}

		foreach((array)$temp as $key => $data){
			ksort($data);
			foreach((array)$data as $id => $value){
				$return[$id] = $value;
			}
		}
		return $return;
	}

	function get_rows($query,&$rows,&$readonlys){
	/**
	 * Récupère et filtre les sites
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
			$query['col_filter']['site_appname'][] = $GLOBALS['egw_info']['flags']['currentapp'];

			if(!in_array('global',$query['col_filter']['site_appname'])){
				$query['col_filter']['site_appname'][] = 'global';
			}
		}

		$rows = $this->so_site->search($search,'',$order,'',$wildcard,false,$op,$start,$query['col_filter'],$join);

		if(!$rows){
			$rows = array();
		}

		$order = $query['order'];
		return $this->so_site->total;	
    }
}
?>