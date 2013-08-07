<?php
/**
 * eGroupware - Spireapi 
 * SpireAPI : Module and functions set to manage referentials in eGroupware 
 *
 * @link http://www.spirea.fr
 * @package spireapi
 * @author Spirea SARL <contact@spirea.fr>
 * @copyright (c) 2012-10 by Spirea
 * @license http://opensource.org/licenses/gpl-license.php GPL - GNU General Public License
  */

class admin_so extends so_sql{
		
	var $spireapi_statut = 'spireapi_ref_dossier_statut';
	var $spireapi_statut_fichier = 'spireapi_ref_fichier_statut';
	
	var $so_statut;
	var $so_statut_fichier;
	
	var $config;
	
	function admin_so(){
	/**
	 * Constructeur
	 *
	 */
		/* Récupération les infos de configurations */
		$config = CreateObject('phpgwapi.config');
		$this->config = $config->read('spireapi');	
	}

}
?>