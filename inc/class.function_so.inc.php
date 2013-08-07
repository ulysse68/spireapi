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
class function_so extends so_sql{
	
	var $spireapi_function = 'spireapi_function';
	
	var $so_function;
	
	/**
	 * Constructeur
	 *
	 */
	function function_so(){
		$this->so_function = new so_sql('spireapi',$this->spireapi_function);
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


	function add_update_function($info){
	/**
	 * Crée ou met à jour une fonction
	 *
	 * @param $info : information concernant la fonction
	 */
		$msg='';
		if(is_array($info)){
			$this->so_function->data = $info;

			if(isset($this->so_function->data['function_id'])){
				// Existant
				$this->so_function->data['date_modified']=time();
				$this->so_function->data['modifier']=$GLOBALS['egw_info']['user']['account_id'];
				$this->so_function->update($this->so_function->data,true);
				
				$msg .= ' '.lang('function updated');
			}else{
				// Nouveau
				$this->so_function->data['function_id'] = '';
				$this->so_function->data['creation_date']=time();
				$this->so_function->data['creator']=$GLOBALS['egw_info']['user']['account_id'];
				$this->so_function->save();
				
				$msg .= ' '.lang('function created');
			}
		}
		return $msg;
	}
}
?>