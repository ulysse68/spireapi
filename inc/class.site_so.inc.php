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
class site_so extends so_sql{
	
	var $spireapi_site = 'spireapi_site';
	
	var $so_site;
	
	/**
	 * Constructeur
	 *
	 */
	function site_so(){
		$this->so_site = new so_sql('spireapi',$this->spireapi_site);
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


	function add_update_site($info){
	/**
	 * Crée ou met à jour un site
	 *
	 * @param $info : information concernant le site
	 */
		$msg='';
		if(is_array($info)){
			$this->so_site->data = $info;

			if(isset($this->so_site->data['site_id'])){
				// Existant
				$this->so_site->data['date_modified']=time();
				$this->so_site->data['modifier']=$GLOBALS['egw_info']['user']['account_id'];
				$this->so_site->update($this->so_site->data,true);
				
				$msg .= ' '.lang('Site updated');
			}else{
				// Nouveau
				$this->so_site->data['site_id'] = '';
				$this->so_site->data['creation_date']=time();
				$this->so_site->data['creator']=$GLOBALS['egw_info']['user']['account_id'];
				$this->so_site->save();
				
				$msg .= ' '.lang('Site created');
			}
		}
		return $msg;
	}
}
?>