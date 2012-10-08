<?php
    // show profile of student
    $this->showProfileFor = $model->student;
    // current menu item
    $this->currentProfileMenuItem = 'Profile';
?>
<h3>Add <?php echo $model->category0; ?> information</h3>


<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'add-profile-detail-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->labelEx($model,'title'); ?>
<?php echo $form->dropDownList($model, 'title', ProfileDetail::getListOfTitles($model->category)); ?>
&nbsp;<small>or other:</small><?php echo $form->textField($model, 'title_other'); ?>
<?php echo $form->error($model,'title'); ?>

<?php echo $form->labelEx($model,'content'); ?>
<?php echo $form->textArea($model, 'content', array('class' => 'markItUp')); ?>
<?php $this->renderPartial('/common/_markItUp'); ?>
<?php echo $form->error($model,'content'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'plus white', 'label'=>'Add detail')); ?>

<?php $this->endWidget(); ?>

</div>
