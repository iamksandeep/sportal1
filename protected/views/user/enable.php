<?php
$this->breadcrumbs=array(
    $model->name => array('user/view', 'id' => $model->id),
    'Enable account',
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

<h2>Enable account</h2>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to enable this account</p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'enable-user-form',
    )); ?>

    <?php echo CHtml::hiddenField('Enable[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'success',
        'icon'=>'ok-circle white',
        'size' => 'large',
        'label'=>'Enable account'
    )); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'size'=>'large',
        'label'=>'Go back',
        'icon'=>'arrow-left',
        'url' => array('user/view', 'id' => $model->id),
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
