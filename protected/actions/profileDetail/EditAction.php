<?php

class EditAction extends CAction {

  public function run($id) {
    $model = $this->controller->loadModel($id);
    $model->setScenario('edit');

    $currentUser = User::model()->findByPk(Yii::app()->user->id);

    // access check
    $authCode = 'manageProfile' . ucfirst($model->category0) . 'Details';
    if(!Yii::app()->user->checkAccess($authCode, array(
        'student' => $model->student,
        'currentUser' => $currentUser,
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['ProfileDetail']))
    {
      $model->attributes=$_POST['ProfileDetail'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'Detail has been edited.');
        $activity = $model->student->log('edited <strong>'.$model->title.'</strong> in <em>'.$model->category0.'</em> details');
        // notify
        if($activity) {
           $model->student->notifyRoles($activity, RoleManager::getRoles('manager', 'counselor'));
           $model->student->notify($activity);
        }
        $this->controller->redirect(array('user/view','id'=>$model->student->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to edit profile detail.');
    }

    $this->controller->render('edit',array(
      'model'=>$model,
    ));
  }
}
