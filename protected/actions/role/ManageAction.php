<?php

class ManageAction extends CAction {

    public function run($student_id) {
        $student = $this->controller->loadUser($student_id);

        // access check
        if(!Yii::app()->user->checkAccess('roleManagement', array(
            'student' => $student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        // assignments
        $roleAssignments = RoleAssignment::model()->findAll(array(
            'with' => array('user'),
            'condition' => 't.student_id = :student_id',
            'params' => array(':student_id' => $student->id),
            'order' => 't.role ASC, user.name_first ASC, user.name_last ASC',
        ));

        $this->controller->render('/role/manage', array(
          'roles' => RoleManager::groupRoles($roleAssignments),
          'student' => $student,
        ));
    }
}
