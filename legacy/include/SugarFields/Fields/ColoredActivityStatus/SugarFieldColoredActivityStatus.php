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
require_once 'include/SugarFields/Fields/Enum/SugarFieldEnum.php';

class SugarFieldColoredActivityStatus extends SugarFieldEnum
{
    const STATUS_STYLES = [
        'Planned' => "color:#6f6f6f;border:solid 1px;padding:5px 12px;border-radius:7px;border-color:#84d2e4;background:#f5fcff;white-space:nowrap",
        'Held' => "color:#6f6f6f;border:solid 1px;padding:5px 12px;border-radius:7px;border-color:#afedad;background:#f5fff5;white-space:nowrap",
        'Not Held' => "color:#6f6f6f;border:solid 1px;padding:5px 12px;border-radius:7px;border-color:#ed8083;background:#fff5f5;white-space:nowrap",
    ];

   /**
    * @param array $parentFieldArray
    * @param array $vardef
    * @param array $displayParams
    * @param string $col (unused)
    * @return string
    */
    public function getListViewSmarty($parentFieldArray, $vardef, $displayParams, $col)
    {
      $tabindex = 1;
      //fixing bug #46666: don't need to format enum and radioenum fields
      //because they are already formated in SugarBean.php in the function get_list_view_array() as fix of bug #21672
        if ('Enum' != $this->type && 'Radioenum' != $this->type) {
         $parentFieldArray = $this->setupFieldArray($parentFieldArray, $vardef);
      } else {
         $vardef['name'] = strtoupper($vardef['name']);
      }

      $this->setup($parentFieldArray, $vardef, $displayParams, $tabindex, false);

      $this->ss->left_delimiter = '{';
      $this->ss->right_delimiter = '}';
      $this->ss->assign('col', $vardef['name']);

      global $app_list_strings;
      $value = array_search($parentFieldArray[$vardef['name']], $app_list_strings[$vardef['options']]);
        $this->ss->assign('style', static::STATUS_STYLES[$value]);
      return $this->fetch($this->findTemplate('ListView'));
   }
    public function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex)
    {
        global $app_list_strings;
        if (isset($vardef['name'])) {
            $status = $vardef['options'][$vardef['value']];
            if ("Calls" == $vardef['field_module_name']) {
                $bean = BeanFactory::getBean($vardef['field_module_name'], $vardef['field_record']);
                if (!empty($bean) && $bean->id === $vardef['field_record']) {
                    $status = $app_list_strings[$bean->field_defs['direction']['options']][$bean->direction] . " " . $status;
                }
            }
        }

        $this->ss->assign("status", $status);
        $displayParams['style'] = static::STATUS_STYLES[$vardef['value']];
        return parent::getDetailViewSmarty($parentFieldArray, $vardef, $displayParams, $tabindex);
}
}