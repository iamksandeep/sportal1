<?php
$this->breadcrumbs=array(
    $model->student->name => array('user/view', 'id' => $model->student->id),
    'Revoke role',
); ?>

<?php $this->menu = array(
        array(
        'label' => $model->student->name,
        ),
        array(
        'label' => 'Manage roles',
        'icon' => 'user',
        'url' => array('roles/manage', 'student_id' => $model->student->id),
        ),
); ?>

<?php
    $this->renderPartial('/user/_header_compact', array(
        'data' => $model->student,
)); ?>

<h2>Revoke role</h2>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=>'Are you sure?',
)); ?>

    <p>You are about to revoke <strong><?php echo $model->user->name; ?></strong>'s role as <em><?php echo RoleManager::getRoleName($model->role); ?></em></p>

    <?php /** @var BootActiveForm $form */
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id'=>'revoke-role-form',
    )); ?>

    <?php echo CHtml::hiddenField('Revoke[id]', $model->id); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type' => 'danger',
        'icon'=>'remove white',
        'size' => 'large',
        'label'=>'Revoke role'
    )); ?>

    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'size'=>'large',
        'label'=>'Go back',
        'icon'=>'arrow-left',
        'url' => array('roles/manage', 'student_id' => $model->student->id),
    )); ?>

    <?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
