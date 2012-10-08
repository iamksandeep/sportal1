<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php

$profileSettingLinks = array();
$showMenu = false;

// edit account details
// --------------------------------------------------------------------------
if($model->type0 === 'student') $authCode = 'editStudentAcc';
elseif($model->type0 === 'mnemonic') $authCode = 'editMnemonicAcc';
elseif($model->type0 === 'admin') $authCode = 'editAdminAcc';
elseif($model->type0 === 'superadmin') $authCode = 'editSuperadminAcc';
else $authCode = 'error';

if(Yii::app()->user->checkAccess($authCode, array(
        'currentUser' => $currentUser,
        'student' => $model,
        'user' => $model,
))) {
        array_push($profileSettingLinks, array(
                'label' => 'Update details',
                'icon' => 'edit',
                'url' => array('user/update', 'id' => $model->id),
        ));
        $showMenu = true;
}

// change user type
// --------------------------------------------------------------------------
if($model->type0 === 'admin') $authCode = 'changeAdminAccType';
elseif($model->type0 === 'superadmin') $authCode = 'changeSuperadminAccType';
else $authCode = 'changeAccType';

if(Yii::app()->user->checkAccess($authCode, array(
        'currentUser' => $currentUser,
        'student' => $model,
        'user' => $model,
))) {
        array_push($profileSettingLinks, array(
                'label' => 'Change type',
                'icon' => 'user',
                'url' => array('user/changeType', 'id' => $model->id),
        ));
        $showMenu = true;
}

// change password
// --------------------------------------------------------------------------
if($model->id === $currentUser->id) {
        array_push($profileSettingLinks, array(
                'label' => 'Change password',
                'icon' => 'lock',
                'url' => array('user/changePassword', 'id' => $model->id),
        ));
        $showMenu = true;
}

// reset password
// --------------------------------------------------------------------------
if($model->type0 === 'student') $authCode = 'resetStudentPass';
elseif($model->type0 === 'mnemonic') $authCode = 'resetMnemonicPass';
elseif($model->type0 === 'admin') $authCode = 'resetAdminPass';
elseif($model->type0 === 'superadmin') $authCode = 'resetSuperadminPass';
else $authCode = 'error';

if(Yii::app()->user->checkAccess($authCode, array(
        'currentUser' => $currentUser,
        'student' => $model,
        'user' => $model,
))) {
        array_push($profileSettingLinks, array(
                'label' => 'Reset password',
                'icon' => 'lock',
                'url' => array('user/resetPassword', 'id' => $model->id),
        ));
        $showMenu = true;
}

// mail new password
// --------------------------------------------------------------------------
/*
if($model->type0 === 'student') $authCode = 'mailStudentPass';
elseif($model->type0 === 'mnemonic') $authCode = 'mailMnemonicPass';
elseif($model->type0 === 'admin') $authCode = 'mailAdminPass';
elseif($model->type0 === 'superadmin') $authCode = 'mailSuperadminPass';
else $authCode = 'error';

if(Yii::app()->user->checkAccess($authCode, array(
        'currentUser' => $currentUser,
        'student' => $model,
        'user' => $model,
))) {
        array_push($menu, array(
                'label' => 'Mail new password',
                'icon' => 'envelope',
                'url' => array('user/mailNewPassword', 'id' => $model->id),
        ));
        $showMenu = true;
}
*/

// disable / enable
// --------------------------------------------------------------------------
if($model->type0 === 'student' && Yii::app()->user->checkAccess('disableStudent', array(
        'currentUser' => $currentUser,
        'student' => $model,
))) {
        array_push($profileSettingLinks, array(
                'label' => 'Disable',
                'icon' => 'ban-circle',
                'url' => array('user/disable', 'id' => $model->id),
        ));
        array_push($profileSettingLinks, array(
                'label' => 'Enable',
                'icon' => 'ok-circle',
                'url' => array('user/enable', 'id' => $model->id),
        ));
        $showMenu = true;
}

// remove user
// --------------------------------------------------------------------------
if(Yii::app()->user->checkAccess('removeUser', array(
        'currentUser' => $currentUser,
))) {
        array_push($profileSettingLinks, array(
                'label' => 'Remove',
                'icon' => 'trash',
                'url' => array('user/remove', 'id' => $model->id),
        ));
        $showMenu = true;
}

// show the menu
// --------------------------------------------------------------------------

if($showMenu)
    $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'type'=>'inverse', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons'=>array(
            array('icon' => 'cog white', 'items'=>$profileSettingLinks,),
        ),
    ));
?>
