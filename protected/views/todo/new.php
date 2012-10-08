<?php
    // show profile of student
    $this->showProfileFor = $model->student;
?>

<h1>Assign Task</h1>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'new-assign-form',
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array('class'=>'well'),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

        <?php echo $form->labelEx($model,'assignee_id'); ?>
        <?php $this->renderPartial('/user/_gravatar', array(
            'user' => $assignee,
            'size' => 14,
        )); ?>
        <?php echo CHtml::link(CHtml::encode($assignee->name), array('user/view', 'id' => $assignee->id)); ?>
        <br /><br />

        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title'); ?>
        <?php echo $form->error($model,'title'); ?>
        <br />

        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description', array('class' => 'markItUp')); ?>
        <?php $this->renderPartial('/common/_markItUp'); ?>
        <?php echo $form->error($model,'description'); ?>

        <?php echo $form->labelEx($model,'deadline'); ?>
        <?php echo $form->textField($model,'deadline', array( 'class' => 'datepicker' )); ?>
        <?php echo $form->error($model,'deadline'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'pencil white', 'label'=>'Assign')); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl . '/js/datepicker.js' ); ?>
