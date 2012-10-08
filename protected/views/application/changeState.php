<?php
$this->breadcrumbs=array(
    $model->student->name => array('user/view', 'id' => $model->student->id),
    $model->title.' application' => array('application/view', 'id' => $model->id),
    'Change application state',
); ?>

<?php $this->menu = array(
    array(
    'label' => 'Application',
    ),
    array(
    'label' => 'View',
    'icon' => 'eye-open',
    'url' => array('application/view', 'id' => $model->id),
    ),
); ?>

<?php
    $this->renderPartial('_header_compact', array(
        'data' => $model,
)); ?>

<h2>Change application state</h2>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'change-application-state-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<?php echo $form->dropDownList($model, 'state', Application::getStates()); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'random white', 'label'=>'Change state')); ?>

<?php $this->endWidget(); ?>

</div>