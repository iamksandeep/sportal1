<?php $this->renderPartial('/user/_gravatar', array(
    'user' => $user,
    'size' => 18,
)); ?>

<?php echo CHtml::link(CHtml::encode($user->name), array('user/view', 'id' => $user->id)); ?>
