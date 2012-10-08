<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<div class="well well-small">
<h3>Application Details</h3>
<br />

<div class="pull-right">
<?php
// access check
if(Yii::app()->user->checkAccess('addApplicationDetail', array(
    'student' => $model->student,
    'currentUser' => User::model()->findByPk(Yii::app()->user->id),
  ))) { ?>
    <?php echo CHtml::link('add', array('applicationDetail/add', 'application_id' => $model->id)); ?>
<?php }
// access check
if(Yii::app()->user->checkAccess('templateApplicationDetail', array(
    'student' => $model->student,
    'currentUser' => User::model()->findByPk(Yii::app()->user->id),
  ))) { ?>
    /
    <?php echo CHtml::link('copy from template', array('application/copyFromTemplate', 'id' => $model->id, 'item_to_copy' => 'details')); ?>
<?php } ?>
</div>

<?php
// edit and delete access check
$editAccess = Yii::app()->user->checkAccess('editApplicationDetail', array(
                'student' => $model->student,
                'currentUser' => $currentUser,
              ));
$deleteAccess = Yii::app()->user->checkAccess('removeApplicationDetail', array(
                'student' => $model->student,
                'currentUser' => $currentUser,
              ));
?>



<?php if(sizeof($model->applicationDetails) > 0) { ?>
<table class="table table-condensed">
<tbody>

<?php foreach($model->applicationDetails as $detail) { ?>
    <tr>
    <th><?php echo CHtml::encode($detail->title); ?></th>
    <td><?php echo strip_tags(trim($detail->content)) != "" ? $detail->parsedContent : '<p class="muted">not-set</p>'; ?></td>
    <td>
    <?php if($editAccess) echo CHtml::link('<i class="icon-edit"></i>', array('applicationDetail/edit', 'id' => $detail->id)); ?>
    <?php if($deleteAccess) echo CHtml::link('<i class="icon-trash"></i>', array('applicationDetail/remove', 'id' => $detail->id)); ?>
    </td>
    </tr>
<?php } ?>

</tbody>
</table>
<?php } else { ?>
<p class="muted">no details added yet</p>
<?php } ?>

</div>
