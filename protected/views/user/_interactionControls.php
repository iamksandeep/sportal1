<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
// If student is viewing his/her own profile
// Show managers and interaction options
if($currentUser->id === $user->id) {
    echo "<h4>Managers: </h4>";
    echo "<br />";
    foreach($roleAssignments['manager'] as $role) {
        $this->renderPartial('/user/_nameLink', array('user' => $role->user));
        echo '&nbsp;';
        echo CHtml::link('<i class="icon-envelope"></i>', array('message/composeFromStudent', 'to' => $role->user->id, 'student_id' => $role->student_id));
        echo '&nbsp;';
        echo CHtml::link('<i class="icon-pencil"></i>', array('todo/newFromStudent', 'assignee_id' => $role->user->id, 'student_id' => $role->student_id));
        echo "<br /><br />";
    }
}

?>


<?php
// SEND MESSAGE BUTTON
if(Yii::app()->user->checkAccess('messageStudent', array(
    'student' => $user,
    'currentUser' => $currentUser,
))) { ?>
<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Send message',
    'icon' => 'envelope white',
    'size' => 'small',
    'type' => 'info',
    'url' => array('message/compose', 'student_id' => $user->id, 'to' => $user->id),
    'htmlOptions' => array('class' => 'pull-right'),
)); ?>
<div class="clear"></div><br /><br />
<?php } ?>

<?php
// ASSIGN JOB BUTTON
if(Yii::app()->user->checkAccess('assignJobToStudent', array(
    'student' => $user,
    'currentUser' => $currentUser,
))) { ?>
<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Assign a job',
    'icon' => 'pencil white',
    'size' => 'small',
    'type' => 'inverse',
    'url' => array('todo/new', 'student_id' => $user->id, 'assignee_id' => $user->id),
    'htmlOptions' => array('class' => 'pull-right'),
)); ?>
<?php } ?>
