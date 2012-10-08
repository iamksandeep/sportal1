<?php
$this->breadcrumbs=array(
    'Jobs '=>array('todo/index'),
    $model->title => array('todo/view', 'id' => $model->id),
    'Approve Job',
);?>

<?php $this->menu = array(
        array(
        'label' => 'JOB'
        ),
        array(
        'label' => 'View',
        'icon' => 'eye-open',
        'url' => array('todo/view', 'id' => $model->id),
        ),
); ?>

<?php $this->renderPartial('/todo/_header_compact', array(
        'data' => $model,
)); ?>

<h1>Approve Job</h1>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to approve this job and assign to the student.</p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'approve-task-form',
    )); ?>

    <?php echo CHtml::hiddenField('Approve[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'success',
        'icon'=>'check white',
        'size' => 'large',
        'label'=>'Approve job'
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
