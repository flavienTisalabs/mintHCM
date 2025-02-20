{*
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

*}
{{* Add the preForm code if it is defined (used for vcards) *}}
{{if $preForm}}
{{$preForm}}
{{/if}}
<script language="javascript">
    {literal}
    SUGAR.util.doWhen(function () {
        return $("#contentTable").length == 0;
    }, SUGAR.themes.actionMenu);
    {/literal}
</script>

<table cellpadding="0" cellspacing="0" border="0" width="100%" id="">
    <tr>
        <td class="buttons" align="left" NOWRAP width="80%">
            <div class="actionsContainer">
                <form action="index.php" method="post" name="DetailView" id="formDetailView">
                    <input type="hidden" name="module" value="{$module}">
                    <input type="hidden" name="record" value="{$fields.id.value}">
                    <input type="hidden" name="return_action">
                    <input type="hidden" name="return_module">
                    <input type="hidden" name="return_id">
                    <input type="hidden" name="module_tab">
                    <input type="hidden" name="isDuplicate" value="false">
                    <input type="hidden" name="offset" value="{$offset}">
                    <input type="hidden" name="action" value="EditView">
                    <input type="hidden" name="sugar_body_only">
                    {{if isset($form.hidden)}}
                    {{foreach from=$form.hidden item=field}}
                    {{$field}}
                    {{/foreach}}
                    {{/if}}
                    {if !$config.enable_action_menu}
                    {* MintHCM #81007 START*}
                    {if empty($smarty.request.minthcm_popup)}
                    {* MintHCM #81007 END*}
                        {{include file="themes/SuiteP/include/DetailView/actions_buttons.tpl"}}
                    {* MintHCM #81007 START*}
                    {/if}
                    {* MintHCM #81007 END*}
                    {/if}
                </form>

            </div>

        </td>


        <td align="right" width="20%" class="buttons">{$ADMIN_EDIT}
            {{if $panelCount == 0}}
            {{* Render tag for VCR control if SHOW_VCR_CONTROL is true *}}
            {{if $SHOW_VCR_CONTROL and $config.enable_action_menu == false}}
            {$PAGINATION}
            {{/if}}
            {{counter name="panelCount" print=false}}
            {{/if}}
        </td>
        {{* Add $form.links if they are defined *}}
        {{if !empty($form) && isset($form.links)}}
        <td align="right" width="10%">&nbsp;</td>
        <td align="right" width="100%" NOWRAP class="buttons">
            <div class="actionsContainer">
                {{foreach from=$form.links item=link}}
                {{$link}}&nbsp;
                {{/foreach}}
            </div>
        </td>
        {{/if}}
    </tr>
</table>