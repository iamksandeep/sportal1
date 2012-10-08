<?php

class EditAction extends CAction {

  public function run($application_id) {
    $application = $this->controller->loadApplication($application_id);

    // if already exist - edit those
    if($application->credentials)
      $model = $application->credentials;
    // else create new detail
    else {
      $model = new UniversityCredential;
      $model->application_id = $application_id;
    }

    // access check
    if(!Yii::app()->user->checkAccess('editUniversityCredentials', array(
        'student' => $application->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['UniversityCredential']))
    {
      $model->attributes=$_POST['UniversityCredential'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'University Login details have been updated.');
        $activity = $model->application->log('updated university login details');
        // notify
        if($activity) {
           $application->student->notifyRoles($activity, array('manager', 'counselor'));
        }
        $this->controller->redirect(array('application/view','id'=>$model->application->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to update login detail.');
    }

    $this->controller->render('edit',array(
      'model'=>$model,
    ));
  }
}
