<?php

class RemoveAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

      // access check
      if(!Yii::app()->user->checkAccess('removeApplication', array(
          'student' => $model->student,
          'currentUser' => User::model()->findByPk(Yii::app()->user->id),
        )))
        throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Remove'])) {
            if($model->delete()) {
                Yii::app()->user->setFlash('info', 'Application <strong>'.$model->university.'('.$model->course.')</strong> has been removed.');
                $activity = $model->student->log('removed :application_'.$model->id.':');
                // notify
                if($activity) {
                   $model->student->notifyRoles($activity, RoleManager::getRoles());
                   $model->student->notify($activity);
                }
                $this->controller->redirect(array('application/index', 'student_id' => $model->student->id));
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to remove application');
        }

        $this->controller->render('remove', array('model' => $model));
    }
}
