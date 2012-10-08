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

<h1>Remove application detail</h1>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to remove this detail</p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'remove-application-detail-form',
    )); ?>

    <?php echo CHtml::hiddenField('Remove[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'danger',
        'icon'=>'trash white',
        'size' => 'large',
        'label'=>'Remove detail'
    )); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'size'=>'large',
        'label'=>'Go back',
        'icon'=>'arrow-left',
        'url' => array('application/view', 'id' => $model->application->id),
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
