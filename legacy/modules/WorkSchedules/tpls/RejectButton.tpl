{if $fields.status.value == 'request' && $bean->aclAccess("edit")}
    <input type="button" value="{$MOD.LBL_REJECT}" id="RejectButton" onclick="updateStatus('reject');" />
    <script type="text/javascript" src="modules/WorkSchedules/tpls/RejectButton.js"></script>
{/if}
