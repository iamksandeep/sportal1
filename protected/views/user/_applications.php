<h2>University applications</h2>

<br />
<?php
// access check
if(Yii::app()->user->checkAccess('addApplication', array(
    'student' => $student,
    'currentUser' => User::model()->findByPk(Yii::app()->user->id),
  ))) { ?>
<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Add a new application',
    'icon' => 'folder-open',
    'url' => array('application/add', 'student_id' => $student->id),
)); ?>
<?php } ?>

<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$applicationData,
  'itemView'=>'/application/_view',
  'summaryText' => '<strong>{count}</strong> applications',
)); ?>
