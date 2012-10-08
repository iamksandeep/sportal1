<?php
    // show profile of student
    $this->showProfileFor = $model->student;
?>

<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<div class="row-fluid">
    <div class="span8">
    <h1><?php echo CHtml::encode($model->title); ?></h1>
    <br />
    <?php
    if($model->assigner_id === $currentUser->id || Yii::app()->user->checkAccess('editJobDetails', array(
        'student' => $model->student,
        'currentUser' => $currentUser,
    )))
        $this->widget('bootstrap.widgets.BootButton', array(
            'size' => 'mini',
            'label'=>'edit',
            'icon' => 'edit',
            'url' => array('todo/edit', 'id' => $model->id),
        ));
    ?>
    </div>

    <div class="span4">
    <?php
        $btnArray = array();
        foreach(Todo::getStates() as $sId => $sName) {
            if($model->state0 === $sName) continue;
            array_push($btnArray, array(
                'label' => $sName,
                'class' => ($model->state0 === $sName) ? 'active' : null,
                'url' => array('todo/changeState', 'id' => $model->id, 'state' => $sId),
            ));
        }
    ?>
    <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
            'type'=>$model->stateButtonClass, // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'buttons'=>array(
                array(
                    'label'=>$model->state0,
                    'size' => 'large',
                    'icon' => $model->stateIconClass.' white',
                    'items'=>$btnArray
                ),
            ),
            'htmlOptions' => array('class' => 'pull-right'),
    )); ?>
    </div>
</div>

<br />
<table class="table table-striped table-bordered">
<thead>
    <tr>
    <th>JobID</th>
    <th>Assigned to</th>
    <th>Assigned by</th>
    <th>Initiate time</th>
    <th>Deadline</th>
    </tr>
</thead>
<tbody>
    <tr>
    <td><?php echo $model->id; ?></td>
    <td><?php $this->renderPartial('/user/_nameLink', array('user' => $model->assignee)); ?></td>
    <td><?php $this->renderPartial('/user/_nameLink', array('user' => $model->assigner)); ?></td>
    <td>
    <?php $this->renderPartial('/common/_time', array('timestamp' => $model->initiate_time)); ?>
    </td>
    <td>
        <?php if($model->deadline) { ?>
        <span class="label label-important">
        <abbr title="Task Deadline: <?php echo CHtml::encode($model->deadline0); ?>">
        <i class="icon-calendar icon-white"></i> <?php echo CHtml::encode($model->niceDeadline); ?>
        </abbr>
        </span>
        <?php } else { ?>
        <p><small><em>no deadline</em></small></p>
        <?php } ?>
    </td>
    </tr>
</tbody>
</table>

<?php if(!$model->approved) {?>
<div class="alert alert-block">
    <h2>Approval required.</h2>
    <p>
    This job requires the approval of a manager.
    </p>

<?php
// access check
if(Yii::app()->user->checkAccess('approveJob', array(
    'student' => $model->student,
    'currentUser' => User::model()->findByPk(Yii::app()->user->id),
  ))) { ?>
    <br />
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Approve and assign to student',
        'type' => 'danger',
        'url' => array('todo/approve', 'id' => $model->id),
    )); ?>
<?php } ?>
</div>
<?php } ?>


<h2>Job description</h2>
<p><?php echo $model->parsedDescription; ?></p>

<hr />


<!-- tabs -->
<div class="tabbable">
<ul class="nav nav-tabs" id="infoTabs">
      <li class="active">
        <a href="#activity" data-toggle="tab">
        <i class='icon-comment'></i> Activity
        </a>
      </li>
      <li>
        <a href="#documents" data-toggle="tab">
        <i class='icon-file'></i> Documents
        </a>
      </li>
    </ul>

    <!-- tab content -->
    <div class="tab-content">
      <div class="tab-pane active" id="activity">
        <?php $this->renderPartial('_activity', array(
            'model' => $model,
            'activityData' => $activityData,
        )); ?>
      </div><!-- activity -->

      <div class="tab-pane" id="documents">
        <?php $this->renderPartial('_documents', array(
            'model' => $model,
            'documentData' => $documentData,
        )); ?>
      </div><!-- documents -->
</div>
</div>

