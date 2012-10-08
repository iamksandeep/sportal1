<?php

class ChangeStateAction extends CAction {

    public function run($id, $state) {
        $model = $this->controller->loadModel($id);
        $model->state = $state;

      // access check
      if(!Yii::app()->user->checkAccess('changeApplicationState', array(
          'student' => $model->student,
          'currentUser' => User::model()->findByPk(Yii::app()->user->id),
        )))
        throw new CHttpException(403, 'You are not authorized to make this request!');

        if($model->save()) {
            Yii::app()->user->setFlash('success', 'Application state has heen changed to <strong>'.$model->state0.'</strong>');
            $activity = $model->log('changed application state to <em>'.$model->state0.'</em>');
            // notify
            if($activity) {
               $model->student->notifyRoles($activity, array('manager', 'counselor'));
               $model->student->notify($activity);
            }
            $this->controller->redirect(array('view', 'id' => $model->id));
        }
        else
            Yii::app()->user->setFlash('error', 'Unable to change tate');

        $this->controller->render('changeState', array('model' => $model));
    }
}
