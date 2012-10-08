<h2>Activity &amp; Log</h2>

<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
// access check
if(Yii::app()->user->checkAccess('postStudentActivity', array(
    'student' => $student,
    'currentUser' => $currentUser,
  ))) { ?>
<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Post an update',
    'icon' => 'comment',
    'url' => array('activity/postStudentActivity', 'student_id' => $student->id),
    'htmlOptions' => array('class' => 'pull-right'),
)); ?>
<br /><br />
<?php } ?>

<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$activityData,
  'itemView'=>'/activity/_view',
  'viewData'=>array(
    'depth' => 'student',
    'adminControls' => Yii::app()->user->checkAccess('adminActivity', array(
      'student' => $student,
      'currentUser' => $currentUser,
    )),
  ),
  'summaryText' => '',
  'emptyText' => '<small><em>(no activity yet)</em></small>',
)); ?>
