<?php
// application
// -------------------------------------------------------------------------------------
$auth->createOperation('viewAllApplications');
$auth->createOperation('viewApplications');
$auth->createOperation('addApplication');
$auth->createOperation('changeApplicationState');
$auth->createOperation('editApplication');
$auth->createOperation('removeApplication');
$task = $auth->createTask('adminApplication');
$task->addChild('addApplication');
$task->addChild('viewApplications');
$task->addChild('changeApplicationState');
$task->addChild('editApplication');
$task->addChild('removeApplication');

// applicationDetail
// -------------------------------------------------------------------------------------
$auth->createOperation('addApplicationDetail');
$auth->createOperation('editApplicationDetail');
$auth->createOperation('removeApplicationDetail');
$auth->createOperation('templateApplicationDetail');
$task = $auth->createTask('adminApplicationDetail');
$task->addChild('addApplicationDetail');
$task->addChild('editApplicationDetail');
$task->addChild('removeApplicationDetail');
$task->addChild('templateApplicationDetail');

// university login credentials
// -------------------------------------------------------------------------------------
$auth->createOperation('viewUniversityCredentials');
$task = $auth->createTask('editUniversityCredentials');
$task->addChild('viewUniversityCredentials');

// applicationTask
// -------------------------------------------------------------------------------------
$auth->createOperation('addApplicationTask');
$auth->createOperation('editApplicationTask');
$auth->createOperation('changeApplicationTaskState');
$auth->createOperation('removeApplicationTask');
$auth->createOperation('templateApplicationTask');
$task = $auth->createTask('adminApplicationTask');
$task->addChild('addApplicationTask');
$task->addChild('editApplicationTask');
$task->addChild('changeApplicationTaskState');
$task->addChild('removeApplicationTask');
$task->addChild('templateApplicationTask');

// activity
// -------------------------------------------------------------------------------------
$auth->createOperation('viewAllActivity');
$auth->createOperation('viewActivity');
$auth->createOperation('postStudentActivity');
$auth->createOperation('postApplicationActivity');
$auth->createOperation('postApplicationTaskActivity');
$auth->createOperation('editActivity');
$auth->createOperation('deleteActivity');
$task = $auth->createTask('adminActivity');
$task->addChild('viewActivity');
$task->addChild('postStudentActivity');
$task->addChild('postApplicationActivity');
$task->addChild('postApplicationTaskActivity');
$task->addChild('editActivity');
$task->addChild('deleteActivity');

// documents
// -------------------------------------------------------------------------------------
$auth->createOperation('viewDocuments');
$auth->createOperation('uploadDocument');
$auth->createOperation('downloadContentDocument');
$auth->createOperation('downloadGeneralDocument');
$auth->createOperation('deleteDocument');
$auth->createOperation('editDocumentDetails');

$task = $auth->createTask('adminDocument');
$task->addChild('viewDocuments');
$task->addChild('uploadDocument');
$task->addChild('downloadContentDocument');
$task->addChild('downloadGeneralDocument');
$task->addChild('deleteDocument');
$task->addChild('editDocumentDetails');

// own docs
$bizRule = 'return (
              isset($params["currentUser"], $params["document"])
              && $params["document"]->uploader_id === $params["currentUser"]->id
           );';
$task = $auth->createTask('downloadOwnDocument', '', $bizRule);
$task->addChild('downloadContentDocument');
$task->addChild('downloadGeneralDocument');
$task = $auth->createTask('editOwnDocumentDetails', '', $bizRule);
$task->addChild('editDocumentDetails');

// student interaction
// -------------------------------------------------------------------------------------
$auth->createOperation('messageStudent');
$auth->createOperation('assignJobToStudent');

$auth->createOperation('viewRolesData');
$task = $auth->createTask('roleManagement');
$task->addChild('viewRolesData');

// add user accounts
// -------------------------------------------------------------------------------------
$auth->createOperation('addStudentAcc');
$auth->createOperation('addMnemonicAcc');
$auth->createOperation('addAdminAcc');
$auth->createOperation('addSuperadminAcc');

// edit account details
// -------------------------------------------------------------------------------------
$auth->createOperation('editStudentAcc');
$auth->createOperation('editMnemonicAcc');
$auth->createOperation('editAdminAcc');
$auth->createOperation('editSuperadminAcc');

// own account
$bizRule = 'return (
              isset($params["currentUser"], $params["user"])
              && $params["user"]->id === $params["currentUser"]->id
           );';
$task = $auth->createTask('editOwnAcc', '', $bizRule);
$task->addChild('editStudentAcc');
$task->addChild('editMnemonicAcc');
$task->addChild('editAdminAcc');
$task->addChild('editSuperadminAcc');

// change account type
// -------------------------------------------------------------------------------------
$auth->createOperation('changeAdminAccType');
$auth->createOperation('changeSuperadminAccType');
$auth->createOperation('changeAccType');

// reset password
// -------------------------------------------------------------------------------------
$auth->createOperation('resetStudentPass');
$auth->createOperation('resetMnemonicPass');
$auth->createOperation('resetAdminPass');
$auth->createOperation('resetSuperadminPass');

// own account
$bizRule = 'return (
              isset($params["currentUser"], $params["user"])
              && $params["user"]->id === $params["currentUser"]->id
           );';
$task = $auth->createTask('resetOwnPass', '', $bizRule);
$task->addChild('resetStudentPass');
$task->addChild('resetMnemonicPass');
$task->addChild('resetAdminPass');
$task->addChild('resetSuperadminPass');

// mail new password
// -------------------------------------------------------------------------------------
$auth->createOperation('mailStudentPass');
$auth->createOperation('mailMnemonicPass');
$auth->createOperation('mailAdminPass');
$auth->createOperation('mailSuperadminPass');

// own account
$bizRule = 'return (
              isset($params["currentUser"], $params["user"])
              && $params["user"]->id === $params["currentUser"]->id
           );';
$task = $auth->createTask('mailOwnPass', '', $bizRule);
$task->addChild('mailStudentPass');
$task->addChild('mailMnemonicPass');
$task->addChild('mailAdminPass');
$task->addChild('mailSuperadminPass');

// disable / enable
// -------------------------------------------------------------------------------------
$auth->createOperation('disableStudent');

// remove
// -------------------------------------------------------------------------------------
$auth->createOperation('removeUser');


// jobs
// -------------------------------------------------------------------------------------
$auth->createOperation('approveJob');
$auth->createOperation('viewTasksToStudent');
$auth->createOperation('viewJob');
$auth->createOperation('editJobDetails');
$auth->createOperation('changeJobState');
$auth->createOperation('postJobActivity');
$auth->createOperation('uploadJobDocument');
$auth->createOperation('downloadJobDocument');
$auth->createOperation('deleteJobDocument');

// student profile management
// -------------------------------------------------------------------------------------
$auth->createOperation('manageAcademicDetails');
$auth->createOperation('manageProfilePersonalDetails');
$auth->createOperation('manageProfileContactDetails');
$auth->createOperation('manageProfileExam-scoresDetails');
$auth->createOperation('manageProfileAdditionalDetails');
$auth->createOperation('manageProfileProgramDetails');
$task = $auth->createTask('adminProfile');
$task->addChild('manageAcademicDetails');
$task->addChild('manageProfilePersonalDetails');
$task->addChild('manageProfileContactDetails');
$task->addChild('manageProfileExam-scoresDetails');
$task->addChild('manageProfileAdditionalDetails');
$task->addChild('manageProfileProgramDetails');

?>
