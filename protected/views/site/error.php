<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<?php $this->beginWidget('bootstrap.widgets.BootHero', array(
    'heading'=> $code,
)); ?>

<p><strong>Error: </strong><?php echo CHtml::encode($message); ?></p>

<?php $this->endWidget(); ?>