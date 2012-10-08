<?php
    $c = Conversation::model()->findByPk($data['convId']);
?>
<div class="conversation _view <?php echo ($data['unreadCount'] > 0) ? 'unread' : 'read';?>">
<div class="row-fluid">

    <!-- msg counts -->
    <div class="span1 msgCount">
    (<?php echo CHtml::encode($data['msgCount']); ?>)
    </div>

    <!-- members  -->
    <div class="span2">
    <?php foreach($c->members as $m) {
    ?>
        <?php
            if($m['user_id'] === Yii::app()->user->id)
                continue;
            $mem = User::model()->findByPk($m['user_id']);
        ?>
        <span title="<?php echo CHtml::encode($mem->name); ?>">
        <?php
            $this->renderPartial('/user/_gravatar', array(
                'user' => $mem,
                'size' => 14,
            ));
        ?>
        <?php if(sizeof($c->members) == 2) echo CHtml::encode($mem->name); ?>
        </span>
    <?php } ?>
    </div>

    <!-- student context -->
<?php if(Yii::app()->user->type!='student') { ?>
    <div class="span2">
        <?php if($c->student) { ?>
        <?php $student = User::model()->findByPk($data['studentId']); ?>
        <?php
            $this->renderPartial('/user/_gravatar', array(
                'user' => $student,
                'size' => 14,
            ));
        ?>
        <?php echo CHtml::encode($student->name) ?>
        <?php } ?>
    </div>
<?php } ?>

    <!-- subject / snippet -->
    <div class="span4">
        <p>
        <strong>
        <?php echo CHtml::link(CHtml::encode($data['convSubject']), array('conversation/view', 'id' => $c->id)); ?>
        </strong>
        &nbsp;&nbsp;
        <em>
        <?php echo substr(strip_tags($data['lastMsgContent']), 0, 20); ?>..
        </em>
        </p>
    </div>

    <!-- time -->
    <div class="span2">
        <small>
            <?php $this->renderPartial('/common/_time', array(
                'timestamp' => $data['lastMsgTime'],
            )); ?>
        </small>
    </div>
</div>
</div>
