<?php
    if($data->totalItemCount > 0) {
?>
    <br />
    <span class="task-state-header <?php echo $state; ?>">
        <strong><big><?php echo $data->totalItemCount; ?></big></strong>
        <?php echo $state; ?>
    </span><br />

    <?php $this->widget('zii.widgets.CListView', array(
      'dataProvider'=>$data,
      'itemView'=>'/todo/_view',
      'summaryText' => '',
      'emptyText' => '<small><em>No jobs</em></small>',
      'viewData' => array(
            'sentItem' => isset($sentItem) ? $sentItem : false,
            'noStudent' => isset($noStudent) ? $noStudent : false,
        ),
    )); ?>
    <br />

<?php } ?>
