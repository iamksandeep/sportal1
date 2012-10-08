<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
// access check
if(Yii::app()->user->checkAccess('postApplicationActivity', array(
    'student' => $application->student,
    'currentUser' => $currentUser,
  ))) { ?>
<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Post an update',
    'icon' => 'comment',
    'url' => array('activity/postApplicationActivity', 'application_id' => $application->id),
    'htmlOptions' => array('class' => 'pull-right'),
)); ?>
<br /><br />
<?php } ?>

<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$activityData,
  'itemView'=>'/activity/_view',
  'viewData'=>array(
    'depth' => 'application',
    'adminControls' => Yii::app()->user->checkAccess('adminActivity', array(
      'student' => $application->student,
      'currentUser' => $currentUser,
    )),
  ),
  'summaryText' => '',
  'emptyText' => '<small><em>(no activity yet)</em></small>',
)); ?>
