{if $fields.status.value == 'Request' && $bean->aclAccess("edit")}
    <input type="button" value="{$MOD.LBL_REJECT}" id="RejectButton" onclick="updateStatus('rejected');" />
    <script type="text/javascript" src="modules/WorkSchedules/tpls/RejectButton.js"></script>
{/if}
