<div class="_view user">
<div class="row-fluid">
    <div class="span4">
    <?php echo $data->getGravatarAndNameLink(18); ?>
    </div>

    <div class="span4">
    <p><?php echo $data->email; ?></p>
    </div>

    <div class="span3">
    <?php
        if($data->type0 === 'mnemonic')
            echo '<span class="label label-info">mnemonic</span>';
        elseif($data->type0 === 'admin')
            echo '<span class="label label-important">admin</span>';
        elseif($data->type0 === 'superadmin')
            echo '<span class="label label-inverse">admin</span>';
    ?>
    </div>

    <div class="span1">
    <p title="User ID"><small><?php echo $data->id; ?></small></p>
    </div>

</div>
</div>
