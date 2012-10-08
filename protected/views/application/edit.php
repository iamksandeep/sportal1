<?php
    // show profile of student
    $this->showProfileFor = $model->student;
    // current menu item
    $this->currentProfileMenuItem = 'Applications';
?>

<h2>Edit application details</h2>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'edit-application-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($model); ?>


<?php echo $form->labelEx($model,'university'); ?>
<?php echo $form->dropDownList($model, 'university', Application::getListOfUniversities()); ?>
&nbsp;<small>or other:</small><?php echo $form->textField($model, 'university_other'); ?>
<?php echo $form->error($model,'university'); ?>

<?php echo $form->labelEx($model,'course'); ?>
<?php echo $form->dropDownList($model, 'course', Application::getListOfCourses()); ?>
&nbsp;<small>or other:</small><?php echo $form->textField($model, 'course_other'); ?>
<?php echo $form->error($model,'course'); ?>

<?php echo $form->labelEx($model,'type'); ?>
<?php echo $form->dropDownList($model, 'type', Application::getTypes()); ?>
<?php echo $form->error($model,'type'); ?>

<?php echo $form->labelEx($model,'deadline'); ?>
<?php echo $form->textField($model,'deadline', array( 'class' => 'datepicker' )); ?>
<?php echo $form->error($model,'deadline'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'edit white', 'label'=>'Edit application')); ?>

<?php $this->endWidget(); ?>

</div>

<?php Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl . '/js/datepicker.js' ); ?>
