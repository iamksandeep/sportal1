<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>


<?php
$this->breadcrumbs=array(
    'Messages',
);?>

<h1>Messages</h1>

<div class="row-fluid">
  <div class="span12">
  <?php
    if($currentUser->type0==='student') {
      $msgB = array();

      foreach($currentUser->getRoleManager()->getAssignmentsInRole('manager') as $role) {
          array_push($msgB, array(
              'label' => $role->user->name,
              'url' => array('message/composeFromStudent', 'to' => $role->user->id, 'student_id' => $role->student_id),
          ));
      }

      $this->widget('bootstrap.widgets.BootButtonGroup', array(
          'type' => 'danger',
          'buttons'=>array(
              array(
                  'label' => 'Send message to your manager',
                  'icon' => 'envelope white',
                  'items' => $msgB,
              ),
          ),
          'htmlOptions' => array('class' => 'pull-right'),
      ));
    }
    else {
      $this->widget('bootstrap.widgets.BootButton', array(
          'type' => 'danger',
          'label' => 'New message',
          'icon' => 'envelope white',
          'url' => array('message/new'),
          'htmlOptions' => array('class' => 'pull-right'),
      ));
    }
   ?>
  </div>
</div>
<br />
<br />

<div class="message header">
<div class="row-fluid">
    <div class="span1">
    </div>

    <div class="span2">
    with
    </div>

<?php if(Yii::app()->user->type!='student') { ?>
    <div class="span2">
    student
    </div>
<?php } ?>

    <div class="span4">
    message
    </div>

    <div class="span2">
    time
    </div>
</div>
</div>


<?php
    foreach($conversations as $c) {
        $this->renderPartial('/conversation/_view', array(
            'data' => $c,
        ));
    }
?>
