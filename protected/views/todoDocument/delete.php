<?php
$this->breadcrumbs=array(
    'To do '=>array('todo/index'),
    $model->todo->title => array('todo/view', 'id' => $model->todo->id),
    'Delete document',
);?>

<?php $this->menu = array(
        array(
        'label' => 'TASK'
        ),
        array(
        'label' => 'View',
        'icon' => 'eye-open',
        'url' => array('todo/view', 'id' => $model->todo->id),
        ),
); ?>

<?php $this->renderPartial('/todo/_header_compact', array(
        'data' => $model->todo,
)); ?>

<h1>Delete document</h1>

<?php
    $this->renderPartial('/todoDocument/_view', array(
        'data' => $model,
    ));
?>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to delete this document.</p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'delete-document-form',
    )); ?>

    <?php echo CHtml::hiddenField('Delete[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'danger',
        'icon'=>'trash white',
        'size' => 'large',
        'label'=>'Delete document'
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
