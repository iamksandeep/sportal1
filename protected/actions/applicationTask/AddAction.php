<?php

class AddAction extends CAction {

  public function run($application_id) {
    $application = $this->controller->loadApplication($application_id);
    $model = new ApplicationTask('add');
    $model->application_id = $application_id;

    // access check
    if(!Yii::app()->user->checkAccess('addApplicationTask', array(
        'student' => $application->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['ApplicationTask']))
    {
      $model->attributes=$_POST['ApplicationTask'];
      if($model->save()) {
        // application state smart update
        $model->application->smartlyChangeState();

        Yii::app()->user->setFlash('success', 'Application task added.');
        $activity = $model->application->log('added checklist item: :applicationTask_'.$model->id.':');
        // notify
        if($activity) {
           $application->student->notifyRoles($activity, array('manager', 'counselor'));
           $application->student->notify($activity);
        }
        $this->controller->redirect(array('application/view','id'=>$application->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to add application task.');
    }

    $this->controller->render('add',array(
      'model'=>$model,
    ));
  }
}
