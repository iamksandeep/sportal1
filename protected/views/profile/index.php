<?php
    // Get current user model
    if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
    // show profile of student
    $this->showProfileFor = $model;
    // current menu item
    $this->currentProfileMenuItem = 'Profile';
?>

<div class="pull-right">
<?php
    // menu
    $this->renderPartial('/profile/_sideMenu', array(
        'model' => $model,
        'currentUser' => $currentUser,
)); ?>
</div>


<?php
    $this->renderPartial('/user/_profileStudent', array(
        'roleAssignments' => $roleAssignments,
        'model' => $model,
        'currentUser' => $currentUser,
        'applicationData' => $applicationData,
        'academicData' => $academicData,
        'activityData' => $activityData,
        'profileData' => $profileData,
        'generalDocumentData' => $generalDocumentData,
        'contentDocumentData' => $contentDocumentData,
        'tasksToStudent' => $tasksToStudent,
        'roleAssignments' => $roleAssignments,
)); ?>

