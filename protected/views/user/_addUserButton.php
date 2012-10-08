<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>
<?php
    $btnArray = array();

    foreach(User::getTypes() as $typeId => $typeName) {
        $authCode = 'add' . ucfirst($typeName) . 'Acc';

        if(Yii::app()->user->checkAccess($authCode, array(
            'currentUser' => $currentUser,
        )))
            array_push($btnArray, array(
                'label'=>$typeName,
                'url'=>array('user/add', 'type' => $typeId),
            ));
    }

    if($btnArray) {
        $this->widget('bootstrap.widgets.BootButtonGroup', array(
            'type'=>'primary',
            'buttons'=>array(
                array(
                    'label'=>'Add new user',
                    'type' => 'inverse',
                    'size' => 'large',
                    'icon' => 'user white',
                    'items'=>$btnArray,
                ),
            ),
            'htmlOptions' => array('class' => 'pull-right'),
        ));
        echo "<br /><br />";
    }
?>
