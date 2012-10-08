<?php
$this->breadcrumbs=array(
    'Latest activity',
); ?>

<h2>Latest activity</h2>
<br />


<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$activityData,
  'itemView'=>'/activity/_viewWithStudent',
  'viewData'=>array(
    'depth' => 'student',
  ),
  'summaryText' => '',
  'emptyText' => '<small><em>(no activity yet)</em></small>',
)); ?>
