<?php
    // show profile of student
    $this->showProfileFor = $student;
    // current menu item
    $this->currentProfileMenuItem = 'Profile';
?>

<h2>Manage roles</h2>

<?php
    $this->renderPartial('/common/_assignments', array(
        'roleAssignments' => $roles,
        'student' => $student,
        'manage' => true,
)); ?>


<h3>Assign role</h3>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
  'id'=>'role-assignment-form',
  'enableAjaxValidation'=>false,
  'action' => Yii::app()->createUrl('roles/assign'),
  'htmlOptions'=>array('class'=>'well'),
)); ?>

    <?php echo CHtml::hiddenFIeld('Assign[student_id]', $student->id); ?>

    <?php echo CHtml::label('Select user', 'user_id'); ?>
    <?php echo CHtml::dropDownList('Assign[user_id]', 'user_id', CHtml::listData(User::getMnemonicUsers(), 'id', 'name')); ?>

    <?php echo CHtml::label('Select role', 'role_id'); ?>
    <?php echo CHtml::dropDownList('Assign[role]', 'role_id', RoleManager::getRoles()); ?>

    <div class="clear"></div>
    <?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'user white', 'label'=>'Assign role')); ?>

<?php $this->endWidget(); ?>
