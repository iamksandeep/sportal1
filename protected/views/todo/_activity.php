<div class="row-fluid">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Post an update',
        'icon' => 'comment',
        'url' => array('todoActivity/new', 'todo_id' => $model->id),
        'htmlOptions' => array('class' => 'pull-right'),
    )); ?>
</div>

<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$activityData,
  'itemView'=>'/todoActivity/_view',
  'summaryText' => '',
  'emptyText' => '<small><em>(no activity)</em></small>',
)); ?>
