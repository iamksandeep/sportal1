<div class="_header_compact user">
<div class="row-fluid">
    <div class="span3"><?php $this->renderPartial('/user/_name', array('user' => $data)); ?></div>
    <div class="span5">
        <?php
        // access check
        if(Yii::app()->user->checkAccess('viewDocuments', array(
            'student' => $data,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
        )))  {
        ?>
        <!-- documents -->
        <div class="span4">
        <?php $this->widget('bootstrap.widgets.BootButton', array(
            'label'=>'Documents',
            'icon' => 'file white',
            //'size' => 'large',
            'type' => 'danger',
            'url' => array('document/index', 'student_id' => $data->id),
        )); ?>
        </div>
        <?php } ?>
    </div>
    <div class="span4">
    <?php $this->widget('bootstrap.widgets.BootButton', array(
        'label'=>'Go back to student profile',
        'icon' => 'arrow-left',
        'url' => array('user/view', 'id' => $data->id),
        'htmlOptions' => array('class' => 'pull-right'),
    )); ?>
    </div>
</div>
</div>
