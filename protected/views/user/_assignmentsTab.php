<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
// access check
if(Yii::app()->user->checkAccess('roleManagement', array(
    'student' => $data,
    'currentUser' => $currentUser,
  ))) { ?>
<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Manage roles',
    'icon' => 'user',
    'url' => array('roles/manage', 'student_id' => $data->id),
    'htmlOptions' => array('class' => 'pull-right'),
)); ?><br /><br />
<?php } ?>

<?php
    $this->renderPartial('/common/_assignments', array(
        'roleAssignments' => $roleAssignments,
        'student' => $data,
        'currentUser' => $currentUser,
)); ?>
