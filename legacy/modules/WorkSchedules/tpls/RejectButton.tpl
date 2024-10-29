{if $fields.status.value == 'request' && $bean->aclAccess("edit") && $current_user->id == $fields.deputy_id.value}
    <input type="button" value="{$MOD.LBL_REJECT}" id="RejectButton" />
    <script type="text/javascript" src="modules/WorkSchedules/tpls/RejectButton.js"></script>
{/if}