<?php
    $this->renderPartial('/application/_header_compact', array(
        'data' => $data->application,
)); ?>

<div class="row-fluid">
    <div class="span8"><h1><?php echo CHtml::encode($data->title); ?></h1></div>

    <div class="span4">
    <?php
        $btnArray = array();
        foreach(ApplicationTask::getStates() as $sId => $sName) {
            if($data->state0 === $sName) continue;
            array_push($btnArray, array(
                'label' => $sName,
                'class' => ($data->state0 === $sName) ? 'active' : null,
                'url' => array('applicationTask/changeState', 'id' => $data->id, 'state' => $sId),
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
<hr />

<h3>Description</h3>
<p><?php echo $data->parsedDescription; ?></p>
<hr />
