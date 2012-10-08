<?php $this->beginContent('//layouts/main'); ?>

<div class="container-fluid">
  <div class="row-fluid">

    <div class="span12">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $content; ?>
    </div>
  </div>
</div>

<?php $this->endContent(); ?>
