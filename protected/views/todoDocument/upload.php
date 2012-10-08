<?php
    // show profile of student
    $this->showProfileFor = $model->todo->student;
?>

<?php
    $this->renderPartial('/todo/_header_compact', array(
        'data' => $todo,
)); ?>

<h2>Upload document</h2>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'document-upload-form',
    'htmlOptions'=>array('class'=>'well', 'enctype' => 'multipart/form-data'),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->labelEx($model, 'file'); ?>
    <?php echo $form->fileField($model, 'file'); ?>
    <?php echo $form->error($model, 'file'); ?>

    <?php echo $form->labelEx($model,'title'); ?>
    <?php echo $form->textField($model,'title'); ?>
    <?php echo $form->error($model,'title'); ?>

    <?php echo $form->labelEx($model,'description'); ?>
    <?php echo $form->textArea($model, 'description', array('class' => 'markItUp')); ?>
    <?php $this->renderPartial('/common/_markItUp'); ?>
    <?php echo $form->error($model,'description'); ?>

    <div class="clear"></div>
    <?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'file white', 'label'=>'Upload document')); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
