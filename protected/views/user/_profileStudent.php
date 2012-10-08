<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<!-- tabs -->
<div class="tabbable">
    <ul class="nav nav-tabs" id="infoTabs">
      <li class="active">
        <a href="#profile" data-toggle="tab">
        <i class='icon-user'></i> Profile
        </a>
      </li>


    <?php
    // ROLES TAB
    $viewRolesTab = Yii::app()->user->checkAccess('viewRolesData', array(
        'student' => $model,
        'currentUser' => $currentUser,
    ));
    ?>
    <?php if($viewRolesTab) { ?>
      <li>
        <a href="#assignments" data-toggle="tab">
        <i class='icon-user'></i> Role Assignments
        </a>
      </li>
    <?php } ?>

    <?php
    // ROLES TAB
    $viewTasksToStudent = Yii::app()->user->checkAccess('viewTasksToStudent', array(
        'student' => $model,
        'currentUser' => $currentUser,
    ));
    ?>
    <?php if($viewTasksToStudent) { ?>
      <li>
        <a href="#tasksToStudent" data-toggle="tab">
        <i class='icon-pencil'></i> Tasks assigned to Student
        </a>
      </li>
    <?php } ?>
    </ul>

    <!-- tab content -->
    <div class="tab-content">
      <div class="tab-pane active" id="profile">
        <?php
            $this->renderPartial('_profile', array(
                'data' => $model,
                'academicData' => $academicData,
                'profileData' => $profileData,
                'currentUser' => $currentUser,
        )); ?>
      </div><!-- profile -->


    <?php if($viewRolesTab) { ?>
      <div class="tab-pane" id="assignments">
        <?php
            $this->renderPartial('_assignmentsTab', array(
                'roleAssignments' => $roleAssignments,
                'data' => $model,
                'currentUser' => $currentUser,
        )); ?>
      </div><!-- assignments -->
    <?php } ?>

    <?php if($viewTasksToStudent) { ?>
      <div class="tab-pane" id="tasksToStudent">
        <?php
            $this->renderPartial('_tasksToStudent', array(
                'tasksToStudent' => $tasksToStudent,
                'student' => $model,
                'currentUser' => $currentUser,
        )); ?>
      </div><!-- tasksToStudent -->
    <?php } ?>
    </div>
</div>


<!-- shortcode -->
<div class="shortCode">
<span class="text">shortcode</span>
<span class="code">:usr_<?php echo $model->id; ?>:</span>
</div>
