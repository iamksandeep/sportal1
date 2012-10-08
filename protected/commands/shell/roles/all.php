<?php
// general reader
// -------------------------------------------------------------------------------------
$bizRule = 'return (isset($params["currentUser"]) && (
              $params["currentUser"]->type0 !== "student"
            ));';
$role = $auth->createRole('mnemonicGeneralReader', '', $bizRule);
$role->addChild('viewRolesData');
$role->addChild('editOwnAcc');
$role->addChild('resetOwnPass');
$role->addChild('mailOwnPass');
$role->addChild('viewDocuments');
$role->addChild('viewApplications');
$role->addChild('viewActivity');
$role->addChild('viewAllActivity');
$role->addChild('viewAllApplications');
$role->addChild('downloadOwnDocument');


// student
// -------------------------------------------------------------------------------------
$bizRule = 'return (
              isset($params["currentUser"], $params["student"])
              && $params["currentUser"]->id===$params["student"]->id
            );';
$role = $auth->createRole('student', '', $bizRule);
$role->addChild('mnemonicGeneralReader');
$role->addChild('addApplication');
$role->addChild('postStudentActivity');
$role->addChild('postApplicationActivity');
$role->addChild('postApplicationTaskActivity');
$role->addChild('uploadDocument');
$role->addChild('downloadGeneralDocument');
$role->addChild('downloadContentDocument');
$role->addChild('editOwnAcc');
$role->addChild('resetOwnPass');
$role->addChild('mailOwnPass');
$role->addChild('adminProfile');
$role->addChild('editUniversityCredentials');
$role->addChild('viewDocuments');
$role->addChild('viewApplications');
$role->addChild('viewActivity');
$role->addChild('editOwnDocumentDetails');


// researcher
// -------------------------------------------------------------------------------------
$bizRule = 'return (isset($params["currentUser"]) && (
              $params["currentUser"]->type0==="superadmin"
              || $params["currentUser"]->type0==="admin"
              || (
                isset($params["student"])
                && (
                  $params["student"]->roleManager->hasRole($params["currentUser"]->id, "manager")
                  || $params["student"]->roleManager->hasRole($params["currentUser"]->id, "researcher")
                )
              )
            ));';
$role = $auth->createRole('researcher', '', $bizRule);
$role->addChild('mnemonicGeneralReader');
$role->addChild('addApplication');
$role->addChild('adminApplicationDetail');
$role->addChild('postStudentActivity');
$role->addChild('viewRolesData');
$role->addChild('uploadDocument');
$role->addChild('adminProfile');
$role->addChild('editOwnDocumentDetails');


// counselor
// -------------------------------------------------------------------------------------
$bizRule = 'return (isset($params["currentUser"]) && (
              $params["currentUser"]->type0==="superadmin"
              || $params["currentUser"]->type0==="admin"
              || (
                isset($params["student"])
                && (
                  $params["student"]->roleManager->hasRole($params["currentUser"]->id, "manager")
                  || $params["student"]->roleManager->hasRole($params["currentUser"]->id, "counselor")
                )
              )
            ));';
$role = $auth->createRole('counselor', '', $bizRule);
$role->addChild('mnemonicGeneralReader');
$role->addChild('adminApplicationDetail');
$role->addChild('addApplicationTask');
$role->addChild('templateApplicationTask');
$role->addChild('editApplicationTask');
$role->addChild('changeApplicationTaskState');
$role->addChild('postApplicationActivity');
$role->addChild('postApplicationTaskActivity');
$role->addChild('assignJobToStudent');
$role->addChild('viewRolesData');
$role->addChild('uploadDocument');
$role->addChild('downloadGeneralDocument');
$role->addChild('downloadOwnDocument');
$role->addChild('editOwnDocumentDetails');
$role->addChild('adminProfile');
$role->addChild('viewUniversityCredentials');


// content-writer
// -------------------------------------------------------------------------------------
$bizRule = 'return (isset($params["currentUser"]) && (
              $params["currentUser"]->type0==="superadmin"
              || $params["currentUser"]->type0==="admin"
              || (
                isset($params["student"])
                && (
                  $params["student"]->roleManager->hasRole($params["currentUser"]->id, "manager")
                  || $params["student"]->roleManager->hasRole($params["currentUser"]->id, "content-writer")
                )
              )
            ));';
$role = $auth->createRole('content-writer', '', $bizRule);
$role->addChild('mnemonicGeneralReader');
$role->addChild('addApplicationTask');
$role->addChild('editApplicationTask');
$role->addChild('changeApplicationTaskState');
$role->addChild('postApplicationActivity');
$role->addChild('postApplicationTaskActivity');
$role->addChild('assignJobToStudent');
$role->addChild('viewRolesData');
$role->addChild('uploadDocument');
$role->addChild('downloadGeneralDocument');
$role->addChild('downloadOwnDocument');
$role->addChild('editOwnDocumentDetails');
$role->addChild('adminProfile');

// manager
// -------------------------------------------------------------------------------------
$bizRule = 'return (isset($params["currentUser"]) && (
              $params["currentUser"]->type0==="superadmin"
              || $params["currentUser"]->type0==="admin"
              || (
                isset($params["student"])
                && $params["student"]->roleManager->hasRole($params["currentUser"]->id, "manager")
              )
            ));';
$role = $auth->createRole('manager', '', $bizRule);
$role->addChild('mnemonicGeneralReader');
$role->addChild('researcher');
$role->addChild('counselor');
$role->addChild('content-writer');
$role->addChild('adminApplication');
$role->addChild('adminApplicationTask');
$role->addChild('adminActivity');
$role->addChild('messageStudent');
$role->addChild('assignJobToStudent');
$role->addChild('viewJob');
$role->addChild('approveJob');
$role->addChild('editJobDetails');
$role->addChild('changeJobState');
$role->addChild('postJobActivity');
$role->addChild('uploadJobDocument');
$role->addChild('downloadJobDocument');
$role->addChild('deleteJobDocument');
$role->addChild('roleManagement');
$role->addChild('viewTasksToStudent');
$role->addChild('adminDocument');
$role->addChild('editStudentAcc');
$role->addChild('mailStudentPass');
$role->addChild('disableStudent');
$role->addChild('adminProfile');
$role->addChild('editUniversityCredentials');


// admin
// -------------------------------------------------------------------------------------
$bizRule = 'return (isset($params["currentUser"]) && (
              $params["currentUser"]->type0==="admin"
              || $params["currentUser"]->type0==="superadmin"
            ));';
$role = $auth->createRole('admin', '', $bizRule);
$role->addChild('manager');
$role->addChild('addStudentAcc');
$role->addChild('addMnemonicAcc');
$role->addChild('addAdminAcc');
$role->addChild('editMnemonicAcc');
$role->addChild('changeAccType');
$role->addChild('resetStudentPass');
$role->addChild('resetMnemonicPass');



// superadmin
// -------------------------------------------------------------------------------------
$bizRule = 'return (isset($params["currentUser"]) && (
              $params["currentUser"]->type0==="superadmin"
            ));';
$role = $auth->createRole('superadmin', '', $bizRule);
$role->addChild('admin');
$role->addChild('addSuperadminAcc');
$role->addChild('editAdminAcc');
$role->addChild('editSuperadminAcc');
$role->addChild('changeAdminAccType');
$role->addChild('changeSuperadminAccType');
$role->addChild('resetAdminPass');
$role->addChild('resetSuperadminPass');
$role->addChild('removeUser');

?>
