<?php

class AddAction extends CAction {

  public function run($student_id, $category) {
    $student = $this->controller->loadUser($student_id);
    $model = new ProfileDetail('add');
    $model->category = $category;
    $model->student_id = $student_id;

    $currentUser = User::model()->findByPk(Yii::app()->user->id);

    // access check
    $authCode = 'manageProfile' . ucfirst($model->category0) . 'Details';
    if(!Yii::app()->user->checkAccess($authCode, array(
        'student' => $student,
        'currentUser' => $currentUser,
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['ProfileDetail']))
    {
      $model->attributes=$_POST['ProfileDetail'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'New profile detail has been added.');
        $activity = $model->student->log('added <strong>'.$model->title.'</strong> in <em>'.$model->category0.'</em> details');
        // notify
        if($activity) {
           $student->notifyRoles($activity, RoleManager::getRoles('manager', 'counselor'));
           $student->notify($activity);
        }
        $this->controller->redirect(array('user/view','id'=>$student->id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to add profile detail.');
    }

    $this->controller->render('add',array(
      'model'=>$model,
    ));
  }
}
