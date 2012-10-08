<?php

class AssignAction extends CAction {

    public function run() {
        if(isset($_POST['Assign'])) {
            $student = $this->controller->loadUser($_POST['Assign']['student_id']);
            $user = $this->controller->loadUser($_POST['Assign']['user_id']);
            $role = RoleManager::getRoleName($_POST['Assign']['role']);

            // access check
            if(!Yii::app()->user->checkAccess('roleManagement', array(
                'student' => $student,
                'currentUser' => User::model()->findByPk(Yii::app()->user->id),
              )))
              throw new CHttpException(403, 'You are not authorized to make this request!');

            if($student->getRoleManager()->assignRole($user->id, $role)) {
                Yii::app()->user->setFlash('success', '<strong>'.$user->name.'</strong> assigned to role: <strong>'.$role.'</strong>');
                $activity = $student->log('assigned :user_'.$user->id.': as <em>'.$role.'</em>');

                // notify
                if($activity) $student->notifyRoles($activity, array($role, 'manager'));
            }

            $this->controller->redirect(array('/roles/manage', 'student_id' => $student->id));
        }

        throw new CHttpException(500, 'Bad request');
    }
}
