<div class="_view document general">
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

    <div class="span2">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label' => 'download',
        'icon' => 'download-alt',
        'size' => 'mini',
        'url' => array('todoDocument/download', 'id' => $data->id),
        'htmlOptions' => array('class' => 'pull-right'),
    )); ?>
    </div>
</div>

<div class="action-icons">
<?php echo CHtml::link('<i class="icon-trash"></i>', array('todoDocument/delete', 'id' => $data->id)); ?>
</div>
</div>
