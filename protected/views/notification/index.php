<?php
$this->breadcrumbs=array(
    'Notifications',
);?>

<h1>Notifications</h1>
<br />

<div class="accordion" id="accordion_n">
<?php
// loop student notification data providers
foreach($notifications as $studentId => $studentNotifications) {
  // if notification count is 0, skip this student
  if($studentNotifications->totalItemCount < 1)
    continue;

  // get this student model
  $student = User::model()->findByPk($studentId);
?>
  <div class="accordion-group">
    <div class="accordion-heading">
    <div  class="accordion-toggle"
        data-toggle="collapse"
        data-parent="#accordion_n"
        href="#sn<?php echo $studentId; ?>">
      <div class="row-fluid">
        <div class="span10">
        <p>
        <?php $this->renderPartial('/user/_nameLink', array('user' => $student)); ?>
        <small><em> has <span class="badge"><?php echo $studentNotifications->totalItemCount; ?></span> updates</em></small>
        </p>
        </div>

        <div class="span2">
        </div>
      </div>
    </div>
    </div>

    <div id="sn<?php echo $studentId; ?>" class="accordion-body collapse <?php if($studentId === Yii::app()->user->id) echo 'in'; ?>">
    <div class="row-fluid notification dismiss_all">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Go to student profile',
        'size' => 'small',
        'url' => array('user/view', 'id' => $student->id),
    )); ?>
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Clear all',
        'icon' => 'trash white',
        'size' => 'small',
        'type' => 'danger',
        'url' => array('notification/acknowledgeAll', 'student_id' => $student->id),
        'htmlOptions' => array('class' => 'pull-right'),
    )); ?>
    </div>
    <?php $this->widget('zii.widgets.CListView', array(
      'dataProvider'=>$studentNotifications,
      'itemView'=>'/notification/_view',
      'summaryText' => '',
      'emptyText' => '<small><em>(no unread notifications)</em></small>',
    )); ?>
    </div>
  </div>
<?php
} // loop
?>
</div><!-- accordion -->


<br /><br />

<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/notification_acknowledge.js'); ?>
