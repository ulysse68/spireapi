<?php
/**
 * eGroupWare - Setup
 * http://www.egroupware.org
 * Created by eTemplates DB-Tools written by ralfbecker@outdoor-training.de
 *
 * @license http://opensource.org/licenses/gpl-license.php GPL - GNU General Public License
 * @package spireapi
 * @subpackage setup
 * @version $Id$
 */

function spireapi_upgrade0_001()
{
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_site','site_parent',array(
		'type' => 'int',
		'precision' => '4'
	));*/
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_site','site_street',array(
		'type' => 'varchar',
		'precision' => '64'
	));*/
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_site','site_street2',array(
		'type' => 'varchar',
		'precision' => '64'
	));*/
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_site','site_city',array(
		'type' => 'varchar',
		'precision' => '64'
	));*/
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_site','site_country',array(
		'type' => 'varchar',
		'precision' => '64'
	));*/
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_site','site_postalcode',array(
		'type' => 'varchar',
		'precision' => '64'
	));*/
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_site','site_tel',array(
		'type' => 'varchar',
		'precision' => '40'
	));*/
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_site','site_fax',array(
		'type' => 'varchar',
		'precision' => '40'
	));*/
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_site','site_mail',array(
		'type' => 'varchar',
		'precision' => '128'
	));*/
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_site','site_color',array(
		'type' => 'varchar',
		'precision' => '20'
	));*/
	$GLOBALS['egw_setup']->oProc->RefreshTable('spireapi_site',array(
		'fd' => array(
			'site_id' => array('type' => 'auto','nullable' => False),
			'site_label' => array('type' => 'varchar','precision' => '255','nullable' => False),
			'site_active' => array('type' => 'bool'),
			'site_appname' => array('type' => 'varchar','precision' => '255'),
			'creator' => array('type' => 'int','precision' => '4'),
			'creation_date' => array('type' => 'int','precision' => '20'),
			'modifier' => array('type' => 'int','precision' => '4'),
			'date_modified' => array('type' => 'int','precision' => '20'),
			'site_parent' => array('type' => 'int','precision' => '4'),
			'site_street' => array('type' => 'varchar','precision' => '64'),
			'site_street2' => array('type' => 'varchar','precision' => '64'),
			'site_city' => array('type' => 'varchar','precision' => '64'),
			'site_country' => array('type' => 'varchar','precision' => '64'),
			'site_postalcode' => array('type' => 'varchar','precision' => '64'),
			'site_tel' => array('type' => 'varchar','precision' => '40'),
			'site_fax' => array('type' => 'varchar','precision' => '40'),
			'site_mail' => array('type' => 'varchar','precision' => '128'),
			'site_color' => array('type' => 'varchar','precision' => '20')
		),
		'pk' => array('site_id'),
		'fk' => array('site_parent' => 'spireapi_site'),
		'ix' => array(),
		'uc' => array()
	));

	return $GLOBALS['setup_info']['spireapi']['currentver'] = '0.002';
}


function spireapi_upgrade0_002()
{
	$GLOBALS['egw_setup']->oProc->CreateTable('spireapi_vat',array(
		'fd' => array(
			'vat_id' => array('type' => 'auto','nullable' => False),
			'vat_label' => array('type' => 'varchar','precision' => '255','nullable' => False),
			'vat_rate' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'vat_source' => array('type' => 'varchar','precision' => '255'),
			'creator' => array('type' => 'int','precision' => '4'),
			'creation_date' => array('type' => 'int','precision' => '20'),
			'modifier' => array('type' => 'int','precision' => '4'),
			'date_modified' => array('type' => 'int','precision' => '20')
		),
		'pk' => array('vat_id'),
		'fk' => array(),
		'ix' => array(),
		'uc' => array()
	));

	return $GLOBALS['setup_info']['spireapi']['currentver'] = '0.003';
}


function spireapi_upgrade0_003()
{
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_vat','vat_appname',array(
		'type' => 'varchar',
		'precision' => '255'
	));
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_vat','vat_active',array(
		'type' => 'bool'
	));

	return $GLOBALS['setup_info']['spireapi']['currentver'] = '0.004';
}


function spireapi_upgrade0_004()
{
	$GLOBALS['egw_setup']->oProc->CreateTable('spireapi_function',array(
		'fd' => array(
			'function_id' => array('type' => 'auto','nullable' => False),
			'function_code' => array('type' => 'varchar','precision' => '255'),
			'function_title' => array('type' => 'varchar','precision' => '255'),
			'function_parent' => array('type' => 'int','precision' => '4'),
			'function_active' => array('type' => 'bool'),
			'creator' => array('type' => 'int','precision' => '4'),
			'creation_date' => array('type' => 'int','precision' => '20'),
			'modifier' => array('type' => 'int','precision' => '4'),
			'date_modified' => array('type' => 'int','precision' => '20')
		),
		'pk' => array('function_id'),
		'fk' => array('function_parent' => 'spireapi_function'),
		'ix' => array(),
		'uc' => array()
	));

	return $GLOBALS['setup_info']['spireapi']['currentver'] = '0.005';
}


