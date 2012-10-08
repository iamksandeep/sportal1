<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>
<?php
    // show profile of student
    $this->showProfileFor = $model->application->student;
    // current menu item
    $this->currentProfileMenuItem = 'Applications';
?>
<?php
    $this->renderPartial('_header_compact', array(
        'data' => $model,
)); ?>

<h1>Remove checklist item</h1>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to remove the checklist item: <strong><?php echo $model->title; ?></strong></p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'remove-application-task-form',
    )); ?>

    <?php echo CHtml::hiddenField('Remove[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'danger',
        'icon'=>'trash white',
        'size' => 'large',
        'label'=>'Remove checklist item'
    )); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'size'=>'large',
        'label'=>'Go back',
        'icon'=>'arrow-left',
        'url' => array('applicationTask/view', 'id' => $model->id),
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
