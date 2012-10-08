<div class="_view application" title="<?php echo substr(strip_tags($data->parsedDescription), 0, 140); ?>..">
<p><strong>
    <?php echo CHtml::link(CHtml::encode($data->title), array('applicationTask/view', 'id' => $data->id)); ?>
</strong></p>
</div>
