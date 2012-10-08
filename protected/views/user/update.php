<?php
    // show profile of student
    $this->showProfileFor = $model;
?>

<h2>Update details</h2>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'update-user-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name_first'); ?>
<?php echo $form->textFieldRow($model, 'name_last'); ?>
<?php echo $form->textFieldRow($model, 'email'); ?>
<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'edit white', 'label'=>'Update details')); ?>

<?php $this->endWidget(); ?>

</div>
