<?php
    // Config
    // Show application information about this document?
    if(!isset($showApplication)) $showApplication = false;


    // edit access
    $editAccess = Yii::app()->user->checkAccess('editDocumentDetails', array(
        'student' => $data->student,
        'document' => $data,
        'currentUser' => $currentUser,
    ));

    // Check download access for this document
    if($data->type0 === 'content')
        $downloadAccess = Yii::app()->user->checkAccess('downloadContentDocument', array(
            'student' => $data->student,
            'document' => $data,
            'currentUser' => $currentUser,
    ));
    else
        $downloadAccess = Yii::app()->user->checkAccess('downloadGeneralDocument', array(
            'student' => $data->student,
            'document' => $data,
            'currentUser' => $currentUser,
    ));

    // download access
    // check download access
    if($data->type0 === 'content')
        $downloadAccess = Yii::app()->user->checkAccess('downloadContentDocument', array(
            'student' => $student,
            'document' => $data,
            'currentUser' => $currentUser,
        ));
    else
        $downloadAccess = Yii::app()->user->checkAccess('downloadGeneralDocument', array(
            'student' => $student,
            'document' => $data,
            'currentUser' => $currentUser,
        ));
?>

<div class="_view document <?php echo $data->type0; ?>" title="<?php echo CHtml::encode($data->description); ?>">
<div class="row-fluid">
    <p class="span4">
        <!-- name -->
        <strong><?php echo CHtml::encode($data->title); ?></strong>
        <!-- extension -->
        <small><em>.<?php echo CHtml::encode($data->extension); ?></em></small>
    </p>

    <div class="span6">
        <p class="muted pull-right">
        <?php $this->renderPartial('/user/_nameLink', array('user' => $data->uploader)); ?>
        uploaded
        <?php $this->renderPartial('/common/_time', array('timestamp' => $data->upload_time)); ?>
        </p>
    </div>

    <?php if($downloadAccess) { ?>
    <div class="span2">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label' => 'download',
        'icon' => 'download-alt',
        'size' => 'mini',
        'url' => array('document/download', 'id' => $data->id),
        'htmlOptions' => array('class' => 'pull-right'),
    )); ?>
    </div>
    <?php } ?>
</div>

<div class="action-icons">
<?php if($editAccess) { ?>
<?php echo CHtml::link('<i class="icon-edit"></i>', array('document/edit', 'id' => $data->id)); ?>
<?php } ?>
<?php if($deleteAccess) { ?>
<?php echo CHtml::link('<i class="icon-trash"></i>', array('document/delete', 'id' => $data->id)); ?>
<?php } ?>
</div>
</div>
