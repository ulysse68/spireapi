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
class trans_so extends so_sql{
	
	var $spireapi_trans = 'spireapi_translation';
	
	var $so_trans;
	
	/**
	 * Constructeur
	 *
	 */
	function trans_so(){
		$this->so_trans = new so_sql('spireapi',$this->spireapi_trans);
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


	function add_update_trans($info){
	/**
	 * Crée ou met à jour une traduction
	 *
	 * @param $info : information concernant la traduction
	 */
		$msg='';
		if(is_array($info)){
			
			// Verification que l'association mot cle/appli/lang n'existe pas deja
			$exist = $this->so_trans->search(array('trans_key' => $info['trans_key'],'trans_lang' => $info['trans_lang'],'trans_appname' => $info['trans_appname']),false);
			
			if(is_array($exist)){
				$msg = lang('Error while saving').' : '.lang('A translation already exist for the selected key/app/lang association');
			}else{		
				$this->so_trans->data = $info;

				if(isset($this->so_trans->data['trans_id'])){
					// Existant
					$this->so_trans->data['trans_modified']=time();
					$this->so_trans->data['trans_modifier']=$GLOBALS['egw_info']['user']['account_id'];
					$this->so_trans->update($this->so_trans->data,true);
					
					$msg = lang('translation updated');
				}else{
					// Nouveau
					$this->so_trans->data['trans_id'] = '';
					$this->so_trans->data['trans_created']=time();
					$this->so_trans->data['trans_creator']=$GLOBALS['egw_info']['user']['account_id'];
					$this->so_trans->save();
					
					$msg = lang('translation created');
				}
			}
		}
		return $msg;
	}

	static function translate($lang, $key, $app){
	/**
	 * Fonction permettant la traduction d'un mot clé dans la langue choisit
	 *
	 * @param $lang : langue dans laquel on souhaite traduire le message
	 * @param $key : mot clé à traduire
	 * @param $app : application pour laquel on souhaite faire la traduction
	 * @return string (mot clé traduit)
	 */
		$so_trans = new so_sql('spireapi','spireapi_translation');

		$translation = $so_trans->search(array('trans_key' => $key, 'trans_lang' => $lang, 'trans_appname' => array($app,'global')),false);
		
		if(is_array($translation)){
			return $translation[0]['trans_value'];
		}else{
			$translation = $so_trans->search(array('trans_key' => $key, 'trans_lang' => $GLOBALS['egw_info']['user']['preferences']['common']['lang'], 'trans_appname' => array($app,'global')),false);
			return $translation[0]['trans_value'];
		}
	}
}
?>