<?php
    // show profile of student
    $this->showProfileFor = $model;
?>


<h2>Reset password</h2>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to reset the password!</p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'reset-password-form',
    )); ?>

    <?php echo CHtml::hiddenField('Reset[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'danger',
        'icon'=>'lock white',
        'size' => 'large',
        'label'=>'Reset password'
    )); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'size'=>'large',
        'label'=>'Go back',
        'icon'=>'arrow-left',
        'url' => array('user/view', 'id' => $model->id),
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
