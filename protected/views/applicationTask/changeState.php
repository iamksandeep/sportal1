<?php
$this->breadcrumbs=array(
    $model->application->student->name => array('user/view', 'id' => $model->application->student->id),
    $model->application->title.' application' => array('application/view', 'id' => $model->application->id),
    $model->title.' (checklist item)' => array('applicationTask/view', 'id' => $model->id),
    'Change checklist item state',
); ?>

<?php $this->menu = array(
        array(
        'label' => 'Application',
        ),
        array(
        'label' => 'View',
        'icon' => 'eye-open',
        'url' => array('application/view', 'id' => $model->application->id),
        ),
); ?>

<?php
    $this->renderPartial('_header_compact', array(
        'data' => $model,
)); ?>

<h1>Change checklist item state</h1>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'change-application-task-state-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<?php echo $form->dropDownList($model, 'state', ApplicationTask::getStates()); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'random white', 'label'=>'Change state')); ?>

<?php $this->endWidget(); ?>

</div>
