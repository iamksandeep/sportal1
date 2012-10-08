<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<p>
<?php
// access check
if(Yii::app()->user->checkAccess('viewOwnJobApprovals', array(
    'student' => $student,
    'currentUser' => $currentUser,
  ))) { ?>
    These are jobs which are assigned to the student by You. But they require an approval by the manager before they can be forwarded to the student.
<?php } else { ?>
    These are jobs which are assigned to the student by counselors, researchers or content-writers.
    They require an approval by the manager before they can be forwarded to the student.
<?php } ?>
</p>

<?php if($pendingApprovals) { ?>
<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$pendingApprovals,
  'itemView'=>'/todo/_view',
  'summaryText' => '{count} jobs',
  'emptyText' => '<small><em>No jobs</em></small>',
)); ?>
<?php } ?>
