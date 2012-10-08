<div class="_view message <?php echo $data->hasBeenReadBy(Yii::app()->user->id) ? 'read' : 'unread'; ?>">
    <div class="header">
    <p>
        <?php
            $this->renderPartial('/user/_gravatar', array(
                'user' => $data->author,
                'size' => 16,
            ));
        ?>
        <strong>
        <?php echo CHtml::link(CHtml::encode($data->author->name), array('user/view', 'id' => $data->author->id)); ?>
        </strong>

        <small>
            <?php $this->renderPartial('/common/_time', array(
                'timestamp' => $data->send_time,
            )); ?>
        </small>
    </p>
    </div>

    <div class="content">
    <p><?php echo $data->parsedContent; ?></p>
    </div>
</div>
