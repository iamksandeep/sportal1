<?php
$breadcrumbs = array(
    $model->student->name => array('user/view', 'id' => $model->student->id),
);

$menu = array(
    array(
    'label' => $model->student->name,
    ),
    array(
    'label' => 'View',
    'icon' => 'eye-open',
    'url' => array('user/view', 'id' => $model->student->id),
    ),
);

if($model->application) {
    $breadcrumbs[$model->application->title.' application'] = array('application/view', 'id' => $model->application->id);

    $menu = array(
        array(
        'label' => 'Application',
        ),
        array(
        'label' => 'View',
        'icon' => 'eye-open',
        'url' => array('application/view', 'id' => $model->application->id),
        ),
    );
}

if($model->applicationTask) {
    $breadcrumbs[$model->applicationTask->title.' (Task)'] = array('applicationTask/view', 'id' => $model->applicationTask->id);

    $menu = array(
        array(
        'label' => $model->applicationTask->title,
        ),
        array(
        'label' => 'View',
        'icon' => 'eye-open',
        'url' => array('applicationTask/view', 'id' => $model->applicationTask->id),
        ),
        array(
        'label' => 'Application',
        ),
        array(
        'label' => 'View',
        'icon' => 'eye-open',
        'url' => array('application/view', 'id' => $model->application->id),
        ),
    );
}

array_push($breadcrumbs, 'Edit update');
$this->breadcrumbs=$breadcrumbs;
?>
<?php $this->menu = $menu; ?>


<?php
    if($model->applicationTask)
        $this->renderPartial('/applicationTask/_header_compact', array(
        'data' => $model->applicationTask,
        ));
    elseif($model->application)
        $this->renderPartial('/application/_header_compact', array(
        'data' => $model->application,
        ));
    else
        $this->renderPartial('/user/_header_compact', array(
        'data' => $model->student,
        ));
?>

<h1>Edit update</h1>

<?php
    $this->renderPartial('/activity/_view', array(
        'data' => $model,
        'depth' => 'student',
    ));
?>


<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'add-activity-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->labelEx($model,'comment'); ?>
<?php echo $form->textArea($model, 'comment', array('class' => 'markItUp')); ?>
<?php $this->renderPartial('/common/_markItUp'); ?>
<?php echo $form->error($model,'comment'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'edit white', 'label'=>'Edit update')); ?>

<?php $this->endWidget(); ?>

</div>
