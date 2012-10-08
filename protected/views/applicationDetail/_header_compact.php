<?php
    $this->renderPartial('/application/_header_compact', array(
        'data' => $data->application,
)); ?>

<div class="row-fluid">
<i class="icon icon-info-sign"></i>
<strong><?php echo CHtml::encode($data->title); ?></strong> application detail
</div>

<hr />