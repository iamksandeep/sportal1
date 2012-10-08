<?php

class ChangeStateAction extends CAction {

  public function run($id, $state) {
    $model = $this->controller->loadModel($id);
    $model->state=$state;

    // access check
    if(!Yii::app()->user->checkAccess('changeApplicationTaskState', array(
        'student' => $model->application->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if($model->save()) {
        // application state smart update
        $model->application->smartlyChangeState();

        Yii::app()->user->setFlash('success', 'Application task state changed to <strong>'.$model->state0.'</strong>.');
        $activity = $model->log('changed checklist item state to <em>'.$model->state0.'</em>');
        // notify
        if($activity) {
           $model->application->student->notifyRoles($activity, array('manager', 'counselor'));
           $model->application->student->notify($activity);
        }
    }
    else
        Yii::app()->user->setFlash('error', 'Unable to change application task state.');

    $this->controller->redirect(array('view','id'=>$model->id));
  }
}
