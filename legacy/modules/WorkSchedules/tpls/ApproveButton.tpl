{if $fields.status.value == 'Request' && $bean->aclAccess("edit")}
    <input type="button" value="{$MOD.LBL_APPROVE}" id="ApproveButton" onclick="updateStatus('approved');" />
    <script type="text/javascript" src="modules/WorkSchedules/tpls/ApproveButton.js"></script>
{/if}
