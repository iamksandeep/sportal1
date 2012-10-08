<h1><?php echo CHtml::encode($conv->subject); ?></h1>

<strong>Members: </strong>
<?php
foreach($conv->members as $mid) {
    $mem = User::model()->findByPk($mid['user_id']);
?>
    <?php
        $this->renderPartial('/user/_gravatar', array(
            'user' => $mem,
            'size' => 14,
        ));
    ?>
    <?php echo CHtml::link(CHtml::encode($mem->name), array('user/view', 'id' => $mem->id)); ?>
&nbsp;&nbsp;&nbsp;
<?php
}
?>

<hr />
