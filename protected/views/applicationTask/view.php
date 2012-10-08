<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>
<?php
    // show profile of student
    $this->showProfileFor = $model->application->student;
    // current menu item
    $this->currentProfileMenuItem = 'Applications';
?>
<?php
    $this->renderPartial('/application/_header_compact', array(
        'data' => $model->application,
)); ?>

<div class="row-fluid">
    <div class="span8">
        <h1><?php echo CHtml::encode($model->title); ?></h1>
        <br />
      <?php
        // admin controls
        $btns = array();

        if(Yii::app()->user->checkAccess('editApplicationTask', array(
            'student' => $model->application->student,
            'currentUser' => $currentUser,
        )))
            array_push($btns, array(
                'label'=>'edit',
                'icon' => 'edit',
                'url' => array('applicationTask/edit', 'id' => $model->id),
            ));

        if(Yii::app()->user->checkAccess('removeApplicationTask', array(
            'student' => $model->application->student,
            'currentUser' => $currentUser,
        )))
            array_push($btns, array(
                'label'=>'remove',
                'icon' => 'trash',
                'url' => array('applicationTask/remove', 'id' => $model->id),
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
        foreach(ApplicationTask::getStates() as $sId => $sName) {
            if($model->state0 === $sName) continue;
            array_push($btnArray, array(
                'label' => $sName,
                'class' => ($model->state0 === $sName) ? 'active' : null,
                'url' => array('applicationTask/changeState', 'id' => $model->id, 'state' => $sId),
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
            'htmlOptions' => array('class' => 'pull-right'),
    )); ?>
    </div>
</div>
<br />
<p><?php echo $model->parsedDescription; ?></p>

<?php
    $this->renderPartial('_activity', array(
        'activityData' => $activityData,
        'applicationTask' => $model,
)); ?>

<!-- shortcode -->
<div class="shortCode">
<span class="text">shortcode</span>
<span class="code">:cli_<?php echo $model->id; ?>:</span>
</div>
