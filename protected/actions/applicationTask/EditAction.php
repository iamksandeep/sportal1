<?php

class EditAction extends CAction {

  public function run($id) {
    $model = $this->controller->loadModel($id);
    $model->setScenario('edit');

    // access check
    if(!Yii::app()->user->checkAccess('editApplicationTask', array(
        'student' => $model->application->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['ApplicationTask']))
    {
      $model->attributes=$_POST['ApplicationTask'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'Application task edited.');
        $activity = $model->log('edited checklist item details');
        // notify
        if($activity) {
           $model->application->student->notifyRoles($activity, array('manager', 'counselor'));
           $model->application->student->notify($activity);
        }
        $this->controller->redirect(array('applicationTask/view','id'=>$model->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to edit application task.');
    }

    $this->controller->render('edit',array(
      'model'=>$model,
    ));
  }
}
