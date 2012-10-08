<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
$this->breadcrumbs=array(
    'Tasks',
);?>

<div class="row-fluid">
  <div class="span7">
  <h1>Tasks</h1>
  </div>
  <div class="span5">
  <?php
    $pending = Todo::pendingApprovalsCount();
    if($pending > 0) {
  ?>
  <?php $this->widget('bootstrap.widgets.BootButton', array(
      'label'=>$pending . ' tasks need your approval',
      'type' => 'success',
      'icon' => 'info-sign white',
      'url' => array('todo/pendingApprovals'),
      'htmlOptions' => array('class' => 'pull-right'),
  )); ?>
  <?php } ?>
  </div>
</div>

<div class="row-fluid">
  <div class="span12">
  <?php
    if($currentUser->type0==='student') {
      $taskB = array();

      foreach($currentUser->getRoleManager()->getAssignmentsInRole('manager') as $role) {
          array_push($taskB, array(
              'label' => $role->user->name,
              'url' => array('todo/newFromStudent', 'assignee_id' => $role->user->id, 'student_id' => $role->student_id),
          ));
      }

      $this->widget('bootstrap.widgets.BootButtonGroup', array(
          'type' => 'primary',
          'buttons'=>array(
              array(
                  'label' => 'Assign task to your manager',
                  'icon' => 'pencil white',
                  'items' => $taskB,
              ),
          ),
          'htmlOptions' => array('class' => 'pull-right'),
      ));
    }
   ?>
  </div>
</div>
<br />

<!-- tabs -->
<ul class="nav nav-tabs" id="infoTabs">
  <li class="active">
    <a href="#to_me" data-toggle="tab">
      Tasks assigned to me
    </a>
  </li>
  <li>
    <a href="#by_me" data-toggle="tab">
      Tasks assigned by me
    </a>
  </li>
</ul>


<!-- tab content -->
<div class="tab-content">
  <div class="tab-pane active" id="to_me">
  <?php $this->renderPartial('_tab_summary'); ?>
  <?php $this->renderPartial('_list', array('state' => 'not-started', 'data' => $recvd['not-started'])); ?>
  <?php $this->renderPartial('_list', array('state' => 'in-progress', 'data' => $recvd['in-progress'])); ?>
  <?php $this->renderPartial('_list', array('state' => 'complete', 'data' => $recvd['complete'])); ?>
  </div>

  <div class="tab-pane" id="by_me">
  <?php $this->renderPartial('_tab_summary', array('sentItem' => 'true')); ?>
  <?php $this->renderPartial('_list', array('state' => 'not-started', 'data' => $sent['not-started'], 'sentItem' => true)); ?>
  <?php $this->renderPartial('_list', array('state' => 'in-progress', 'data' => $sent['in-progress'], 'sentItem' => true)); ?>
  <?php $this->renderPartial('_list', array('state' => 'complete', 'data' => $sent['complete'], 'sentItem' => true)); ?>
  </div>
</div>
