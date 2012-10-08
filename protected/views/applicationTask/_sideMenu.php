<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
$menu = array(
        array(
        'label' => $model->title,
        ),
);

// whether to show menu (incase nothing is authorized)
$showMenu = false;

// edit application task
// --------------------------------------------------------------------------
if(Yii::app()->user->checkAccess('editApplicationTask', array(
  'student' => $model->application->student,
  'currentUser' => $currentUser,
))) {
        array_push($menu, array(
                'label' => 'Edit',
                'icon' => 'edit',
                'url' => array('applicationTask/edit', 'id' => $model->id),
        ));
        $showMenu = true;
}

// remove application task
// --------------------------------------------------------------------------
if(Yii::app()->user->checkAccess('removeApplicationTask', array(
  'student' => $model->application->student,
  'currentUser' => $currentUser,
))) {
        array_push($menu, array(
                'label' => 'Remove',
                'icon' => 'trash',
                'url' => array('applicationTask/remove', 'id' => $model->id),
        ));
        $showMenu = true;
}

// complete the menu
// --------------------------------------------------------------------------
$this->menu = $showMenu ? $menu : null;

?>
