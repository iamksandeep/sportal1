<div class="_view todo log <?php echo $data->hasBeenReadBy(Yii::app()->user->id) ? 'read' : 'unread'; ?>">
<div class="row-fluid">
    <div class="span10">
        <p>
        <?php $this->renderPartial('/user/_nameLink', array('user' => $data->author)); ?>
        <?php echo $data->parsedComment; ?>
        </p>
    </div>

    <div class="span2">
    <?php $this->renderPartial('/common/_time', array('timestamp' => $data->time)); ?>
    </div>
</div>
</div>
