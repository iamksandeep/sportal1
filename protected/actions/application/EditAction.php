<?php

class EditAction extends CAction {

  public function run($id) {
    $model = $this->controller->loadModel($id);
    $model->setScenario('update');

      // access check
      if(!Yii::app()->user->checkAccess('editApplication', array(
          'student' => $model->student,
          'currentUser' => User::model()->findByPk(Yii::app()->user->id),
        )))
        throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['Application']))
    {
      $model->attributes=$_POST['Application'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'Application has been updated.');
        $activity = $model->log('edited application details');
        // notify
        if($activity) {
           $model->student->notifyRoles($activity, array('manager', 'counselor'));
           $model->student->notify($activity);
        }
        $this->controller->redirect(array('view','id'=>$model->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to update application.');
    }

    $this->controller->render('edit',array(
      'model'=>$model,
    ));
  }
}
