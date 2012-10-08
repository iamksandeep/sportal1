<?php
    // Get current user model
    if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
    // show profile of student
    $this->showProfileFor = $student;
    // current menu item
    $this->currentProfileMenuItem = 'Activity';
?>

<h2>Activity &amp; Log</h2>

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