function spireapi_upgrade0_005()
{
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_employee','employee_function',array(
		'type' => 'int',
		'precision' => '4'
	));*/
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_employee','employee_team',array(
		'type' => 'int',
		'precision' => '4'
	));*/
	/* done by RefreshTable() anyway
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_employee','employee_note',array(
		'type' => 'text'
	));*/
	$GLOBALS['egw_setup']->oProc->RefreshTable('spireapi_employee',array(
		'fd' => array(
			'account_id' => array('type' => 'int','precision' => '4','nullable' => False),
			'employee_number' => array('type' => 'varchar','precision' => '255'),
			'employee_day_time' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'employee_week_time' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'employee_month_time' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'employee_area' => array('type' => 'int','precision' => '4'),
			'employee_site' => array('type' => 'int','precision' => '4'),
			'employee_manager' => array('type' => 'int','precision' => '4'),
			'employee_file' => array('type' => 'bool'),
			'employee_car' => array('type' => 'int','precision' => '4'),
			'employee_hour_rate' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'employee_internal_number' => array('type' => 'varchar','precision' => '255'),
			'employee_active' => array('type' => 'bool'),
			'creator' => array('type' => 'int','precision' => '4'),
			'creation_date' => array('type' => 'int','precision' => '20'),
			'modifier' => array('type' => 'int','precision' => '4'),
			'date_modified' => array('type' => 'int','precision' => '20'),
			'employee_function' => array('type' => 'int','precision' => '4'),
			'employee_team' => array('type' => 'int','precision' => '4'),
			'employee_note' => array('type' => 'text')
		),
		'pk' => array('account_id'),
		'fk' => array('account_id' => 'egw_accounts','employee_function' => 'spireapi_function'),
		'ix' => array(),
		'uc' => array()
	));

	return $GLOBALS['setup_info']['spireapi']['currentver'] = '0.006';
}


function spireapi_upgrade0_006()
{
	$GLOBALS['egw_setup']->oProc->CreateTable('spireapi_team',array(
		'fd' => array(
			'team_id' => array('type' => 'auto','nullable' => False),
			'team_code' => array('type' => 'varchar','precision' => '255'),
			'team_title' => array('type' => 'varchar','precision' => '255'),
			'team_parent' => array('type' => 'int','precision' => '4'),
			'team_costing_code' => array('type' => 'varchar','precision' => '255'),
			'team_project_code' => array('type' => 'varchar','precision' => '255'),
			'team_active' => array('type' => 'bool'),
			'creator' => array('type' => 'int','precision' => '4'),
			'creation_date' => array('type' => 'int','precision' => '20'),
			'modifier' => array('type' => 'int','precision' => '4'),
			'date_modified' => array('type' => 'int','precision' => '20')
		),
		'pk' => array('team_id'),
		'fk' => array('team_parent' => 'spireapi_team'),
		'ix' => array(),
		'uc' => array()
	));

	return $GLOBALS['setup_info']['spireapi']['currentver'] = '0.007';
}


function spireapi_upgrade0_007()
{
	$GLOBALS['egw_setup']->oProc->CreateTable('spireapi_employee_data',array(
		'fd' => array(
			'employee_data_id' => array('type' => 'auto','nullable' => False),
			'account_id' => array('type' => 'int','precision' => '4'),
			'employee_data_date_start' => array('type' => 'int','precision' => '20'),
			'employee_data_date_end' => array('type' => 'int','precision' => '20'),
			'employee_data_date_history' => array('type' => 'int','precision' => '20'),
			'employee_data_hourly_cost' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'employee_data_hourly_turnover' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'employee_data_daily_cost' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'employee_data_daily_turnover' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'employee_data_monthly_turnover_objective' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'employee_data_monthly_ratio_objective' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'employee_data_yearly_turnover_objective' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'employee_data_yearly_ratio_objective' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'creator' => array('type' => 'int','precision' => '4'),
			'creation_date' => array('type' => 'int','precision' => '20'),
			'modifier' => array('type' => 'int','precision' => '4'),
			'date_modified' => array('type' => 'int','precision' => '20')
		),
		'pk' => array('employee_data_id'),
		'fk' => array(),
		'ix' => array(),
		'uc' => array()
	));

	return $GLOBALS['setup_info']['spireapi']['currentver'] = '0.008';
}


function spireapi_upgrade0_008()
{
	$GLOBALS['egw_setup']->oProc->RenameColumn('spireapi_team','team_costing_code','team_cost_center');
	$GLOBALS['egw_setup']->oProc->RenameColumn('spireapi_team','team_project_code','team_profit_center');

	return $GLOBALS['setup_info']['spireapi']['currentver'] = '0.009';
}


function spireapi_upgrade0_009()
{
	$GLOBALS['egw_setup']->oProc->AlterColumn('spireapi_team','team_code',array(
		'type' => 'varchar',
		'precision' => '20'
	));
	$GLOBALS['egw_setup']->oProc->AlterColumn('spireapi_team','team_cost_center',array(
		'type' => 'varchar',
		'precision' => '20'
	));
	$GLOBALS['egw_setup']->oProc->AlterColumn('spireapi_team','team_profit_center',array(
		'type' => 'varchar',
		'precision' => '20'
	));
	$GLOBALS['egw_setup']->oProc->AddColumn('spireapi_team','team_project_code',array(
		'type' => 'varchar',
		'precision' => '20'
	));

	return $GLOBALS['setup_info']['spireapi']['currentver'] = '0.010';
}


function spireapi_upgrade0_010()
{
	$GLOBALS['egw_setup']->oProc->CreateTable('spireapi_translation',array(
		'fd' => array(
			'trans_id' => array('type' => 'auto','nullable' => False),
			'trans_key' => array('type' => 'varchar','precision' => '50'),
			'trans_appname' => array('type' => 'varchar','precision' => '50'),
			'trans_value' => array('type' => 'text'),
			'trans_lang' => array('type' => 'varchar','precision' => '5'),
			'trans_creator' => array('type' => 'int','precision' => '4'),
			'trans_created' => array('type' => 'int','precision' => '20'),
			'trans_modifier' => array('type' => 'int','precision' => '4'),
			'trans_modified' => array('type' => 'int','precision' => '20')
		),
		'pk' => array('trans_id'),
		'fk' => array(),
		'ix' => array(),
		'uc' => array()
	));

	return $GLOBALS['setup_info']['spireapi']['currentver'] = '0.011';
}

