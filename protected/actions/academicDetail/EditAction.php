<?php

class EditAction extends CAction {

  public function run($id) {
    $model = $this->controller->loadModel($id);
    $model->setScenario('edit');

    // access check
    if(!Yii::app()->user->checkAccess('manageAcademicDetails', array(
        'student' => $model->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['AcademicDetail']))
    {
      $model->attributes=$_POST['AcademicDetail'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'Detail has been edited.');
        $activity = $model->student->log('edited academic detail: <strong>'.$model->level0.'</strong>');
        // notify
        if($activity) {
           $model->student->notifyRoles($activity, RoleManager::getRoles('manager', 'counselor'));
           $model->student->notify($activity);
        }
        $this->controller->redirect(array('user/view','id'=>$model->student->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to edit academic detail.');
    }

    $this->controller->render('edit',array(
      'model'=>$model,
    ));
  }
}
