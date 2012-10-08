<?php $this->renderPartial('/user/_gravatar', array(
    'user' => $user,
    'size' => 18,
)); ?>

<?php echo CHtml::encode($user->name); ?>
