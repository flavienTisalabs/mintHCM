{if $fields.status.value == 'request' && $bean->aclAccess("edit") && $current_user->id == $fields.deputy_id.value}
    <input type="button" value="{$MOD.LBL_APPROVE}" id="ApproveButton" />
    <script type="text/javascript" src="modules/WorkSchedules/tpls/AcceptButton.js"></script>
{/if}