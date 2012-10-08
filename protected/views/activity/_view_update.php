<div class="update">
<div class="row-fluid">

    <div class="span10">
        <blockquote>
            <p><?php echo $data->parsedComment; ?></p>

            <br />

            <small>
            <?php $this->renderPartial('/user/_nameLink', array('user' => $data->author)); ?>

            <?php
            if($data->applicationTask) {
                if($depth === 'application') {
                    echo 'for '.CHtml::link('<i class="icon-'.ApplicationTask::ICON_CLASS.'"></i> '.CHtml::encode($data->applicationTask->title),
                                    array('applicationTask/view', 'id' => $data->applicationTask->id));
                }
                elseif($depth === 'student') {
                    echo 'for '.CHtml::link('<i class="icon-'.ApplicationTask::ICON_CLASS.'"></i> '.CHtml::encode($data->applicationTask->title),
                                    array('applicationTask/view', 'id' => $data->applicationTask->id));
                    echo ' in '.CHtml::link('<i class="icon-'.Application::ICON_CLASS.'"></i> '.CHtml::encode($data->application->university),
                                    array('application/view', 'id' => $data->application->id));
                }
            }
            elseif($data->application) {
                if($depth === 'student') {
                    echo 'in '.CHtml::link('<i class="icon-folder-open"></i> '.CHtml::encode($data->application->university),
                                    array('application/view', 'id' => $data->application->id));
                }
            }
            ?>
            </small>
        </blockquote>
    </div>

    <div class="span2">
    <?php $this->renderPartial('/common/_time', array('timestamp' => $data->time)); ?>
    </div>

    <?php if($adminControls) { ?>
    <div class="action-icons">
    <?php echo CHtml::link('<i class="icon-edit"></i>', array('activity/edit', 'id' => $data->id)); ?>
    <?php echo CHtml::link('<i class="icon-trash"></i>', array('activity/delete', 'id' => $data->id)); ?>
    </div>
    <?php } ?>
</div>
</div>
