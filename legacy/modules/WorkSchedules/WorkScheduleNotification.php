<?php


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

 class WorkScheduleNotification {
    
    public function sendNotificationOnCreate($bean, $event, $arguments) {
        error_log("Triggering sendNotificationOnCreate");
        
        if ($arguments['isUpdate'] === false) {
            error_log("This is a new WorkSchedule record.");
            
            $createdBy = $bean->created_by;
            $deputyId = $bean->deputy_id;
            $workScheduleType = $bean->type;
            $status = $bean->status;

            if ($status === 'request') {
                error_log("WorkSchedule status is 'request', sending notification to deputy.");
                $notificationMessage = "A new WorkSchedule of type {$workScheduleType} has been created.";
                $this->sendAlert($deputyId, $notificationMessage);
            } else {
                error_log("WorkSchedule status is not 'request', no notification sent.");
            }
        } else {
            error_log("This is an update to an existing WorkSchedule record, skipping creation notification.");
        }
    }

    public function sendNotificationOnResponse($bean, $event, $arguments) {
        error_log("Triggering sendNotificationOnResponse");
        
        if ($arguments['isUpdate'] === true) {
            error_log("This is an update to an existing WorkSchedule record.");
            
            $createdBy = $bean->created_by;
            $deputyStatus = $bean->supervisor_acceptance;
            $statusMessage = ($deputyStatus === 'approved') 
                ? "Your WorkSchedule has been accepted by deputy." 
                : "Your WorkSchedule has been rejected by deputy.";

            error_log("Sending notification to user who created the WorkSchedule.");
            $this->sendAlert($createdBy, $statusMessage);
        } else {
            error_log("This is a new WorkSchedule record, skipping response notification.");
        }
    }

    private function sendAlert($userId, $message) {
        error_log("Creating new notification for user ID: $userId with message: $message");
        
        $notification = BeanFactory::newBean('Notifications');
        $notification->assigned_user_id = $userId;
        $notification->name = "Notification WorkSchedule";
        $notification->description = $message;
        $notification->is_read = 0;
        $notification->save();
        
        error_log("Notification saved successfully.");
    }
}

