<?php
    // show profile of student
    $this->showProfileFor = $conv->student;
?>

<?php $this->renderPartial('_header', array(
    'conv' => $conv,
)); ?>

<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Reply',
    'icon' => 'envelope',
    'url' => array('message/reply', 'conv_id' => $conv->id),
    'htmlOptions' => array('class' => 'pull-right'),
)); ?><br /><br />

<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$messageDataProvider,
  'itemView'=>'/message/_view',
  'summaryText' => '<strong>{count}</strong> messages',
)); ?>

<div class="clear"></div>
<br />
<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Reply',
    'icon' => 'envelope',
    'url' => array('message/reply', 'conv_id' => $conv->id),
    'htmlOptions' => array('class' => 'pull-right'),

)); ?><br /><br />
