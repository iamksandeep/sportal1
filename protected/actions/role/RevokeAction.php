<?php

class RevokeAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadRole($id);
        $student = $model->student;
        $user = $model->user;
        $role = RoleManager::getRoleName($model->role);

        // access check
        if(!Yii::app()->user->checkAccess('roleManagement', array(
            'student' => $student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Revoke'])) {
            if($student->getRoleManager()->removeRole($user->id, $role)) {
                Yii::app()->user->setFlash('info', '<strong>'.$user->name.'</strong>\'s role as <strong>'.$role.'</strong> has been revoked');
                $activity = $student->log('removed :user_'.$user->id.': from <em>'.$role.'</em> role');

                // notify
                if($activity) {
                    $student->notifyRoles($activity, array($role, 'manager'));
                    $user->notify($activity);
                }

                $this->controller->redirect(array('roles/manage', 'student_id' => $student->id));
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to revoke role');
        }

        $this->controller->render('/role/revoke', array(
            'model' => $model,
        ));
    }
}
