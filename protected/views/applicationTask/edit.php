<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>
<?php
    // show profile of student
    $this->showProfileFor = $model->application->student;
    // current menu item
    $this->currentProfileMenuItem = 'Applications';
?>
<?php
    $this->renderPartial('_header_compact', array(
        'data' => $model,
)); ?>

<h1>Edit checklist item details</h1>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'edit-application-task-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->labelEx($model,'title'); ?>
<?php echo $form->dropDownList($model, 'title', ApplicationTask::getListOfTitles()); ?>
&nbsp;<small>or other:</small><?php echo $form->textField($model, 'title_other'); ?>
<?php echo $form->error($model,'title'); ?>

<?php echo $form->labelEx($model,'description'); ?>
<?php echo $form->textArea($model, 'description', array('class' => 'markItUp')); ?>
<?php $this->renderPartial('/common/_markItUp'); ?>
<?php echo $form->error($model,'description'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'edit white', 'label'=>'Edit checklist item details')); ?>

<?php $this->endWidget(); ?>

</div>
