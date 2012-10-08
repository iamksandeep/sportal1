<?php
    // show profile of student
    $this->showProfileFor = $conv->student;
?>

<?php
    $this->renderPartial('/conversation/_header', array(
        'conv' => $conv,
)); ?>

<h2>Reply</h2>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'message-reply-form',
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array('class'=>'well'),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($msg); ?>

    <?php echo $form->labelEx($msg,'content'); ?>
    <?php echo $form->textArea($msg, 'content', array('class' => 'markItUp')); ?>
    <?php $this->renderPartial('/common/_markItUp'); ?>
    <?php echo $form->error($msg,'content'); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'envelope white', 'label'=>'Send')); ?>
&nbsp;&nbsp;
<?php $this->widget('bootstrap.widgets.BootButton', array(
                    'icon'=>'arrow-left',
                    'label'=>'Back to Conversation',
                    'url' => array('conversation/view', 'id' => $conv->id),
                 )); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
