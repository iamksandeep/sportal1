<?php
if(!isset($noStudent) || !$noStudent)
    $noStudent = (bool)(Yii::app()->user->type=='student');
?>

  <div class="muted row-fluid">
<?php if(!$noStudent) { ?>
    <div class="span3">
        student
    </div>
<?php } ?>

    <div class="span<?php echo $noStudent ? '7' : '5'; ?>">
        title / subject
    </div>

    <div class="span<?php echo $noStudent ? '2' : '1'; ?>">
        deadline
    </div>

    <div class="span3">
        assigned
        <?php if(isset($sentItem) && $sentItem) { ?>
        to
        <?php } else { ?>
        by
        <?php } ?>
    </div>
</div>
