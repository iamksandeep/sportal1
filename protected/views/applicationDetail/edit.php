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

<h1>Edit application detail</h1>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'edit-application-detail-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'title'); ?>

<?php echo $form->labelEx($model,'content'); ?>
<?php echo $form->textArea($model, 'content', array('class' => 'markItUp')); ?>
<?php $this->renderPartial('/common/_markItUp'); ?>
<?php echo $form->error($model,'content'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'edit white', 'label'=>'Edit detail')); ?>

<?php $this->endWidget(); ?>

</div>
