$( document ).ready( function () {
   $( '<div id="alert_dialog"></div>' ).appendTo( 'body' ).dialog({
       modal: true,
       title: "",
       zIndex: 10000,
       autoOpen: false,
       width: 'auto',
       height: 'auto',
       resizable: false
   });
   $( "#CloseButton" ).click( function () {
       updatePlanStatus('closed');
   });
   $( "#ApproveButton" ).click( function () {
       updatePlanStatus('approve');
   });
   $( "#RejectButton" ).click( function () {
       updatePlanStatus('reject');
   });
});

function getRecordID() {
   var record_id = '';
   if ( $( "#formDetailView > input[name=record]" ).length > 0 ) {
       record_id = $( "input[name=record]" ).val();
   } else {
       record_id = $( "#CloseButton" ).parent().parent().find( 'select' ).val();
   }
   return record_id;
}

function updatePlanStatus(status) {
   var dialog = $('#alert_dialog');
   var workschedule_id = getRecordID();

   if (!workschedule_id) {
       dialog.html('<p>' + SUGAR.language.get('app_strings', 'LBL_CHOOSE_PLAN') + '</p>')
             .dialog({buttons: { 
                 [SUGAR.language.get('app_strings', 'LBL_DIALOG_OK')]: function () { $(this).dialog("close"); } 
             }}).dialog('open').show();
   } else {
       var dialog_buttons = {};
       dialog_buttons[SUGAR.language.get('app_strings', 'LBL_DIALOG_YES')] = function () {
           $(this).dialog("close");
           if (status === 'closed' && checkIfCanBeClosed()) {
               saveStatus(status);
           } else if (status === 'approve' || status === 'reject') {
               saveStatus(status);
           }
       };
       dialog_buttons[SUGAR.language.get('app_strings', 'LBL_DIALOG_NO')] = function () {
           $(this).dialog("close");
       };

       var confirmMessage = '';
       switch (status) {
           case 'approve':
               confirmMessage = SUGAR.language.get('app_strings', 'LBL_APPROVE_PLAN_CONFIRM');
               break;
           case 'reject':
               confirmMessage = SUGAR.language.get('app_strings', 'LBL_REJECT_PLAN_CONFIRM');
               break;
           case 'closed':
               confirmMessage = SUGAR.language.get('app_strings', 'LBL_CLOSE_PLAN_CONFIRM');
               break;
       }

       dialog.html('<p>' + confirmMessage + '</p>')
             .dialog({buttons: dialog_buttons})
             .dialog('open')
             .show();
   }
}

function checkScheduleName( workschedule_id ) {
   var result = "null";
   viewTools.api.callController( {
      module: "WorkSchedules",
      action: "checkScheduleName",
      dataType: 'text',
      async: false,
      dataPOST: {
         id: workschedule_id
      },
      callback: function ( call_constroller_data ) {
         result = call_constroller_data;
      }
   } );
   return result;
}


function checkIfCanBeClosed() {
   var result = true;
   var dialog = $( '#alert_dialog' );
   var workschedule_id = getRecordID() || getTimePanel().taskman.$planSelect.val();
   var schedule_name = checkScheduleName( workschedule_id );
   viewTools.api.callController( {
      module: "WorkSchedules",
      action: "checkIfCanBeClosed",
      dataType: 'json',
      async: false,
      dataPOST: {
         id: workschedule_id
      },
      callback: function ( call_constroller_data ) {
         if ( call_constroller_data != "1" ) {
            var dialog_buttons = {};
            dialog_buttons[SUGAR.language.get( 'app_strings', 'LBL_DIALOG_OK' )] = function () {
               $( this ).dialog( "close" );
            };
            if(call_constroller_data == "2"){
                dialog.html( '<p>' + viewTools.language.get( 'WorkSchedules', 'ERR_SPENT_TIMES_DO_NOT_OVERLAP_WITH_WORK_SCHEDULE' ).replace( '{name}', schedule_name ) + '</p>' ).dialog( {buttons: dialog_buttons} ).dialog( 'open' ).show();
             }
             if(call_constroller_data == "3"){
                 dialog.html( '<p>' + viewTools.language.get( 'WorkSchedules', 'ERR_WORKPLACE_IS_REQUIRED' ).replace( '{name}', schedule_name ) + '</p>' ).dialog( {buttons: dialog_buttons} ).dialog( 'open' ).show();
              }
             else if(call_constroller_data == "4"){
                dialog.html( '<p>' + viewTools.language.get( 'WorkSchedules', 'ERR_WORKPLACE_IS_NOT_ACTIVE' ).replace( '{name}', schedule_name ) + '</p>' ).dialog( {buttons: dialog_buttons} ).dialog( 'open' ).show();
             }
            result = false;
         }
      }
   } );
   return result;
}

function saveStatus(status) {
   viewTools.GUI.statusBox.showStatus(SUGAR.language.get('app_strings', 'LBL_SAVING'), 'info');
   var workschedule_id = getRecordID();

   viewTools.api.callController({
       module: "WorkSchedules",
       action: "save",
       dataType: 'text',
       async: false,
       dataPOST: {
           record: workschedule_id,
           status: status,
           to_pdf: 1,
           sugar_body_only: 1
       },
       callback: function(response) {
           if (!response) {
               console.error(response);
           } else {
               location.reload();
           }
       }
   });
}
