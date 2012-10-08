<?php
    // show profile of student
    $this->showProfileFor = $model->student;
    // current menu item
    $this->currentProfileMenuItem = 'Profile';
?>

<h2>Edit academic detail</h2>


<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'edit-academic-detail-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<?php echo $form->errorSummary($model); ?>

<h2><?php echo $model->level0; ?></h2>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->textFieldRow($model, 'institution'); ?>
<?php echo $form->textFieldRow($model, 'board_univ'); ?>
<?php echo $form->textFieldRow($model, 'score'); ?>

<?php echo $form->labelEx($model,'year'); ?>
<?php echo $form->dropDownList($model, 'year', AcademicDetail::getYearList()); ?>
<?php echo $form->error($model,'year'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'edit white', 'label'=>'Edit detail')); ?>

<?php $this->endWidget(); ?>

</div>
