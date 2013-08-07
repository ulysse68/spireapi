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
class employee_so extends so_sql{
	
	var $spireapi_employee = 'spireapi_employee';
	var $spireapi_site = 'spireapi_site';
	var $spireapi_area = 'spireapi_area';
	var $spireapi_function = 'spireapi_function';
	var $spireapi_team = 'spireapi_team';
	var $spireapi_employee_data = 'spireapi_employee_data';
	
	var $so_employee;
	var $so_site;
	var $so_area;
	var $so_function;
	var $so_team;
	var $so_employee_data;
	
	/**
	 * Constructeur
	 *
	 */
	function employee_so(){
		$this->so_employee = new so_sql('spireapi',$this->spireapi_employee);
		$this->so_site = new so_sql('spireapi',$this->spireapi_site);
		$this->so_area = new so_sql('spireapi',$this->spireapi_area);
		$this->so_function = new so_sql('spireapi',$this->spireapi_function);
		$this->so_team = new so_sql('spireapi',$this->spireapi_team);
		$this->so_employee_data = new so_sql('spireapi',$this->spireapi_employee_data);
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

	function add_update_employee($info){
	/**
	 * Crée ou met à jour un employé
	 *
	 * @param $info : information concernant le statut
	 */
		$msg='';
		if(is_array($info)){

			$existant = $this->so_employee->read($info['account_id']);
			$this->so_employee->data = $info;

			if(!is_array($existant)){
				// L'employée n'existe pas
				$this->so_employee->data = $info;
				$this->so_employee->data['creation_date']=time();
				$this->so_employee->data['creator']=$GLOBALS['egw_info']['user']['account_id'];
				$this->so_employee->save();
			
				$msg .= ' '.lang('Employee created');
			}else{
				// Employée existant
				if(isset($this->so_employee->data['creation_date'])){
					// Date de création = on modifie un employée
					$this->so_employee->data['date_modified']=time();
					$this->so_employee->data['modifier']=$GLOBALS['egw_info']['user']['account_id'];
					$this->so_employee->update($this->so_employee->data,true);
					
					$msg .= ' '.lang('Employee updated');
				}else{
					// Pas de date de création = on tente de crée avec un compte deja utilisé
					$msg .= lang('Error while saving').' : '.lang('Employee already exists');
					unset($this->so_employee->data['account_id']);
				}
			}
		}
		return $msg;
	}

	function add_update_employee_data($info){
	/**
	 * Crée ou met à jour une info employée
	 *
	 * @param $info : information 
	 */
		$msg='';
		if(is_array($info)){
			unset($info['button']);
			unset($info['nm']);
			unset($info['msg']);
			$this->so_employee_data->data = $info;
			
			// Vérifications dates
			if ($info['employee_data_date_end'] <= $info['employee_data_date_start']){
				$msg .= ' '.lang('Error while saving').' : '.lang('End date must be after the start date');
			}
			
			// Verification du chevauchements
			if(isset($this->so_employee_data->data['employee_data_id'])){
				$join = 'WHERE employee_data_id <> '.$info['employee_data_id'].' AND (employee_data_date_start BETWEEN '.$info['employee_data_date_start'].' AND '.$info['employee_data_date_end'].' OR employee_data_date_end BETWEEN '.$info['employee_data_date_start'].' AND '.$info['employee_data_date_end'].' OR (employee_data_date_start < '.$info['employee_data_date_start'].' AND employee_data_date_end > '.$info['employee_data_date_end'].'))';
			}else{
				$join = 'WHERE (employee_data_date_start BETWEEN '.$info['employee_data_date_start'].' AND '.$info['employee_data_date_end'].' OR employee_data_date_end BETWEEN '.$info['employee_data_date_start'].' AND '.$info['employee_data_date_end'].' OR (employee_data_date_start < '.$info['employee_data_date_start'].' AND employee_data_date_end > '.$info['employee_data_date_end'].'))';
				
			}
			$check = $this->so_employee_data->search(array('account_id'=>$info['account_id']),'','','',$wildcard,false,$op,$start,array(),$join);

			if(is_array($check)){
				// Chevauchements
				$msg .= ' '.lang('Error while saving').' : '.lang('Employee data is overlapping with another data');
			}else{
				if(isset($this->so_employee_data->data['employee_data_id'])){
					// Existant
					$this->so_employee_data->data['date_modified']=time();
					$this->so_employee_data->data['modifier']=$GLOBALS['egw_info']['user']['account_id'];
					$this->so_employee_data->update($this->so_employee_data->data,true);
					
					$msg .= ' '.lang('Employee data updated');
				}else{
					// Nouveau
					$this->so_employee_data->data = $info;
					$this->so_employee->data['creation_date']=time();
					$this->so_employee_data->data['creator']=$GLOBALS['egw_info']['user']['account_id'];
					$this->so_employee_data->save();
					
					$msg .= ' '.lang('Employee data created');
				}
			}
		}
		return $msg;
	}
}
?>