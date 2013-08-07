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
require_once(EGW_INCLUDE_ROOT. '/spireapi/inc/class.team_so.inc.php');	

class team_bo extends team_so{
	
	/**
	 * Constructeur
	 *
	 */
	function team_bo(){
		parent::team_so();
	}
	
	function get_info($id){
	/**
	 * Retourne les infos d'une equipe
	 *
	 * @return array
	 */
		$info = $this->so_team->read($id);
		
		return $info;
	}

	function get_team(){
	/**
	 * Retourne la liste des equipes
	 *
	 * @return array
	 */
		$return = array();
		$so_team = new so_sql('spireapi','spireapi_team');

		$info = $so_team->search('',false);
		foreach((array)$info as $data){
			$return[$data['team_id']] = $data['team_title'];
		}

		return $return;
	}

	function get_root_teams(){
	/**
	 * retourne la liste des equipes qui n'ont pas de parent 
	 *
	 * @return array
	 */
		$return = array();
		$teams = $this->so_team->search('',false);

		foreach((array)$teams as $team){
			if(empty($team['team_parent'])){
				$return[$team['team_id']] = $team['team_id'];
			}
		}

		return $return;
	}

	function get_teams($level){
	/**
	 * Liste des equipes (avec hiérarchie)
	 *
	 * @return array
	 */
		$return = array();
		$root_teams = $this->get_root_teams();
		$teams = $this->so_team->search('',false,'team_title');

		foreach((array)$teams as $team){
			if(in_array($team['team_id'],$root_teams)){
				$temp[$team['team_id']][$team['team_id']] = $team['team_title'];
			}elseif(in_array($team['team_parent'],$root_teams)){
				if($level){
					$temp[$team['team_parent']][$team['team_id']] = '-- '.$team['team_title'];
				}else{
					$temp[$team['team_parent']][$team['team_id']] = $team['team_title'];
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
	 * retourne la liste des parents possible pour l'equipe courante
	 *
	 * @param $id : identifiant de la fonction courante
	 * @return array
	 */
		$return = array();
		$so_team = new so_sql('spireapi','spireapi_team');

		$info = $so_team->search('',false);
		foreach((array)$info as $data){
			if($data['team_id'] != $id && empty($data['team_parent'])){
				$return[$data['team_id']] = $data['team_title'];
			}
		}

		return $return;
	}

	function get_rows($query,&$rows,&$readonlys){
	/**
	 * Récupère et filtre les equipes
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

		$rows = $this->so_team->search($search,'',$order,'',$wildcard,false,$op,$start,$query['col_filter'],$join);

		if(!$rows){
			$rows = array();
		}

		$order = $query['order'];
	
		return $this->so_team->total;	
    }
}
?>