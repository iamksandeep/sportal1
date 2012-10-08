<div>
<?php
if($data->applicationTask) {
    if($depth === 'application') {
        echo CHtml::link('<i class="icon-'.ApplicationTask::ICON_CLASS.'"></i> '.CHtml::encode($data->applicationTask->title),
                        array('applicationTask/view', 'id' => $data->applicationTask->id));
    }
    elseif($depth === 'student') {
        echo CHtml::link('<i class="icon-'.Application::ICON_CLASS.'"></i> '.CHtml::encode($data->application->title),
                        array('application/view', 'id' => $data->application->id));
        echo '&nbsp;&nbsp;';
        echo CHtml::link('<i class="icon-'.ApplicationTask::ICON_CLASS.'"></i> '.CHtml::encode($data->applicationTask->title),
                        array('applicationTask/view', 'id' => $data->applicationTask->id));
    }
}
elseif($data->application) {
    if($depth === 'student') {
        echo CHtml::link('<i class="icon-folder-open"></i> '.CHtml::encode($data->application->title),
                        array('application/view', 'id' => $data->application->id));
    }
}
?>
</div>
