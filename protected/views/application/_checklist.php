<div class="row-fluid">

<?php
    $state = 'complete';
    if($taskData[$state]->totalItemCount > 0) {
?>
    <div class="span4">
<?php
    $this->renderPartial('//applicationTask/_applicationTaskList', array(
        'data' => $taskData[$state],
        'state' => $state,
        'currentUser' => $currentUser,
)); ?>
    </div>
<?php } ?>

<?php
    $state = 'in-progress';
    if($taskData[$state]->totalItemCount > 0) {
?>
    <div class="span4">
<?php
    $this->renderPartial('//applicationTask/_applicationTaskList', array(
        'data' => $taskData[$state],
        'state' => $state,
        'currentUser' => $currentUser,
)); ?>
    </div>
<?php } ?>

<?php
    $state = 'not-started';
    if($taskData[$state]->totalItemCount > 0) {
?>
    <div class="span4">
<?php
    $this->renderPartial('//applicationTask/_applicationTaskList', array(
        'data' => $taskData[$state],
        'state' => $state,
        'currentUser' => $currentUser,
)); ?>
    </div>
<?php } ?>
</div>

<?php
$btnArray = array();

// access check
if(Yii::app()->user->checkAccess('addApplicationTask', array(
    'student' => $model->student,
    'currentUser' => User::model()->findByPk(Yii::app()->user->id),
  )))
    array_push($btnArray, array(
        'label'=>'Add checklist item',
        'icon' => 'tasks',
        'url' => array('applicationTask/add', 'application_id' => $model->id),
    ));
if(Yii::app()->user->checkAccess('templateApplicationTask', array(
    'student' => $model->student,
    'currentUser' => User::model()->findByPk(Yii::app()->user->id),
  )))
    array_push($btnArray, array(
        'label'=>'Copy from template',
        'type' => 'inverse',
        'url' => array('application/copyFromTemplate', 'id' => $model->id, 'item_to_copy' => 'checklist'),
    ));

if(sizeof($btnArray) > 0)
    $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'buttons'=>$btnArray,
        'htmlOptions' => array('class' => 'pull-right'),
    ));
?>
