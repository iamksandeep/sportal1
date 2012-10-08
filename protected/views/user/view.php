<?php
$this->breadcrumbs=array(
    $model->name,
); ?>

<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
    // side menu
    $this->renderPartial('_sideMenu', array(
        'model' => $model,
        'currentUser' => $currentUser,
)); ?>


<?php
    // header
    $this->renderPartial('_header', array(
        'data' => $model,
        'currentUser' => $currentUser,
        'roleAssignments' => isset($roleAssignments) ? $roleAssignments : null,
)); ?>


<?php
    // if student, render student related stuff
    if($model->type0 === 'student')
        $this->renderPartial('_profileStudent', array(
            'model' => $model,
            'currentUser' => $currentUser,
            'applicationData' => $applicationData,
            'academicData' => $academicData,
            'activityData' => $activityData,
            'profileData' => $profileData,
            'generalDocumentData' => $generalDocumentData,
            'contentDocumentData' => $contentDocumentData,
            'pendingApprovals' => $pendingApprovals,
            'roleAssignments' => $roleAssignments,
        ));
    elseif($model->id === $currentUser->id)
        $this->renderPartial('_profileMnemonic', array(
            'model' => $model,
            'currentUser' => $currentUser,
            'messageData' => $messageData,
            'jobData' => $jobData,
            'notificationData' => $notificationData,
            'studentData' => $studentData,
        ));
?>

<!-- shortcode -->
<div class="shortCode">
<span class="text">shortcode</span>
<span class="code">:usr_<?php echo $model->id; ?>:</span>
</div>
