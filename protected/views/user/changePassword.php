<?php
    // show profile of student
    $this->showProfileFor = $model;
?>

<h2>Change Password</h2>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'change-password-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($newModel); ?>

<?php echo $form->passwordFieldRow($newModel, 'password_old'); ?>
<?php echo $form->passwordFieldRow($newModel, 'password'); ?>
<?php echo $form->passwordFieldRow($newModel, 'password_repeat'); ?>
<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'lock white', 'label'=>'Change Password')); ?>

<?php $this->endWidget(); ?>

</div>
