<?php
    $menuItems = array(
        array(
            'label' => 'Profile',
            'url' => array('user/view', 'id' => $usr->id),
            'icon' => 'user',
        ),
        array(
            'label' => 'Applications',
            'url' => array('application/index', 'student_id' => $usr->id),
            'icon' => 'folder-open',
        ),
        array(
            'label' => 'Documents',
            'url' => array('document/index', 'student_id' => $usr->id),
            'icon' => 'file',
        ),
        array(
            'label' => 'Activity',
            'url' => array('activity/index', 'student_id' => $usr->id),
            'icon' => 'comment',
        ),
    );

    $profileMenu = array();
    foreach($menuItems as $mi) {
        if($this->currentProfileMenuItem && $this->currentProfileMenuItem == $mi['label'])
            $mi['active'] = true;
        array_push($profileMenu, $mi);
    }
?>

<?php $this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'list',
    'items'=>$profileMenu,
    'htmlOptions' => array('class' => 'well'),
)); ?>
<br />
