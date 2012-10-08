<?php $this->beginContent('//layouts/main'); ?>

<div class="container-fluid">
  <div class="row-fluid">

    <div class="span10">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php echo $content; ?>
    </div>

    <div class="span2">
    <?php
    if(isset($this->menu) && sizeof($this->menu) > 0) {
        $this->widget('bootstrap.widgets.BootMenu', array(
            'type' => 'list',
            'stacked' => true,
            'items'=>$this->menu,
            'htmlOptions' => array('class' => 'well'),
        ));
    }
    ?>
    </div>
  </div>
</div>

<?php $this->endContent(); ?>