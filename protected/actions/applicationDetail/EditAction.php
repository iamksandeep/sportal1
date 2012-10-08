<?php

class EditAction extends CAction {

  public function run($id) {
    $model = $this->controller->loadModel($id);
    $model->setScenario('edit');

    // access check
    if(!Yii::app()->user->checkAccess('editApplicationDetail', array(
        'student' => $model->application->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['ApplicationDetail']))
    {
      $model->attributes=$_POST['ApplicationDetail'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'Application detail edited.');
        $activity = $model->application->log('edited application detail: <em>'.$model->title.'</em>');
        // notify
        if($activity) {
           $model->application->student->notifyRoles($activity, array('manager', 'counselor'));
           $model->application->student->notify($activity);
        }
        $this->controller->redirect(array('application/view','id'=>$model->application->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to edit application detail.');
    }

    $this->controller->render('edit',array(
      'model'=>$model,
    ));
  }
}
