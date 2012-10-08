<?php
    $this->renderPartial('/application/_header_compact', array(
        'data' => $data->application,
)); ?>

<div class="row-fluid">
    <i class="icon icon-tasks"></i>
    <strong><?php echo CHtml::link(CHtml::encode($data->title), array('applicationTask/view', 'id' => $data->id)); ?></strong>
</div>

<hr />
