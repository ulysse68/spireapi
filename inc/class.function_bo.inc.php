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
require_once(EGW_INCLUDE_ROOT. '/spireapi/inc/class.function_so.inc.php');	

class function_bo extends function_so{
	
	/**
	 * Constructeur
	 *
	 */
	function function_bo(){
		parent::function_so();
	}
	
	function get_info($id){
	/**
	 * Retourne les infos d'une fonction
	 *
	 * @return array
	 */
		$info = $this->so_function->read($id);
		
		return $info;
	}

	function get_function(){
	/**
	 * Retourne la liste des fonctions
	 *
	 * @return array
	 */
		$return = array();
		$so_function = new so_sql('spireapi','spireapi_function');

		$info = $so_function->search('',false);
		foreach((array)$info as $data){
			$return[$data['function_id']] = $data['function_title'];
		}

		return $return;
	}

	function get_root_functions(){
	/**
	 * retourne la liste des fonctions qui n'ont pas de parent 
	 *
	 * @return array
	 */
		$return = array();
		$functions = $this->so_function->search('',false);

		foreach((array)$functions as $function){
			if(empty($function['function_parent'])){
				$return[$function['function_id']] = $function['function_id'];
			}
		}

		return $return;
	}

	function get_functions($level){
	/**
	 * Liste des fonctions (avec hiérarchie)
	 *
	 * @param $level booleen : hierarchie (o/n)
	 * @return array
	 */
		$return = array();
		$root_functions = $this->get_root_functions();
		$functions = $this->so_function->search('',false,'function_title');

		foreach((array)$functions as $function){
			if(in_array($function['function_id'],$root_functions)){
				$temp[$function['function_id']][$function['function_id']] = $function['function_title'];
			}elseif(in_array($function['function_parent'],$root_functions)){
				if($level){
					$temp[$function['function_parent']][$function['function_id']] = '-- '.$function['function_title'];
				}else{
					$temp[$function['function_parent']][$function['function_id']] = $function['function_title'];
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


	function get_possible_parent($id=''){
	/**
	 * retourne la liste des parents possible pour la fonction courante
	 *
	 * @param $id : identifiant de la fonction courante
	 * @return array
	 */
		$return = array();
		$so_function = new so_sql('spireapi','spireapi_function');

		$info = $so_function->search('',false);
		foreach((array)$info as $data){
			if($data['function_id'] != $id && empty($data['function_parent'])){
				$return[$data['function_id']] = $data['function_title'];
			}
		}

		return $return;
	}

	function get_rows($query,&$rows,&$readonlys){
	/**
	 * Récupère et filtre les fonctions
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
		
		// recherche champ texte
		if(!is_array($query['search'])){
			$search = $this->construct_search($query['search']);
		}else{
			$search=$query['search'];
		}

		$rows = $this->so_function->search($search,'',$order,'',$wildcard,false,$op,$start,$query['col_filter'],$join);

		if(!$rows){
			$rows = array();
		}

		$order = $query['order'];
	
		return $this->so_function->total;	
    }
}
?>