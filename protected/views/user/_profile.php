<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<!-- program -->
<?php
$category = 'program';
$this->renderPartial('_profile_category', array(
    'data' => $data,
    'category' => $category,
    'dataProvider' => $profileData[$category],
    'currentUser' => $currentUser,
));
?>

<!-- personal -->
<?php
$category = 'personal';
$this->renderPartial('_profile_category', array(
    'data' => $data,
    'category' => $category,
    'dataProvider' => $profileData[$category],
    'currentUser' => $currentUser,
));
?>

<!-- contact -->
<?php
$category = 'contact';
$this->renderPartial('_profile_category', array(
    'data' => $data,
    'category' => $category,
    'dataProvider' => $profileData[$category],
    'currentUser' => $currentUser,
));
?>

<!-- academic -->
<?php
$this->renderPartial('_profile_academic', array(
    'data' => $data,
    'academicData' => $academicData,
    'currentUser' => $currentUser,
));
?>

<!-- exam-scores -->
<?php
$category = 'exam-scores';
$this->renderPartial('_profile_category', array(
    'data' => $data,
    'category' => $category,
    'dataProvider' => $profileData[$category],
    'currentUser' => $currentUser,
));
?>

<!-- additional -->
<?php
$category = 'additional';
$this->renderPartial('_profile_category', array(
    'data' => $data,
    'category' => $category,
    'dataProvider' => $profileData[$category],
    'currentUser' => $currentUser,
));
?>
