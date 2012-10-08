<?php
$this->breadcrumbs=array(
    'Users' => array('user/index'),
    'Add user',
); ?>

<h1>Add <?php echo $model->type0; ?> user</h1>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'add-user-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name_first'); ?>
<?php echo $form->textFieldRow($model, 'name_last'); ?>
<?php echo $form->textFieldRow($model, 'email'); ?>
<?php echo $form->passwordFieldRow($model, 'password'); ?>
<?php echo $form->passwordFieldRow($model, 'password_repeat'); ?>
<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'plus white', 'label'=>'Add')); ?>

<?php $this->endWidget(); ?>

</div>
