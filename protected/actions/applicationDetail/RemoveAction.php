<?php

class RemoveAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

        // access check
        if(!Yii::app()->user->checkAccess('removeApplicationDetail', array(
            'student' => $model->application->student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Remove'])) {
            if($model->delete()) {
                Yii::app()->user->setFlash('info', 'Application detail <strong>'.$model->title.'</strong> has been removed.');
                $activity = $model->application->log('removed application detail: <em>'.$model->title.'</em>');
                // notify
                if($activity) {
                   $model->application->student->notifyRoles($activity, array('manager', 'counselor'));
                   $model->application->student->notify($activity);
                }
                $this->controller->redirect(array('application/view', 'id' => $model->application->id));
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to remove application detail');
        }

        $this->controller->render('remove', array('model' => $model));
    }
}
