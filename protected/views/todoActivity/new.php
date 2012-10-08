<?php
    // show profile of student
    $this->showProfileFor = $model->todo->student;
?>

<?php
    $this->renderPartial('/todo/_header_compact', array(
        'data' => $model->todo,
)); ?>

<h2>Post update</h2>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'add-todo-activity-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<?php echo $form->errorSummary($model); ?>


    <?php echo $form->labelEx($model,'comment'); ?>
    <?php echo $form->textArea($model, 'comment', array('class' => 'markItUp')); ?>
    <?php $this->renderPartial('/common/_markItUp'); ?>
    <?php echo $form->error($model,'comment'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'comment white', 'label'=>'Post update')); ?>

<?php $this->endWidget(); ?>

</div>
