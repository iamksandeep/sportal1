<?php

class ChangePasswordAction extends CAction {

  public function run($id) {
        $this->controller->layout = '//layouts/column2fb';
    $newModel = new User('change-password');
    $model = $this->controller->loadModel($id);

    // access control
    if($model->id !== Yii::app()->user->id)
          throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['User'])) {
      $newModel->attributes = $_POST['User'];

      // verify old password
      if(!$model->checkPassword($newModel->password_old))
        Yii::app()->user->setFlash('error', 'Old password is incorrect. Please try again');
      // validate and change password
      else if($newModel->validate() && $model->changePassword($newModel->password)) {
        Yii::app()->user->setFlash('success', 'Password changed successfully.');
        $this->controller->redirect(array('user/view', 'id' => $model->id));
      }
    }

    // reset any input data for security
    $newModel->password =
    $newModel->password_repeat =
    $newModel->password_old = '';

    $this->controller->render('changePassword', array(
      'model' => $model,
      'newModel' => $newModel,
    ));
  }
}
