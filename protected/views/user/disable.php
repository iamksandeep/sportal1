<?php
$this->breadcrumbs=array(
    $model->name => array('user/view', 'id' => $model->id),
    'Disable account',
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

<h1>Disable account</h1>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to disable this account</p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'disable-user-form',
    )); ?>

    <?php echo CHtml::hiddenField('Disable[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'danger',
        'icon'=>'ban-circle white',
        'size' => 'large',
        'label'=>'Disable account'
    )); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'size'=>'large',
        'label'=>'Go back',
        'icon'=>'arrow-left',
        'url' => array('user/view', 'id' => $model->id),
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
