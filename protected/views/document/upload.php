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

<h2>Upload a document</h2>

    <br /> <br />
<div class="form">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id'=>'document-uploadApplicationDocument-form',
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row-fluid form-section">
        <div class="span2">Select file to upload</div>
        <div class="span10"><?php echo $form->fileField($model, 'file'); ?><?php echo $form->error($model, 'file'); ?></div>
    </div>

    <div class="row-fluid form-section">
        <div class="span2">Choose a Title</div>
        <div class="span10"><?php echo $form->textField($model,'title'); ?><?php echo $form->error($model,'title'); ?></div>
    </div>

    <div class="row-fluid form-section">
        <div class="span2"><p>About this document <small>(optional)</p></small></div>
        <div class="span10"><?php echo $form->textArea($model, 'description', array('rows' => '5', 'cols' => '15')); ?>
        <?php echo $form->error($model,'description'); ?></div>
    </div>

    <div class="row-fluid form-section">
        <div class="span2"><label>What type of document are you uploading?</label></div>
        <div class="span10">
            <label class="radio">
              <input type="radio" name="Document[type]" id="Document_type_0" value="0" checked>
              <strong>General:</strong>: <em>Marksheets, identity-proofs, etc</em>
            </label>
            <label class="radio">
              <input type="radio" name="Document[type]" id="Document_type_1" value="1">
              <strong>Content:</strong>: <em>Essays, SOPs, LORs, etc.</em>
            </label>
            <?php echo $form->error($model,'type'); ?>
        </div>
    </div>

    <div class="row-fluid form-section">
        <div class="span2"><label>Do you want to upload this document to an application?</label></div>
        <div class="span10">
            <label class="radio">
              <input type="radio" name="Document[isApplicationDocument]" id="Document_isApplicationDocument_no" value="no" checked>
              No
            </label>
            <label class="radio">
              <input type="radio" name="Document[isApplicationDocument]" id="Document_isApplicationDocument_yes" value="yes">
              Yes
            </label>
        </div>
    </div>

    <div id="application-selection" class="hidden">
    <div class="row-fluid form-section">
        <div class="span2"><label>Choose the application where you want to upload this document</label></div>
        <div class="span10">
            <?php echo $form->dropDownList($model, 'application_id', CHtml::listData($student->getApplicationList(), 'id', 'title')); ?>
        <?php echo $form->error($model,'application_id'); ?>

        </div>
    </div>
    </div>

    <div class="row-fluid form-section">
        <div class="span2"></div>
        <div class="span10">
        <?php $this->widget('bootstrap.widgets.BootButton', array('buttonType'=>'submit', 'type' => 'primary', 'icon'=>'file white', 'label'=>'Upload document')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/document_upload_form.js'); ?>
