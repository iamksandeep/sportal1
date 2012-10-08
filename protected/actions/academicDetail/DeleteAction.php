<?php

class DeleteAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

    // access check
    if(!Yii::app()->user->checkAccess('manageAcademicDetails', array(
        'student' => $model->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Remove'])) {
            if($model->delete()) {
                Yii::app()->user->setFlash('info', 'Academic detail <strong>'.$model->level0.'</strong> has been deleted.');
                $activity = $model->student->log('deleted academic detail: <strong>'.$model->level0.'</strong>');
                // notify
                if($activity) {
                   $model->student->notifyRoles($activity, RoleManager::getRoles('manager', 'counselor'));
                   $model->student->notify($activity);
                }
                $this->controller->redirect(array('user/view', 'id' => $model->student->id));
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to delete detail');
        }

        $this->controller->render('delete', array('model' => $model));
    }
}
