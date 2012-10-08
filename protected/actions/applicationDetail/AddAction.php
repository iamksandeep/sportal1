<?php

class AddAction extends CAction {

  public function run($application_id) {
    $application = $this->controller->loadApplication($application_id);
    $model = new ApplicationDetail('add');
    $model->application_id = $application_id;

    // access check
    if(!Yii::app()->user->checkAccess('addApplicationDetail', array(
        'student' => $application->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['ApplicationDetail']))
    {
      $model->attributes=$_POST['ApplicationDetail'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'Application detail added.');
        $activity = $model->application->log('added new application detail: <em>'.$model->title.'</em>');
        // notify
        if($activity) {
           $application->student->notifyRoles($activity, array('manager', 'counselor'));
           $application->student->notify($activity);
        }
        $this->controller->redirect(array('application/view','id'=>$model->application->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to add application detail.');
    }

    $this->controller->render('add',array(
      'model'=>$model,
    ));
  }
}
