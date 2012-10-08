<div class="_view application">
<div class="row-fluid">

    <div class="span5">
        <p>
    <i title="<?php echo ucfirst($data->type0); ?> university" class="icon-<?php echo $data->typeIconClass; ?>  application-type-icon"></i>
            <strong><?php echo CHtml::link(CHtml::encode($data->university), array('application/view', 'id' => $data->id)); ?></strong>
        <small><?php echo CHtml::encode($data->course); ?></small>
        </p>
    </div>

    <div class="span2">
        <?php if($data->deadline) { ?>
            <abbr title="Application Deadline: <?php echo CHtml::encode($data->deadline0); ?>">
            <i class="icon-calendar"></i> <?php echo CHtml::encode($data->niceDeadline); ?>
            </abbr>
        <?php } ?>
    </div>

    <?php $progress = $data->progress; ?>
    <div class="span5">
    <div class="row-fluid">
        <div class="span10">
        <?php $this->widget('bootstrap.widgets.BootProgress', array(
            'type'=>Application::getProgressBarClass($progress),
            'percent'=>$progress,
            'striped'=>true,
            'animated'=>($progress !== 100),
        )); ?>
        </div>
        <div class="span2">
        <p class="pull-right"><small><em><?php echo $progress; ?>%</em></small></p>
        </div>
    </div>
    </div>
</div>
</div>
