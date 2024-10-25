<?php


/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * MintHCM is a Human Capital Management software based on SuiteCRM developed by MintHCM, 
 * Copyright (C) 2018-2023 MintHCM
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by SugarCRM" 
 * logo and "Supercharged by SuiteCRM" logo and "Reinvented by MintHCM" logo. 
 * If the display of the logos is not reasonably feasible for technical reasons, the 
 * Appropriate Legal Notices must display the words "Powered by SugarCRM" and 
 * "Supercharged by SuiteCRM" and "Reinvented by MintHCM".
 */

$popupMeta = array(
   'moduleMain' => 'Contracts',
   'varName' => 'Contracts',
   'orderBy' => 'contracts.name',
   'whereClauses' => array(
      'name' => 'contracts.name',
      'status' => 'contracts.status',
      'contract_type' => 'contracts.contract_type',
      'daily_working_time' => 'contracts.daily_working_time',
      'date_of_signing' => 'contracts.date_of_signing',
      'contract_starting_date' => 'contracts.contract_starting_date',
      'contract_ending_date' => 'contracts.contract_ending_date',
      'assigned_user_id' => 'contracts.assigned_user_id',
   ),
   'searchInputs' => array(
      'name',
      'status',
      'contract_type',
      'daily_working_time',
      'date_of_signing',
      'contract_starting_date',
      'contract_ending_date',
      'assigned_user_id',
   ),
   'searchdefs' => array(
      'name' =>
      array(
         'name' => 'name',
         'width' => '10%',
      ),
      'status' =>
      array(
         'type' => 'enum',
         'studio' => 'visible',
         'label' => 'LBL_STATUS',
         'width' => '10%',
         'name' => 'status',
      ),
      'periodofemployment_name' =>
      array(
         'type' => 'enum',
         'label' => 'LBL_PERIODOFEMPLOYMENT_NAME',
         'width' => '10%',
         'name' => 'periodofemployment_name',
      ),
      'contract_type' =>
      array(
         'type' => 'enum',
         'studio' => 'visible',
         'label' => 'LBL_CONTRACT_TYPE',
         'width' => '10%',
         'name' => 'contract_type',
      ),
      'daily_working_time' =>
      array(
         'type' => 'enum',
         'studio' => 'visible',
         'label' => 'LBL_DAILY_WORKING_TIME',
         'width' => '10%',
         'name' => 'daily_working_time',
      ),
      'date_of_signing' =>
      array(
         'type' => 'date',
         'label' => 'LBL_DATE_OF_SIGNING',
         'width' => '10%',
         'name' => 'date_of_signing',
      ),
      'contract_starting_date' =>
      array(
         'type' => 'date',
         'label' => 'LBL_CONTRACT_STARTING_DATE',
         'width' => '10%',
         'name' => 'contract_starting_date',
      ),
      'contract_ending_date' =>
      array(
         'type' => 'date',
         'label' => 'LBL_CONTRACT_ENDING_DATE',
         'width' => '10%',
         'name' => 'contract_ending_date',
      ),
      'employee_name' =>
      array(
         'name' => 'employee_id',
         'label' => 'LBL_EMPLOYEE_NAME',
         'type' => 'enum',
         'function' =>
         array(
            'name' => 'get_user_array',
            'params' =>
            array(
               false,
            ),
         ),
         'default' => true,
         'width' => '10%',
      ),
      'assigned_user_id' =>
      array(
         'name' => 'assigned_user_id',
         'label' => 'LBL_ASSIGNED_TO',
         'type' => 'enum',
         'function' =>
         array(
            'name' => 'get_user_array',
            'params' =>
            array(
               0 => false,
            ),
         ),
         'width' => '10%',
      ),
   ),
);
