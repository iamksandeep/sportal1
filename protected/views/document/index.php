<?php
    // Get current user model
    if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
    // show profile of student
    $this->showProfileFor = $student;
    // current menu item
    $this->currentProfileMenuItem = 'Documents';
?>

<?php
    // check delete access
    $deleteAccess = Yii::app()->user->checkAccess('deleteDocument', array(
        'student' => $student,
        'currentUser' => $currentUser,
    ));
?>

<div class="row-fluid">
    <div class="span8"><h1>Documents</h1></div>

    <?php
    // access check
    if(Yii::app()->user->checkAccess('uploadDocument', array(
        'student' => $student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
    )))  {
    ?>
    <!-- upload button -->
    <div class="span4">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Upload a document',
        'icon' => 'hdd white',
        //'size' => 'large',
        'type' => 'danger',
        'url' => array('document/upload', 'student_id' => $student->id),
        'htmlOptions' => array('class' => 'pull-right'),
    )); ?>
    </div>
    <?php } ?>
</div>
<br />

<?php $this->renderPartial('_searchForm', array(
      's' => $s,
)); ?>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$globalDocs,
    'itemView'=>'/document/_view',
    'summaryText' => '<strong>{count}</strong> files',
    'emptyText' => sizeof($applicationDocs) > 0 ? '' : '<small><em>(no documents)</em></small>',
    'viewData' => array(
        'showApplication' => true,
        'currentUser' => $currentUser,
        'student' => $student,
        'deleteAccess' => $deleteAccess,
    ),
)); ?>

<br />

<?php foreach($applicationDocs as $ad) { ?>
    <br />
    <strong><?php echo Application::getLinkFor($ad['application']->id); ?></strong>

    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$ad['data'],
        'itemView'=>'/document/_view',
        'summaryText' => '<strong>{count}</strong> files',
        'emptyText' => '<small><em>(no documents)</em></small>',
        'viewData' => array(
            'currentUser' => $currentUser,
            'student' => $student,
            'deleteAccess' => $deleteAccess,
        ),
    )); ?>

<?php } ?>
