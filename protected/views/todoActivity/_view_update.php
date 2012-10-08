<div class="_view todo update <?php echo $data->hasBeenReadBy(Yii::app()->user->id) ? 'read' : 'unread'; ?>">
<div class="row-fluid">

    <div class="span10">
        <blockquote>
            <p><?php echo $data->parsedComment; ?></p>

            <br />

            <small>
            <?php $this->renderPartial('/user/_nameLink', array('user' => $data->author)); ?>
            </small>
        </blockquote>
    </div>

    <div class="span2">
    <?php $this->renderPartial('/common/_time', array('timestamp' => $data->time)); ?>
    </div>
</div>
</div>
