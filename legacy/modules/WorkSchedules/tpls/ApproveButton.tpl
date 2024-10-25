{if $fields.status.value == 'request' && $bean->aclAccess("edit")}
    <input type="button" value="{$MOD.LBL_APPROVE}" id="ApproveButton" onclick="updateStatus('approve');" />
    <script type="text/javascript" src="modules/WorkSchedules/tpls/ApproveButton.js"></script>
{/if}
