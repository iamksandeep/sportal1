<?php

class AddAction extends CAction {

  public function run($student_id) {
    $student = $this->controller->loadUser($student_id);
    $model = new Application('add');
    $model->student_id = $student_id;

    // access check
    if(!Yii::app()->user->checkAccess('addApplication', array(
        'student' => $student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['Application']))
    {
      $model->attributes=$_POST['Application'];
      if($model->save()) {
        // prepopulate with application details
        ApplicationDetail::prepopulateApplication($model->id);

        Yii::app()->user->setFlash('success', 'New application has been added.');
        $activity = $model->student->log('added application: :application_'.$model->id.':');
        // notify
        if($activity) {
           $student->notifyRoles($activity, RoleManager::getRoles());
           $student->notify($activity);
        }
        $this->controller->redirect(array('application/index','student_id'=>$student->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to add application.');
    }

    $this->controller->render('add',array(
      'model'=>$model,
    ));
  }
}
