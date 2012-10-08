<?php
    // show profile of student
    $this->showProfileFor = $model->student;
    // current menu item
    $this->currentProfileMenuItem = 'Activity';
?>

<h2>Post update</h2>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'add-activity-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->label($model, 'comment'); ?>
<?php echo $form->textArea($model, 'comment', array('class' => 'markItUp')); ?>
<?php $this->renderPartial('/common/_markItUp'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'comment white', 'label'=>'Post update')); ?>

<?php $this->endWidget(); ?>

</div>

