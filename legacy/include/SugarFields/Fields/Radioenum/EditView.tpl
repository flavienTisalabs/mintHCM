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
{if empty({{sugarvar key='value' string=true}})}
    {assign var="value" value={{sugarvar key='default_value' string=true}} }
{else}
    {assign var="value" value={{sugarvar key='value' string=true}} }
{/if}
{capture name=idname assign=idname}{{sugarvar key='name'}}{/capture}
    {{if !empty($displayParams.idName)}}
    {assign var=idname value='{{$displayParams.idName}}'}
    {{/if}}

    {if isset({{sugarvar key='value' string=true}}) && {{sugarvar key='value' string=true}} != ''}
        {html_radios id="$idname"

        {{if $vardef.vt_dependency!=''}}{literal}data_dependency="{{php}}echo str_replace('$','\\$',$this->_tpl_vars['vardef']['vt_dependency']); {{/php}}{/literal}{{/if}}
            {{if $vardef.vt_calculated!=''}} {literal}data_calculated="{{php}}echo str_replace('$','\\$',$this->_tpl_vars['vardef']['vt_calculated']); {{/php}}"{/literal} {{/if}}
                {{if $vardef.vt_required!=''}} {literal}data_required="{{php}}echo str_replace('$','\\$',$this->_tpl_vars['vardef']['vt_required']); {{/php}}"{/literal}{{/if}}
                    {{if $vardef.vt_readonly!=''}} {literal}data_required="{{php}}echo str_replace('$','\\$',$this->_tpl_vars['vardef']['vt_readonly']); {{/php}}"{/literal}{{/if}}
                        {{if $vardef.vt_validation!=''}} {literal}data_validation="{{php}}echo str_replace('$','\\$',$this->_tpl_vars['vardef']['vt_validation']); {{/php}}"{/literal}{{/if}}

                            {{if !empty($displayParams.accesskey)}} accesskey='{{$displayParams.accesskey}}' {{/if}}
      name="$idname" title="{{$vardef.help}}"
      options={{sugarvar key='options' string=true}}
      class="vt_formulaSelector{{if $vardef.vt_enforced!='false' and $vardef.vt_calculated!=''}} vt_enforced{{/if}}"
      selected={{sugarvar key='value' string=true}} separator="{{$vardef.separator}}"}
                            {else}
                                {html_radios id="$idname"

                                {{if $vardef.vt_dependency!=''}}{literal}data_dependency="{{php}}echo str_replace('$','\\$',$this->_tpl_vars['vardef']['vt_dependency']); {{/php}}{/literal}{{/if}}
                                    {{if $vardef.vt_calculated!=''}}{literal}data_calculated="{{php}}echo str_replace('$','\\$',$this->_tpl_vars['vardef']['vt_calculated']); {{/php}}"{/literal}{{/if}}
                                        {{if $vardef.vt_required!=''}}{literal}data_required="{{php}}echo str_replace('$','\\$',$this->_tpl_vars['vardef']['vt_required']);{{/php}}"{/literal}{{/if}}
                                            {{if $vardef.vt_readonly!=''}}{literal}data_required="{{php}}echo str_replace('$','\\$',$this->_tpl_vars['vardef']['vt_readonly']); {{/php}}" {/literal}{{/if}}
                                                {{if $vardef.vt_validation!=''}}{literal}data_validation="{{php}}echo str_replace('$','\\$',$this->_tpl_vars['vardef']['vt_validation']); {{/php}}" {/literal}{{/if}}

                                                    {{if !empty($displayParams.accesskey)}} accesskey='{{$displayParams.accesskey}}' {{/if}}
      name="$idname"
      title="{{$vardef.help}}"
      options={{sugarvar key='options' string=true}}
      selected={{sugarvar key='default' string=true}}
      class="vt_formulaSelector{{if $vardef.vt_enforced!='false' and $vardef.vt_calculated!=''}} vt_enforced{{/if}}"
      separator="{{$vardef.separator}}"}
                                                    {/if}