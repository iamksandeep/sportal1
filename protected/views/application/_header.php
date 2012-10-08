<?php
    $this->renderPartial('/user/_header_compact', array(
        'data' => $data->student,
)); ?>
<div class="row-fluid">
    <div class="span8">
    <h1><?php echo CHtml::encode($data->university); ?> application</h1>
    </div>

    <div class="span4">
    <?php
        $btnArray = array();
        foreach(Application::getStates() as $sId => $sName) {
            if($data->state0 === $sName) continue;
            array_push($btnArray, array(
                'label' => $sName,
                'class' => ($data->state0 === $sName) ? 'active' : null,
                'url' => array('application/changeState', 'id' => $data->id, 'state' => $sId),
            ));
        }
    ?>
    <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
            'type'=>$data->stateButtonClass, // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'buttons'=>array(
                array(
                    'label'=>$data->state0,
                    'size' => 'large',
                    'icon' => $data->stateIconClass.' white',
                    'items'=>$btnArray,
                ),
            ),
            'htmlOptions' => array('class' => 'pull-right'),
    )); ?>
    </div>
</div>
<br />

<?php
if($data->state0 === 'inactive') {
?>
<div class="alert">
  <strong>Note:</strong> This application is currently inactive.
</div>
<?php
}
?>

<table class="table table-striped ">
<thead>
    <tr>
    <th>Course</th>
    <th>Progress</th>
    <th>Deadline</th>
    <th>ID</th>
    </tr>
</thead>
<tbody>
    <tr>
    <td><?php echo CHtml::encode($data->course); ?></td>
    <td>
    <?php $progress = $data->progress; ?>
    <?php $this->widget('bootstrap.widgets.BootProgress', array(
        'type'=>Application::getProgressBarClass($progress),
        'percent'=>$progress,
        'striped'=>true,
        'animated'=>($progress !== 100),
    )); ?>
    <p class="pull-right"><small><em><?php echo $progress; ?>% complete</em></small></p>
    </td>
    <td>
    <?php if($data->deadline) { ?>
        <span class="label label-important">
        <abbr title="Application Deadline: <?php echo CHtml::encode($data->deadline0); ?>">
        <i class="icon-time icon-white"></i> <?php echo CHtml::encode($data->niceDeadline); ?>
        </abbr>
        </span>
    <?php } else { ?>
        <p><small><em>no deadline</em></small></p>
    <?php } ?>
    </td>
    <td><?php echo $data->id; ?></td>
    </tr>
</tbody>
</table>
