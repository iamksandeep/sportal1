<?php
$unreadCount = $data->unreadActivityCount;

if(!isset($noStudent) || !$noStudent)
    $noStudent = (bool)(Yii::app()->user->type=='student');
?>

<div class="todo _view <?php if($unreadCount > 0 || $data->isNew) echo 'new-activity'; ?>">
<div class="row-fluid" title="<?php echo substr(strip_tags($data->parsedDescription), 0, 100); ?>..">

<?php if(!$noStudent) { ?>
    <div class="span3">
    <p>
    <?php $this->renderPartial('/user/_name', array('user' => $data->student)); ?>
    </p>
    </div>
<?php } ?>

    <div class="span<?php echo $noStudent ? '7' : '5'; ?>">
        <!-- title -->
        <strong><?php echo CHtml::link(CHtml::encode($data->title), array('todo/view', 'id' => $data->id)); ?></strong>


        <?php
        if($data->isNew) {
        ?>
        <span class="label label-info">new!</span>
        <?php
        }
        ?>
        <?php
        if($unreadCount > 0) {
        ?>
        <span class="label label-warning" title="new activity"><?php echo $unreadCount; ?></span>
        <?php
        }
        ?>
    </div>

    <div class="span<?php echo $noStudent ? '2' : '1'; ?>">
        <?php if($data->deadline) { ?>
        <div>
        <abbr title="Task Deadline: <?php echo CHtml::encode($data->deadline0); ?>">
        <i class="icon-calendar"></i> <?php echo CHtml::encode($data->niceDeadline); ?>
        </abbr>
        </div>
        <?php } ?>
    </div>

    <div class="span3">
    <p>
        <?php if(isset($sentItem) && $sentItem) { ?>
        <?php $this->renderPartial('/user/_name', array('user' => $data->assignee)); ?>
        <?php } else { ?>
        <?php $this->renderPartial('/user/_name', array('user' => $data->assigner)); ?>
        <?php } ?>
        <?php $this->renderPartial('/common/_time', array('timestamp' => $data->initiate_time)); ?>
    </p>
    </div>
</div>
</div>
