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

require_once 'include/MVC/View/views/view.edit.php';

class KTemplatesViewWizard extends ViewEdit
{

    public $ev;
    public $type = 'wizard';
    public $useForSubpanel = false; //boolean variable to determine whether view can be used for subpanel creates
    public $useModuleQuickCreateTemplate = false; //boolean variable to determine whether or not SubpanelQuickCreate has a separate display function
    public $showTitle = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function preDisplay()
    {
        parent::preDisplay();
        $metadataFile = $this->getMetaDataFile($this->module);
        $this->ev = new EditView();
        $this->ev->view = "WizardView";
        $this->ev->ss = &$this->ss;
        $this->ev->setup($this->module, $this->bean, $metadataFile);
    }

    public function getMetaDataFile($module = null)
    {
        $metadataFile = null;
        $foundViewDefs = false;
        if (file_exists('custom/modules/' . $module . '/metadata/wizarddefs.php')) {
            $metadataFile = 'custom/modules/' . $module . '/metadata/wizarddefs.php';
            $foundViewDefs = true;
        } else {
            if (file_exists('custom/modules/' . $module . '/metadata/metafiles.php')) {
                require_once 'custom/modules/' . $module . '/metadata/metafiles.php';
                if (!empty($metafiles[$module]['wizarddefs.php'])) {
                    $metadataFile = $metafiles[$module]['wizarddefs.php'];
                    $foundViewDefs = true;
                }
            } elseif (file_exists('modules/' . $module . '/metadata/metafiles.php')) {
                require_once 'modules/' . $module . '/metadata/metafiles.php';
                if (!empty($metafiles[$module]['wizarddefs'])) {
                    $metadataFile = $metafiles[$module]['wizarddefs'];
                    $foundViewDefs = true;
                }
            }
        }
        $GLOBALS['log']->debug("metadatafile=" . $metadataFile);
        if (!$foundViewDefs && file_exists('modules/' . $module . '/metadata/wizarddefs.php')) {
            $metadataFile = 'modules/' . $module . '/metadata/wizarddefs.php';
        }
        return $metadataFile;
    }

    public function display()
    {
        $this->ev->process();
        echo $this->ev->display($this->showTitle, false);
    }

    public function getModuleTitle(
        $show_help = true
    ) {
        global $sugar_version, $sugar_flavor, $server_unique_key, $current_language, $action;

        $theTitle = "<div class='moduleTitle'>\n";

        $module = preg_replace("/ /", "", $this->module);

        $params = $this->_getModuleTitleParams();
        $index = 0;

        if (SugarThemeRegistry::current()->directionality == "rtl") {
            $params = array_reverse($params);
        }
        if (count($params) > 1) {
            array_shift($params);
        }
        $count = count($params);
        $paramString = '';
        foreach ($params as $parm) {
            $index++;
            $paramString .= $parm;
            if ($index < $count) {
                $paramString .= $this->getBreadCrumbSymbol();
            }
        }

        if (!empty($paramString)) {
            $theTitle .= "<h2> $paramString </h2>";

            if ($this->type == "detail") {
                $theTitle .= "<div class='favorite' record_id='" . $this->bean->id . "' module='" . $this->bean->module_dir . "'><div class='favorite_icon_outline'>" . SugarThemeRegistry::current()->getImage('favorite-star-outline', 'title="' . translate('LBL_DASHLET_EDIT', 'Home') . '" border="0"  align="absmiddle"', null, null, '.gif', translate('LBL_DASHLET_EDIT', 'Home')) . "</div>
                                                    <div class='favorite_icon_fill'>" . SugarThemeRegistry::current()->getImage('favorite-star', 'title="' . translate('LBL_DASHLET_EDIT', 'Home') . '" border="0"  align="absmiddle"', null, null, '.gif', translate('LBL_DASHLET_EDIT', 'Home')) . "</div></div>";
            }
        }

        // bug 56131 - restore conditional so that link doesn't appear where it shouldn't
        if ($show_help || $this->type == 'list') {
            $theTitle .= "<span class='utils'>";
            $createImageURL = SugarThemeRegistry::current()->getImageURL('create-record.gif');
            if ($this->type == 'list') {
                $theTitle .= '<a href="#" class="btn btn-success showsearch"><span class=" glyphicon glyphicon-search" aria-hidden="true"></span></a>';
            }

            $url = "index.php?module=$module&action=wizard&return_module=$module&return_action=DetailView";
            if ($show_help) {
                $theTitle .= <<<EOHTML
&nbsp;
<a id="create_image" href="{$url}" class="utilsLink">
<img src='{$createImageURL}' alt='{$GLOBALS['app_strings']['LNK_CREATE']}'></a>
<a id="create_link" href="{$url}" class="utilsLink">
{$GLOBALS['app_strings']['LNK_CREATE']}
</a>
EOHTML;
            }
            $theTitle .= "</span>";
        }

        $theTitle .= "<div class='clear'></div></div>\n";
        return $theTitle;
    }

}
