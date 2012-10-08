<?php
    // Get current user model
    if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
    // show profile of student
    $this->showProfileFor = $model->student;
    // current menu item
    $this->currentProfileMenuItem = 'Documents';
?>

<h1>Delete document</h1>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to delete this document.</p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'delete-document-form',
    )); ?>

    <?php echo CHtml::hiddenField('Delete[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'danger',
        'icon'=>'trash white',
        'size' => 'large',
        'label'=>'Delete document'
    )); ?>
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'icon'=>'arrow-left',
        'size' => 'large',
        'label'=>'Go back',
        'url' => array('document/index', 'student_id' => $model->student->id),
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
