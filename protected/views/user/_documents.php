<h2>Student documents</h2>
<br />

<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>
<?php
// delete access check
$deleteAccess = Yii::app()->user->checkAccess('deleteDocument', array(
    'student' => $student,
    'currentUser' => $currentUser,
));
?>

<!-- tabs -->
<ul class="nav nav-tabs" id="docTabs">
  <li class="active">
    <a href="#general" data-toggle="tab">
    <h4>General</h4>
    </a>
  </li>
  <li>
    <a href="#content" data-toggle="tab">
    <h4>Content</h4>
    </a>
  </li>
</ul>

<!-- tab content -->
<div class="tab-content">
  <div class="tab-pane active" id="general">

<?php
// access check
$uploadAccess = Yii::app()->user->checkAccess('uploadStudentDocument', array(
    'student' => $student,
    'currentUser' => $currentUser,
));
?>
<?php if($uploadAccess) { ?>
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Upload general document',
        'icon' => 'file',
        'url' => array(
                    'document/uploadStudentDocument',
                    'student_id' => $student->id,
                    'type' => Document::getTypeId('general'),
                 ),
    )); ?>
<?php } ?>

    <?php $this->widget('zii.widgets.CListView', array(
      'dataProvider'=>$generalDocumentData,
      'itemView'=>'/document/_view',
      'summaryText' => '<strong>{count}</strong> documents',
      'emptyText' => '<small><em>(no documents)</em></small>',
      'viewData' => array(
        'deleteAccess' => $deleteAccess,
        'currentUser' => $currentUser,
      ),
    )); ?>


  </div><!-- general -->

  <div class="tab-pane" id="content">

<?php if($uploadAccess) { ?>
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Upload content document',
        'icon' => 'file',
        'url' => array(
                    'document/uploadStudentDocument',
                    'student_id' => $student->id,
                    'type' => Document::getTypeId('content'),
                 ),
    )); ?>
<?php } ?>

    <?php $this->widget('zii.widgets.CListView', array(
      'dataProvider'=>$contentDocumentData,
      'itemView'=>'/document/_view',
      'summaryText' => '<strong>{count}</strong> documents',
      'emptyText' => '<small><em>(no documents)</em></small>',
      'viewData' => array(
        'deleteAccess' => $deleteAccess,
        'currentUser' => $currentUser,
      ),
    )); ?>

  </div><!-- content -->
</div>
