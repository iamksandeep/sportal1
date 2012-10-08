<?php
    // show profile of student
    $this->showProfileFor = $model->student;
    // current menu item
    $this->currentProfileMenuItem = 'Profile';
?>

<h2>Add academic detail</h2>


<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'add-academic-detail-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($model); ?>


<?php echo $form->labelEx($model,'level'); ?>
<?php echo $form->dropDownList($model, 'level', AcademicDetail::getLevels()); ?>
<?php echo $form->error($model,'level'); ?>

<?php echo $form->textFieldRow($model, 'institution'); ?>
<?php echo $form->textFieldRow($model, 'board_univ'); ?>
<?php echo $form->textFieldRow($model, 'score'); ?>

<?php echo $form->labelEx($model,'year'); ?>
<?php echo $form->dropDownList($model, 'year', AcademicDetail::getYearList()); ?>
<?php echo $form->error($model,'year'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'plus white', 'label'=>'Add detail')); ?>

<?php $this->endWidget(); ?>

</div>
