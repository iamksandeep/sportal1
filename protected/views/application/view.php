<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>
<?php
    // show profile of student
    $this->showProfileFor = $model->student;
    // current menu item
    $this->currentProfileMenuItem = 'Applications';
?>

<div class="row-fluid">
    <div class="span8">
    <h1>
    <?php echo CHtml::encode($model->university); ?>
    </h1>
    <p><big><?php echo $model->course; ?></big>
      <br />
      <?php if($model->deadline) { ?>
        <i title="<?php echo ucfirst($model->type0); ?> university" class="icon-<?php echo $model->typeIconClass; ?>  application-type-icon"></i>
        <span class="label label-important">
        <abbr title="Application Deadline: <?php echo CHtml::encode($model->deadline0); ?>">
        <i class="icon-calendar icon-white"></i> <?php echo CHtml::encode($model->niceDeadline); ?>
        </abbr>
        </span>
      <?php } ?>
    </p>


      <?php
        // admin controls
        $btns = array();

        if(Yii::app()->user->checkAccess('editApplication', array(
            'student' => $model->student,
            'currentUser' => $currentUser,
        )))
            array_push($btns, array(
                'label'=>'edit',
                'icon' => 'edit',
                'url' => array('application/edit', 'id' => $model->id),
            ));

        if(Yii::app()->user->checkAccess('removeApplication', array(
            'student' => $model->student,
            'currentUser' => $currentUser,
        )))
            array_push($btns, array(
                'label'=>'remove',
                'icon' => 'trash',
                'url' => array('application/remove', 'id' => $model->id),
            ));


        $this->widget('bootstrap.widgets.BootButtonGroup', array(
            'size' => 'mini',
            'buttons'=>$btns,
        ));
      ?>
    </div>

    <div class="span4">
    <?php
        $btnArray = array();
        foreach(Application::getStates() as $sId => $sName) {
            if($model->state0 === $sName) continue;
            array_push($btnArray, array(
                'label' => $sName,
                'class' => ($model->state0 === $sName) ? 'active' : null,
                'url' => array('application/changeState', 'id' => $model->id, 'state' => $sId),
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
                    'items'=>$btnArray,
                ),
            ),
            //'htmlOptions' => array('class' => 'pull-right'),
    )); ?>

    <br />

    <?php $progress = $model->progress; ?>
    <?php $this->widget('bootstrap.widgets.BootProgress', array(
        'type'=>Application::getProgressBarClass($progress),
        'percent'=>$progress,
        'striped'=>true,
        'animated'=>($progress !== 100),
    )); ?>
    <p class="pull-right"><small><em><?php echo $progress; ?>% complete</em></small></p>
    </div>
</div>
<br />

<?php
if($model->state0 === 'inactive') {
?>
<div class="alert">
  <strong>Note:</strong> This application is currently inactive.
</div>
<?php
}
?>


<!-- tabs -->
<div class="tabbable">
<ul class="nav nav-tabs" id="applicationTabs">
  <li>
    <a href="#details" data-toggle="tab">
    <i class='icon-info-sign'></i> Details
    </a>
  </li>
  <li class="active">
    <a href="#checklist" data-toggle="tab">
    <i class='icon-list'></i> Checklist
    </a>
  </li>
  <li>
    <a href="#activity" data-toggle="tab">
    <i class='icon-comment'></i> Activity
    </a>
  </li>
</ul>

<!-- tab content -->
<div class="tab-content">

  <div class="tab-pane" id="details">
      <?php $this->renderPartial('_credentials', array(
          'model' => $model,
          'currentUser' => $currentUser,
      )); ?>
      <?php $this->renderPartial('_applicationDetails', array(
          'model' => $model,
          'currentUser' => $currentUser,
      )); ?>

  </div><!-- details -->

  <div class="tab-pane active" id="checklist">
      <?php $this->renderPartial('_checklist', array(
          'model' => $model,
          'taskData' => $taskData,
          'currentUser' => $currentUser,
      )); ?>
  </div>

  <div class="tab-pane" id="activity">
    <?php
        $this->renderPartial('_activity', array(
            'activityData' => $activityData,
            'application' => $model,
            'currentUser' => $currentUser,
    )); ?>
  </div><!-- activity -->

</div>
</div>

<!-- shortcode -->
<div class="shortCode">
<span class="text">shortcode</span>
<span class="code">:app_<?php echo $model->id; ?>:</span>
</div>
