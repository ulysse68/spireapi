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
class area_so extends so_sql{
	
	var $spireapi_area = 'spireapi_area';
	
	var $so_area;
	
	/**
	 * Constructeur
	 *
	 */
	function area_so(){
		$this->so_area = new so_sql('spireapi',$this->spireapi_area);
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


	function add_update_area($info){
	/**
	 * Crée ou met à jour une zone
	 *
	 * @param $info : information concernant la zone
	 */
		$msg='';
		if(is_array($info)){
			$this->so_area->data = $info;

			if(isset($this->so_area->data['area_id'])){
				// Existant
				$this->so_area->data['date_modified']=time();
				$this->so_area->data['modifier']=$GLOBALS['egw_info']['user']['account_id'];
				$this->so_area->update($this->so_area->data,true);
				
				$msg .= ' '.lang('area updated');
			}else{
				// Nouveau
				$this->so_area->data['area_id'] = '';
				$this->so_area->data['creation_date']=time();
				$this->so_area->data['creator']=$GLOBALS['egw_info']['user']['account_id'];
				$this->so_area->save();
				
				$msg .= ' '.lang('area created');
			}
		}
		return $msg;
	}
}
?>