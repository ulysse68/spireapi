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
class team_so extends so_sql{
	
	var $spireapi_team = 'spireapi_team';
	
	var $so_team;
	
	/**
	 * Constructeur
	 *
	 */
	function team_so(){
		$this->so_team = new so_sql('spireapi',$this->spireapi_team);
	}
	
	function construct_search($search){
	/**
	 * Crée une recherche. Le tableau de retour contiendra toutes les colonnes de la table en cours, en leur faisant correspondre la valeur $search 
	 *
	 * La requête ainsi crée est prête à être utilisée comme filtre
	 *
	 * @param int $search tableau des critères de recherche
	 * @return array
	 */
		$tab_search=array();
		foreach((array)$this->db_data_cols as $id=>$value){
			$tab_search[$id]=$search;
		}
		return $tab_search;
	}


	function add_update_team($info){
	/**
	 * Crée ou met à jour une equipe
	 *
	 * @param $info : information concernant l'equipe
	 */
		$msg='';
		if(is_array($info)){
			$this->so_team->data = $info;

			if(isset($this->so_team->data['team_id'])){
				// Existant
				$this->so_team->data['date_modified']=time();
				$this->so_team->data['modifier']=$GLOBALS['egw_info']['user']['account_id'];
				$this->so_team->update($this->so_team->data,true);
				
				$msg .= ' '.lang('team updated');
			}else{
				// Nouveau
				$this->so_team->data['team_id'] = '';
				$this->so_team->data['creation_date']=time();
				$this->so_team->data['creator']=$GLOBALS['egw_info']['user']['account_id'];
				$this->so_team->save();
				
				$msg .= ' '.lang('team created');
			}
		}
		return $msg;
	}
}
?>