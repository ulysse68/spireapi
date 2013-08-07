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
class vat_so extends so_sql{
	
	var $spireapi_vat = 'spireapi_vat';
	
	var $so_vat;
	
	/**
	 * Constructeur
	 *
	 */
	function vat_so(){
		$this->so_vat = new so_sql('spireapi',$this->spireapi_vat);
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


	function add_update_vat($info){
	/**
	 * Crée ou met à jour un taux
	 *
	 * @param $info : information concernant le taux
	 */
		$msg='';
		if(is_array($info)){
			$this->so_vat->data = $info;

			if(isset($this->so_vat->data['vat_id'])){
				// Existant
				$this->so_vat->data['date_modified']=time();
				$this->so_vat->data['modifier']=$GLOBALS['egw_info']['user']['account_id'];
				$this->so_vat->update($this->so_vat->data,true);
				
				$msg .= ' '.lang('vat updated');
			}else{
				// Nouveau
				$this->so_vat->data['vat_id'] = '';
				$this->so_vat->data['creation_date']=time();
				$this->so_vat->data['creator']=$GLOBALS['egw_info']['user']['account_id'];
				$this->so_vat->save();
				
				$msg .= ' '.lang('vat created');
			}
		}
		return $msg;
	}
}
?>