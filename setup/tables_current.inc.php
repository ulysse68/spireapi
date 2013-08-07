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


$phpgw_baseline = array(
	'spireapi_employee' => array(
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
	),
	'spireapi_site' => array(
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
			'site_color' => array('type' => 'varchar','precision' => '20'),
			'site_responsible' => array('type' => 'int','precision' => '4'),
			'site_group' => array('type' => 'int','precision' => '4')
		),
		'pk' => array('site_id'),
		'fk' => array('site_parent' => 'spireapi_site'),
		'ix' => array(),
		'uc' => array()
	),
	'spireapi_area' => array(
		'fd' => array(
			'area_id' => array('type' => 'auto','nullable' => False),
			'area_label' => array('type' => 'varchar','precision' => '255','nullable' => False),
			'area_active' => array('type' => 'bool'),
			'area_appname' => array('type' => 'varchar','precision' => '255','nullable' => True),
			'creator' => array('type' => 'int','precision' => '4'),
			'creation_date' => array('type' => 'int','precision' => '20'),
			'modifier' => array('type' => 'int','precision' => '4'),
			'date_modified' => array('type' => 'int','precision' => '20')
		),
		'pk' => array('area_id'),
		'fk' => array(),
		'ix' => array(),
		'uc' => array()
	),
	'spireapi_vat' => array(
		'fd' => array(
			'vat_id' => array('type' => 'auto','nullable' => False),
			'vat_label' => array('type' => 'varchar','precision' => '255','nullable' => False),
			'vat_rate' => array('type' => 'decimal','precision' => '10','scale' => '2'),
			'vat_source' => array('type' => 'varchar','precision' => '255'),
			'creator' => array('type' => 'int','precision' => '4'),
			'creation_date' => array('type' => 'int','precision' => '20'),
			'modifier' => array('type' => 'int','precision' => '4'),
			'date_modified' => array('type' => 'int','precision' => '20'),
			'vat_appname' => array('type' => 'varchar','precision' => '255'),
			'vat_active' => array('type' => 'bool')
		),
		'pk' => array('vat_id'),
		'fk' => array(),
		'ix' => array(),
		'uc' => array()
	),
	'spireapi_function' => array(
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
	),
	'spireapi_team' => array(
		'fd' => array(
			'team_id' => array('type' => 'auto','nullable' => False),
			'team_code' => array('type' => 'varchar','precision' => '20'),
			'team_title' => array('type' => 'varchar','precision' => '255'),
			'team_parent' => array('type' => 'int','precision' => '4'),
			'team_cost_center' => array('type' => 'varchar','precision' => '20'),
			'team_profit_center' => array('type' => 'varchar','precision' => '20'),
			'team_active' => array('type' => 'bool'),
			'creator' => array('type' => 'int','precision' => '4'),
			'creation_date' => array('type' => 'int','precision' => '20'),
			'modifier' => array('type' => 'int','precision' => '4'),
			'date_modified' => array('type' => 'int','precision' => '20'),
			'team_project_code' => array('type' => 'varchar','precision' => '20')
		),
		'pk' => array('team_id'),
		'fk' => array('team_parent' => 'spireapi_team'),
		'ix' => array(),
		'uc' => array()
	),
	'spireapi_employee_data' => array(
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
	),
	'spireapi_translation' => array(
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
	)
);
