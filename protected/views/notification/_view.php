<div class="_view notification">
<div class="row-fluid">

    <div class="span11">
    <?php
    $this->renderPartial('/activity/_view', array(
        'data' => $data->activity,
        'depth' => 'student',
        'adminControls' => false,
    ));
    ?>
    </div>

    <div class="span1">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'icon' => 'trash',
        'size' => 'mini',
        'htmlOptions' => array(
            'class' => 'pull-right dismiss-button',
            'data-url' => CHtml::normalizeUrl(array('notification/acknowledge', 'id' => $data->id)),
            'title' => 'Dismiss',
        ),
    )); ?>
    </div>

</div>
</div>
