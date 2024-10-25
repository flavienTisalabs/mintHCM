{if $fields.status.value == 'request' && $bean->aclAccess("edit") && $current_user->id == $fields.assigned_user_id}
    <input type="button" value="{$MOD.LBL_APPROVE}" id="ApproveButton" />
    <input type="button" value="{$MOD.LBL_REJECT}" id="RejectButton" />
    <script type="text/javascript" src="modules/WorkSchedules/tpls/CloseButton.js"></script>
{/if}

{if $fields.status.value != 'closed' && $bean->aclAccess("edit")}
    <input type="button" value="{$MOD.LBL_CLOSE_PLAN}" id="CloseButton" />
    <script type="text/javascript" src="modules/WorkSchedules/tpls/CloseButton.js"></script>
{/if}
