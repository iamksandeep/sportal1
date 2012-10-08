<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Upload document',
    'icon' => 'file white',
    'type' => 'danger',
    'url' => array(
                'todoDocument/upload',
                'todo_id' => $model->id,
             ),
)); ?>

<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$documentData,
  'itemView'=>'/todoDocument/_view',
  'summaryText' => '<strong>{count}</strong> documents',
  'emptyText' => '<small><em>(no documents)</em></small>',
)); ?>
