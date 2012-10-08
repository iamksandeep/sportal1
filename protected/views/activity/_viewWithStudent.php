<div class="activity">
    <div class="row-fluid">
    <div class="span2">
    <?php $this->renderPartial('/user/_nameLink', array('user' => $data->student)); ?>
    </div>
    <div class="span10">
    <?php
    if($data->log)
        $this->renderPartial('/activity/_view_log', array(
            'data' => $data,
            'depth' => $depth,
            'adminControls' => isset($adminControls) ? $adminControls : false,
        ));
    else
        $this->renderPartial('/activity/_view_update', array(
            'data' => $data,
            'depth' => $depth,
            'adminControls' => isset($adminControls) ? $adminControls : false,
        ));
    ?>
    </div>
    </div>
</div>
