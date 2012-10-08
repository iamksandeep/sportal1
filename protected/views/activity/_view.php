<div class="activity">

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
