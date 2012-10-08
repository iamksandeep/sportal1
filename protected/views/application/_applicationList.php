<?php
if($data->totalItemCount > 0) {
?>
    <br />
    <span class="application-state-header <?php echo $state; ?>">
        <strong><big><?php echo $data->totalItemCount; ?></big></strong>
        <?php echo $state; ?>
    </span><br />

    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$data,
        'itemView'=>(isset($showStudent) && $showStudent) ? '/application/_viewWithStudent' : '/application/_view',
        'summaryText' => '',
        'emptyText' => '<small><em>(no universities)</em></small>',
        'enablePagination' => false,
        'viewData' => array(
            'currentUser' => $currentUser,
            'student' => isset($student) ? $student : null,
        ),
    )); ?>
<?php
}
?>
