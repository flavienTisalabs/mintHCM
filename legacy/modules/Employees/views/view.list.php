<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

require_once 'include/MVC/View/views/view.list.php';

class EmployeesViewList extends ViewList
{
    public function preDisplay()
    {
        $this->lv = new ListViewSmarty();
        $this->lv->delete = false;
        $this->lv->email = false;
        if (!$GLOBALS['current_user']->isAdminForModule('Users')) {
            $this->lv->multiSelect = false;
        }
    }

    /**
     * Overridden from ViewList prepareSearchForm so we can tack on some additional where clauses
     *
     */
    public function prepareSearchForm()
    {
        parent::prepareSearchForm();
        require_once 'modules/Employees/EmployeesSearchForm.php';
        $newForm = new EmployeesSearchForm($this->searchForm);
        $this->searchForm = $newForm;
    }

    /**
     * Return the "breadcrumbs" to display at the top of the page
     *
     * @param  bool $show_help optional, true if we show the help links
     * @return HTML string containing breadcrumb title
     */
    public function getModuleTitle($show_help = true)
    {
        global $sugar_version, $sugar_flavor, $server_unique_key, $current_language, $action, $current_user;

        $theTitle = "<div class='moduleTitle'>\n<h2>";

        $module = preg_replace("/ /", "", $this->module);

        $params = $this->_getModuleTitleParams();
        $count = count($params);
        $index = 0;

        if (SugarThemeRegistry::current()->directionality == "rtl") {
            $params = array_reverse($params);
        }

        $paramString = '';
        foreach ($params as $parm) {
            $index++;
            $paramString .= $parm;
            if ($index < $count) {
                $paramString .= $this->getBreadCrumbSymbol();
            }
        }

        if (!empty($paramString)) {
            $theTitle .= "<h2> $paramString </h2>\n";
        }

        if ($show_help) {
            $theTitle .= "<span class='utils'>";
            if (is_admin($current_user) || is_admin_for_module($current_user, $this->module)) {
                $createImageURL = SugarThemeRegistry::current()->getImageURL('create-record.gif');
                $theTitle .= <<<EOHTML
&nbsp;
<a href="index.php?module={$module}&action=EditView&return_module={$module}&return_action=DetailView" class="utilsLink">
<img src='{$createImageURL}' alt='{$GLOBALS['app_strings']['LNK_CREATE']}'></a>
<a href="index.php?module={$module}&action=EditView&return_module={$module}&return_action=DetailView" class="utilsLink">
{$GLOBALS['app_strings']['LNK_CREATE']}
</a>
EOHTML;
            }
        }

        $theTitle .= "</span></div>\n";
        return $theTitle;
    }

    public function listViewPrepare()
    {
        require_once 'modules/MySettings/StoreQuery.php';

        // MintHCM #107081 START
        if (empty($_REQUEST['clear_query'])
            && !isset($_REQUEST['open_only_active_users_basic'])
            && !isset($_REQUEST['lvso'])
        ) {
            $_REQUEST['searchFormTab'] = $_POST['searchFormTab'] = 'basic_search';
            $_REQUEST['open_only_active_users_basic'] = $_POST['open_only_active_users_basic'] = '1';
        }

        echo "<script src=\"modules/Employees/js/view.list.js\" defer></script>";
        // MintHCM #107081 END

        $storeQuery = new StoreQuery();
        $storeQuery->loadQuery($this->module);
        $storeQuery->SaveQuery($this->module);
        if ($_REQUEST['clear_query'] != "true") {
            $keys = array_keys($storeQuery->query);
            foreach ($keys as $key) {
                if (preg_match('/_basic$/', $key) == 1 || preg_match('/_advanced$/', $key) == 1) {
                    unset($_REQUEST['query']);
                    break;
                }
            }
        }
        parent::listViewPrepare();
    }

    public function listViewProcess()
    {

        $this->processSearchForm();
        $this->lv->searchColumns = $this->searchForm->searchColumns;

        if (!$this->headers) {
            return;
        }

        if (empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false) {
            $this->lv->ss->assign("SEARCH", true);
            $this->lv->ss->assign('savedSearchData', $this->searchForm->getSavedSearchData());

            $tplFile = 'include/ListView/ListViewGeneric.tpl';
            if (!$GLOBALS['current_user']->isAdminForModule('Users')) {
                $tplFile = 'include/ListView/ListViewNoMassUpdate.tpl';
            }
            if (!empty($this->where)) {
                $this->where .= " AND ";
            }
            $this->where .= "(users.status <> 'Reserved' or users.status is null) ";
            $this->lv->setup($this->seed, $tplFile, $this->where, $this->params);
            $savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
            echo $this->lv->display();
        }
    }

    /**
     * Process Search Form
     */
    public function processSearchForm()
    {
        if (isset($_REQUEST['query'])) {
            // we have a query
            if (!empty($_SERVER['HTTP_REFERER']) && preg_match('/action=EditView/', $_SERVER['HTTP_REFERER'])) { // from EditView cancel
                $this->searchForm->populateFromArray($this->storeQuery->query);
            } else {
                $this->searchForm->populateFromRequest();
            }
        }
        $where_clauses = $this->searchForm->generateSearchWhere(true, $this->seed->module_dir);

        if (count($where_clauses) > 0) {
            $this->where = '(' . implode(' ) AND ( ', $where_clauses) . ')';
        }
        $GLOBALS['log']->info("List View Where Clause: $this->where");
        
        if ($this->use_old_search) {
            switch (isset($view) ? $view : null) {
                case 'basic_search':
                    $this->searchForm->setup();
                    $this->searchForm->displayBasic($this->headers);
                    break;
                case 'advanced_search':
                    $this->searchForm->setup();
                    $this->searchForm->displayAdvanced($this->headers);
                    break;
                case 'saved_views':
                    echo $this->searchForm->displaySavedViews($this->listViewDefs, $this->lv, $this->headers);
                    break;
            }
        } else {
            $output = $this->searchForm->display($this->headers);
            $this->savedSearchData = $this->searchForm->getSavedSearchData();
            echo $output;
        }
    }
}
