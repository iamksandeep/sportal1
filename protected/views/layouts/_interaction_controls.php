<?php
// get current user object to reduce db calls
if(!isset($currentUser)) $currentUser = User::model()->findByPk(Yii::app()->user->id);
?>

<?php
// if student viewing own profile, show buttons for manager interaction
if($usr->id == $currentUser->id) {
    $msgB = array();
    $taskB = array();

    foreach($usr->getRoleManager()->getAssignmentsInRole('manager') as $role) {
        array_push($msgB, array(
            'label' => $role->user->name,
            'url' => array('message/composeFromStudent', 'to' => $role->user->id, 'student_id' => $role->student_id),
        ));
        array_push($taskB, array(
            'label' => $role->user->name,
            'url' => array('todo/newFromStudent', 'assignee_id' => $role->user->id, 'student_id' => $role->student_id),
        ));
    }

    $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'buttons'=>array(
            array(
                'label' => 'Message',
                'icon' => 'envelope',
                'items' => $msgB,
            ),
        ),
    ));

    echo '<br />';

    $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'buttons'=>array(
            array(
                'label' => 'Task',
                'icon' => 'pencil',
                'items' => $taskB,
            ),
        ),
    ));

}
else {
    $btns = array();

    if(Yii::app()->user->checkAccess('messageStudent', array(
        'student' => $usr,
        'currentUser' => $currentUser,
    )))
        array_push($btns, array(
            'label'=>'Message',
            'icon' => 'envelope',
            'url' => array('message/compose', 'student_id' => $usr->id, 'to' => $usr->id),
        ));

    if(Yii::app()->user->checkAccess('assignJobToStudent', array(
        'student' => $usr,
        'currentUser' => $currentUser,
    )))
        array_push($btns, array(
            'label'=>'Task',
            'icon' => 'pencil',
            'url' => array('todo/new', 'student_id' => $usr->id, 'assignee_id' => $usr->id),
        ));

    $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'size' => 'small',
        'buttons'=>$btns,
    ));

}
?>
<br />
