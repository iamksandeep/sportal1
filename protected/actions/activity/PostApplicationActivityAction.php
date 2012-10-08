<?php

class PostApplicationActivityAction extends CAction {

  public function run($application_id) {
    $application = $this->controller->loadApplication($application_id);
    $model = new Activity('add');
    $model->application_id = $application_id;
    $model->student_id = $application->student_id;

    // access check
    if(!Yii::app()->user->checkAccess('postApplicationActivity', array(
        'student' => $application->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['Activity']))
    {
      $model->attributes=$_POST['Activity'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'Activity posted');
        // notify
         $application->student->notifyRoles($model, array('manager', 'counselor'));
         $application->student->notify($model);

        $this->controller->redirect(array('application/view','id'=>$model->application_id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to post activity.');
    }

    $this->controller->render('postApplicationActivity',array(
      'model'=>$model,
    ));
  }
}
