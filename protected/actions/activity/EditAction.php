<?php

class EditAction extends CAction {

  public function run($id) {
    $model = $this->controller->loadModel($id);
    $model->setScenario('edit');

    // access check
    if(!Yii::app()->user->checkAccess('editActivity', array(
        'student' => $model->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['Activity']))
    {
      $model->attributes=$_POST['Activity'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'Activity has been edited.');
        if($model->applicationTask)
          $this->controller->redirect(array('applicationTask/view','id'=>$model->applicationTask->id));
        elseif($model->application)
          $this->controller->redirect(array('application/view','id'=>$model->application->id));
        else
          $this->controller->redirect(array('user/view','id'=>$model->student->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to edit activity.');
    }

    $this->controller->render('edit',array(
      'model'=>$model,
    ));
  }
}
