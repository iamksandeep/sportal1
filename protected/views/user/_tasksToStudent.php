<?php $this->renderPartial('/todo/_tab_summary', array(
  'noStudent' => true,
)); ?>
  <?php $this->renderPartial('/todo/_list', array(
  'state' => 'not-started',
  'data' => $tasksToStudent['not-started'],
  'noStudent' => true,
)); ?>
<?php $this->renderPartial('/todo/_list', array(
  'state' => 'in-progress',
  'data' => $tasksToStudent['in-progress'],
  'noStudent' => true,
)); ?>
<?php $this->renderPartial('/todo/_list', array(
  'state' => 'complete',
  'data' => $tasksToStudent['complete'],
  'noStudent' => true,
)); ?>
