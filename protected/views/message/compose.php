<?php
    // show profile of student
    $this->showProfileFor = $conv->student;
?>

<h1>Compose message</h1>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'message-new-form',
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array('class'=>'well'),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($conv); ?>
    <?php echo $form->errorSummary($msg); ?>

        <?php echo $form->labelEx($conv,'to'); ?>
        <?php $this->renderPartial('/user/_gravatar', array(
            'user' => $_to,
            'size' => 14,
        )); ?>
        <?php echo CHtml::link(CHtml::encode($_to->name), array('user/view', 'id' => $_to->id)); ?>
        <br /><br />

        <?php echo $form->labelEx($conv,'subject'); ?>
        <?php echo $form->textField($conv,'subject'); ?>
        <?php echo $form->error($conv,'subject'); ?>
        <br />

        <?php echo $form->labelEx($msg,'content'); ?>
        <?php echo $form->textArea($msg, 'content', array('class' => 'markItUp')); ?>
        <?php $this->renderPartial('/common/_markItUp'); ?>
        <?php echo $form->error($msg,'content'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'envelope white', 'label'=>'Send')); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
