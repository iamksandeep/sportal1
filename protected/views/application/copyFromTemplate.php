<?php
    // show profile of student
    $this->showProfileFor = $model->student;
    // current menu item
    $this->currentProfileMenuItem = 'Applications';
?>

<?php
    $this->renderPartial('/application/_header_compact', array(
        'data' => $model,
)); ?>

<h2>Copy application <?php echo $_GET['item_to_copy']; ?> from another application</h2>
<br />

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'select-user-form',
    'htmlOptions'=>array('class'=>'form form-inline'),
)); ?>
    <label for="User_id">First, select the student whose application you want to use as a template:</label>
    <br />

    <?php echo $form->dropDownList($student, 'id', CHtml::listData(User::getStudentUsers(), 'id', 'name')); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'label'=>'Next')); ?>
<?php $this->endWidget(); ?>

<?php if($showApplicationDropdown) { ?>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'select-application-form',
    'htmlOptions'=>array('class'=>'form form-inline'),
)); ?>
    <label for="application_id">Select the student application which you want to use as the template:</label>
    <br />

    <?php echo $form->dropDownList($application, 'id', CHtml::listData($student->getApplicationList(), 'id', 'title')); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type'=>'danger', 'label'=>'Copy '.$_GET['item_to_copy'])); ?>
<?php $this->endWidget(); ?>

<?php } ?>
