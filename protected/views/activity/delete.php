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

array_push($breadcrumbs, 'Delete update');
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

<h1>Delete update</h1>

<?php
    $this->renderPartial('/activity/_view', array(
        'data' => $model,
        'depth' => 'student',
    ));
?>


<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to delete this activity.</p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'delete-activity-form',
    )); ?>

    <?php echo CHtml::hiddenField('Delete[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'danger',
        'icon'=>'trash white',
        'size' => 'large',
        'label'=>'Delete update'
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>