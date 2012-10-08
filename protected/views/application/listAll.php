<?php
    // Get current user model
    if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
$this->breadcrumbs=array(
    'View applications by deadline',
); ?>

<div class="row-fluid">
    <div class="span4">
    <h1>Applications</h1>
    </div>

    <div class="span8">
    <form class="form-inline pull-right" method="POST">
        Viewing applications with deadline between
        <input class="input-small datepicker" type="text" value="<?php echo $time_start; ?>" name="time_start" />
        and
        <input class="input-small datepicker" type="text" value="<?php echo $time_end; ?>" name="time_end" />
        <button type="submit" class="btn">Apply</button>
    </form>
    </div>
</div>

<?php
if(
    $appData['in-progress']->totalItemCount
    + $appData['complete']->totalItemCount
    + $appData['shortlisted']->totalItemCount
    + $appData['inactive']->totalItemCount == 0
) echo '<p class="muted">no applications found</p>';
?>

<?php
    $state = 'in-progress';
    $this->renderPartial('_applicationList', array(
        'data' => $appData[$state],
        'state' => $state,
        'currentUser' => $currentUser,
        'showStudent' => true,
)); ?>

<?php
    $state = 'shortlisted';
    $this->renderPartial('_applicationList', array(
        'data' => $appData[$state],
        'state' => $state,
        'currentUser' => $currentUser,
        'showStudent' => true,
)); ?>

<?php
    $state = 'complete';
    $this->renderPartial('_applicationList', array(
        'data' => $appData[$state],
        'state' => $state,
        'currentUser' => $currentUser,
        'showStudent' => true,
)); ?>

<?php
    $state = 'inactive';
    $this->renderPartial('_applicationList', array(
        'data' => $appData[$state],
        'state' => $state,
        'currentUser' => $currentUser,
        'showStudent' => true,
)); ?>


<?php Yii::app()->clientScript->registerScriptFile( Yii::app()->baseUrl . '/js/datepicker.js' ); ?>
