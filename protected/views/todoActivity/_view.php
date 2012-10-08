<div class="activity">

<?php
if($data->log)
    $this->renderPartial('/todoActivity/_view_log', array(
        'data' => $data,
    ));
else
    $this->renderPartial('/todoActivity/_view_update', array(
        'data' => $data,
    ));
?>

</div>
