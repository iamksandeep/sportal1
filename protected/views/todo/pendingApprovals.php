<?php
$this->breadcrumbs=array(
    'Tasks pending your approval',
);?>

<h1>Tasks pending your approval</h1>
<br />

<?php $this->renderPartial('_tab_summary'); ?>

<span class="task-state-header not-started">
    <strong><big><?php echo $pendingApprovals->totalItemCount; ?></big></strong>
    tasks
</span><br />

<?php $this->widget('zii.widgets.CListView', array(
  'dataProvider'=>$pendingApprovals,
  'itemView'=>'/todo/_view',
  'summaryText' => '',
  'emptyText' => '',
)); ?>
