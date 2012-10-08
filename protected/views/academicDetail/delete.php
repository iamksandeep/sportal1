<?php
    // show profile of student
    $this->showProfileFor = $model->student;
    // current menu item
    $this->currentProfileMenuItem = 'Profile';
?>

<h2>Remove academic detail</h2>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to remove the academic detail about <strong><?php echo $model->level0; ?></strong></p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'remove-detail-form',
    )); ?>

    <?php echo CHtml::hiddenField('Remove[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'danger',
        'icon'=>'trash white',
        'size' => 'large',
        'label'=>'Delete detail'
    )); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'size'=>'large',
        'label'=>'Go back',
        'icon'=>'arrow-left',
        'url' => array('user/view', 'id' => $model->student->id),
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
