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

SugarAutoLoader::requireWithCustom('include/ScheduleGenerateUsersNews/ScheduleGenerateUsersNews.php');
SugarAutoLoader::requireWithCustom('include/SugarQueue/SugarJobQueue.php');

class NewsApi
{

    public function setNewsStatus($args)
    {
        if (isset($args['status']) && isset($args['news_id'])) {
            $news = BeanFactory::getBean('News', $args['news_id']);
            if ((!$news && empty($news->id)) || ($news->news_type == 'announcement' && !$this->scheduleGenerateUsersNews($news))) {
                return false;
            }
            $news->news_status = $args['status'];
            $news->save();
            return true;
        }
        return false;
    }

    protected function scheduleGenerateUsersNews(&$news)
    {
        try {
            $SGUN = new ScheduleGenerateUsersNews($news);
            return $SGUN->schedule();
        } catch (Exception $ex) {
            $GLOBALS['log']->fatal($ex->getTraceAsString());
            return false;
        }
    }

    public function hasNewsTarget($args)
    {
        $return = false;
        if (isset($args['news_id'])) {
            global $db;
            $id = $db->quote($args['news_id']);
            $sql = "SELECT count(*) AS num FROM prospect_list_news pln
                    JOIN prospect_lists pl ON pl.id=pln.prospectlist_id AND pl.deleted=0
                    JOIN prospect_lists_prospects plp ON plp.deleted=0 AND plp.prospect_list_id=pl.id
                    WHERE pln.deleted=0 AND pln.news_id='{$id}'";
            $return = $db->getOne($sql) ? true : false;
        }
        return $return;
    }

}
