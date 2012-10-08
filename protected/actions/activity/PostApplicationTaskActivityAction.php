<?php

class PostApplicationTaskActivityAction extends CAction {

  public function run($application_task_id) {
    $applicationTask = $this->controller->loadApplicationTask($application_task_id);
    $model = new Activity('add');
    $model->application_task_id = $application_task_id;
    $model->application_id = $applicationTask->application_id;
    $model->student_id = $applicationTask->application->student_id;

    // access check
    if(!Yii::app()->user->checkAccess('postApplicationTaskActivity', array(
        'student' => $applicationTask->application->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['Activity']))
    {
      $model->attributes=$_POST['Activity'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'Activity posted');
        // notify
         $applicationTask->application->student->notifyRoles($model, array('manager', 'counselor'));
         $applicationTask->application->student->notify($model);

        $this->controller->redirect(array('applicationTask/view','id'=>$model->application_task_id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to post activity.');
    }

    $this->controller->render('postApplicationTaskActivity',array(
      'model'=>$model,
    ));
  }
}
