<?php
$this->breadcrumbs=array(
    $model->name => array('user/view', 'id' => $model->id),
    'Remove user',
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

<h2>Remove account</h2>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to remove this account!</p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'remove-user-form',
    )); ?>

    <?php echo CHtml::hiddenField('Remove[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'danger',
        'icon'=>'trash white',
        'size' => 'large',
        'label'=>'Remove account'
    )); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'size'=>'large',
        'label'=>'Go back',
        'icon'=>'arrow-left',
        'url' => array('user/view', 'id' => $model->id),
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
