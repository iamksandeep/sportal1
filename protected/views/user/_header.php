<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<div class="row-fluid">
    <!-- BIG GRAVATAR -->
    <div class="span1">
    <?php $this->renderPartial('/user/_gravatar', array(
        'user' => $data,
    )); ?>
    </div>

    <!-- NAME AND EMAIL -->
    <div class="span8">
    <h1><?php echo CHtml::encode($data->name); ?></h1>
    <p><?php echo CHtml::encode($data->email); ?></p>
    </div>

    <?php if($data->type0 === 'student') { ?>
    <!-- INTERACTION CONTROLS -->
    <div class="span3">

    <?php
    // access check
    if(Yii::app()->user->checkAccess('viewDocuments', array(
        'student' => $data,
        'currentUser' => $currentUser,
    )))  {
    ?>
    <!-- documents -->
    <div class="span4">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Documents',
        'icon' => 'file white',
        //'size' => 'large',
        'type' => 'danger',
        'url' => array('document/index', 'student_id' => $data->id),
    )); ?>
    </div>
    <?php } ?>


    <?php $this->renderPartial('_interactionControls', array(
        'user' => $data,
        'currentUser' => $currentUser,
        'roleAssignments' => isset($roleAssignments) ? $roleAssignments : null,
    )); ?>
    </div>
    <?php } ?>
</div>

<hr />

<?php if($data->disabled) { ?>
<!-- DISABLED USER ALERT -->
    <div class="alert">
    <strong>Note:</strong> This user is currently disabled.
    </div>
<?php } ?>
