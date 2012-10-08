<?php
    // Get current user model
    if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
    // show profile of student
    $this->showProfileFor = $student;
    // current menu item
    $this->currentProfileMenuItem = 'Applications';
?>

<div class="row-fluid">
    <div class="span8"><h1>University Applications</h1></div>

    <?php
    // access check
    if(Yii::app()->user->checkAccess('addApplication', array(
        'student' => $student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
    )))  {
    ?>
    <!-- upload button -->
    <div class="span4">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Add/suggest a university',
        'icon' => 'book white',
        //'size' => 'large',
        'type' => 'danger',
        'url' => array('application/add', 'student_id' => $student->id),
        'htmlOptions' => array('class' => 'pull-right'),
    )); ?>
    </div>
    <?php } ?>
</div>
<br />

<?php //$this->renderPartial('_searchForm', array(
//      's' => $s,
//)); ?>

<br />


<?php
    $state = 'in-progress';
    $this->renderPartial('_applicationList', array(
        'data' => $appData[$state],
        'state' => $state,
        'currentUser' => $currentUser,
        'student' => $student,
)); ?>

<?php
    $state = 'shortlisted';
    $this->renderPartial('_applicationList', array(
        'data' => $appData[$state],
        'state' => $state,
        'currentUser' => $currentUser,
        'student' => $student,
)); ?>

<?php
    $state = 'complete';
    $this->renderPartial('_applicationList', array(
        'data' => $appData[$state],
        'state' => $state,
        'currentUser' => $currentUser,
        'student' => $student,
)); ?>

<?php
    $state = 'inactive';
    $this->renderPartial('_applicationList', array(
        'data' => $appData[$state],
        'state' => $state,
        'currentUser' => $currentUser,
        'student' => $student,
)); ?>
