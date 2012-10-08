<?php

class AddAction extends CAction {

  public function run($student_id) {
    $student = $this->controller->loadUser($student_id);
    $model = new AcademicDetail('add');
    $model->student_id = $student_id;

    // access check
    if(!Yii::app()->user->checkAccess('manageAcademicDetails', array(
        'student' => $student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['AcademicDetail']))
    {
      $model->attributes=$_POST['AcademicDetail'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'New academic detail has been added.');
        $activity = $model->student->log('added academic detail: <strong>'.$model->level0.'</strong>');
        // notify
        if($activity) {
           $student->notifyRoles($activity, RoleManager::getRoles('manager', 'counselor'));
           $student->notify($activity);
        }
        $this->controller->redirect(array('user/view','id'=>$student->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to add academic detail.');
    }

    $this->controller->render('add',array(
      'model'=>$model,
    ));
  }
}
