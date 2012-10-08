<?php
if($data->totalItemCount > 0) {
?>
    <br />
    <span class="applicationTask-state-header <?php echo $state; ?>">
        <strong><big><?php echo $data->totalItemCount; ?></big></strong>
        <?php echo $state; ?>
    </span><br />

    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$data,
        'itemView'=>'/applicationTask/_view',
        'summaryText' => '',
        'emptyText' => '<small><em>(no tasks)</em></small>',
        'viewData' => array(
            'currentUser' => $currentUser,
        ),
    )); ?>
<?php
}
?>
