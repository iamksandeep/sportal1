<?php
$this->breadcrumbs=array(
    $model->name => array('user/view', 'id' => $model->id),
    'Change type',
); ?>

<?php $this->menu = array(
        array(
        'label' => $model->name,
        ),
        array(
        'label' => 'View',
        'icon' => 'eye-open',
        'url' => array('user/view', 'id' => $model->id),
        ),
); ?>

<?php
    $this->renderPartial('_header_compact', array(
        'data' => $model,
)); ?>

<h2>Change account type</h2>

<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'change-user-type-form',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<?php echo $form->dropDownList($model, 'type', User::getTypes()); ?>

<div class="clear"></div>
<?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'user white', 'label'=>'Change type')); ?>

<?php $this->endWidget(); ?>

</div>
