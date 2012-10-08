<?php
$this->breadcrumbs=array(
    $model->application->student->name => array('user/view', 'id' => $model->application->student->id),
    $model->application->title.' application' => array('application/view', 'id' => $model->application->id),
    'Upload '.$model->type0. ' document',
);?>
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
    $this->renderPartial('/application/_header_compact', array(
        'data' => $model->application,
)); ?>

<h2>Upload <?php echo $model->type0; ?> document</h2>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id'=>'document-uploadApplicationDocument-form',
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
