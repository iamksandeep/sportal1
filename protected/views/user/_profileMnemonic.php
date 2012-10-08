<div class="row-fluid profile-stats">
    <!-- msgs and notifications -->
    <div class="span3 section-box">
        <a class="section messages" href="<?php echo CHtml::normalizeUrl(array('message/index')); ?>">
            <h4><i class="icon-envelope icon-white"></i> Messages</h4>
            <div class="data"><strong><?php echo $messageData['unread']; ?></strong> new</div>
        </a>
        <a class="section notifications" href="<?php echo CHtml::normalizeUrl(array('notification/index')); ?>">
            <h4><i class="icon-info-sign icon-white"></i> Notifications</h4>
            <div class="data"><strong><?php echo $notificationData['unseen']; ?></strong> new</div>
        </a>
    </div>

    <!-- msgs and notifications -->
    <div class="span4 section-box">
        <a class="section jobs" href="<?php echo CHtml::normalizeUrl(array('todo/index')); ?>">
            <h4><i class="icon-pencil"></i> Jobs</h4>
            <div class="row-fluid">
                <div class="span4 data not-started">
                <strong><?php echo $jobData['not-started']; ?></strong> not started
                </div>
                <strong><div class="span4 data in-progress">
                <?php echo $jobData['in-progress']; ?><br /></strong> in progress
                </div>
                <div class="span4 data new-activity">
                <strong><?php echo $jobData['new-activity']; ?></strong> new activity
                </div>
            </div>
        </a>
    </div>

    <!-- msgs and notifications -->
    <div class="span5 section-box">
        <div class="section students">
        <h4><i class="icon-user"></i> Students assigned to me</h4>
        <br />
        <table class="table table-striped table-condensed table-bordered">
            <?php foreach($studentData as $role => $count) { ?>
            <tr>
            <th><?php echo $role; ?></th>
            <td><?php echo $count; ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'View students assigned to me',
            'icon' => 'list white',
            'type' => 'inverse',
            'size' => 'small',
            'url' => array('user/assignedToMe'),
            'htmlOptions' => array('class' => 'pull-right'),
        )); ?>
        </div>
    </div>

</div>
