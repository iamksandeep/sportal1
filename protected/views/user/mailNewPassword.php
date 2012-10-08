<?php
$this->breadcrumbs=array(
    $model->name => array('user/view', 'id' => $model->id),
    'Mail new password',
); ?>

<?php $this->menu = array(
        array(
        'label' => $model->name,
        ),
        array(
        'label' => 'View',
        'icon' => 'eye-open',
        'url' => array('user/view', 'id' => $model->id),
        ),
); ?>

<?php
    $this->renderPartial('_header_compact', array(
        'data' => $model,
)); ?>

<h2>Mail new password</h2>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to reset this user's password and mail it to <strong><?php echo $model->email; ?></strong></p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'mail-password-form',
    )); ?>

    <?php echo CHtml::hiddenField('Mail[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'danger',
        'icon'=>'envelope white',
        'size' => 'large',
        'label'=>'Reset and mail password'
    )); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'size'=>'large',
        'label'=>'Go back',
        'icon'=>'arrow-left',
        'url' => array('user/view', 'id' => $model->id),
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
