<?php

class DeleteAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

    $currentUser = User::model()->findByPk(Yii::app()->user->id);

    // access check
    $authCode = 'manageProfile' . ucfirst($model->category0) . 'Details';
    if(!Yii::app()->user->checkAccess($authCode, array(
        'student' => $model->student,
        'currentUser' => $currentUser,
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Remove'])) {
            if($model->delete()) {
                Yii::app()->user->setFlash('info', 'Profile detail <strong>'.$model->title.'</strong> has been deleted.');
                $activity = $model->student->log('deleted <strong>'.$model->title.'</strong> in <em>'.$model->category0.'</em> details');
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
