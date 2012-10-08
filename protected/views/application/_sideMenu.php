<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
$menu = array(
        array(
        'label' => 'Application',
        ),
);

// whether to show menu (incase nothing is authorized)
$showMenu = false;

// edit application
// --------------------------------------------------------------------------
if(Yii::app()->user->checkAccess('editApplication', array(
  'student' => $model->student,
  'currentUser' => $currentUser,
))) {
        array_push($menu, array(
                'label' => 'Edit',
                'icon' => 'edit',
                'url' => array('application/edit', 'id' => $model->id),
        ));
        $showMenu = true;
}

// remove application
// --------------------------------------------------------------------------
if(Yii::app()->user->checkAccess('removeApplication', array(
  'student' => $model->student,
  'currentUser' => $currentUser,
))) {
        array_push($menu, array(
                'label' => 'Remove',
                'icon' => 'trash',
                'url' => array('application/remove', 'id' => $model->id),
        ));
        $showMenu = true;
}

// complete the menu
// --------------------------------------------------------------------------
$this->menu = $showMenu ? $menu : null;

?>
