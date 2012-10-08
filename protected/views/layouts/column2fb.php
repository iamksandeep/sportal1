<?php $this->beginContent('//layouts/main'); ?>

<div class="container-fluid">
  <div class="row-fluid">

    <div class="span2">

        <?php if($this->showProfileFor) { ?>
        <div class="user-profile">
            <?php
                    $usr = $this->showProfileFor;
                    echo $usr->getGravatar();
            ?>
            <br /><br />
            <h3><?php echo $usr->name; ?></h3>
            <br />

            <?php include dirname(__FILE__).'/_profile_menu.php'; ?>
            <?php include dirname(__FILE__).'/_interaction_controls.php'; ?>
        </div>
        <?php } ?>
    </div>


    <div class="span10 main-content-wrapper">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php echo $content; ?>
    </div>
  </div>
</div>

<?php $this->endContent(); ?>
