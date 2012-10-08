<?php

class ResetPasswordAction extends CAction {

  public function run($id) {
        $this->controller->layout = '//layouts/column2fb';
    $model = $this->controller->loadModel($id);

    // access check
    if($model->type0 === 'student') $authCode = 'resetStudentPass';
    elseif($model->type0 === 'mnemonic') $authCode = 'resetMnemonicPass';
    elseif($model->type0 === 'admin') $authCode = 'resetAdminPass';
    elseif($model->type0 === 'superadmin') $authCode = 'resetSuperadminPass';
    else $authCode = 'error';
    if(!Yii::app()->user->checkAccess($authCode, array(
        'student' => $model,
        'user' => $model,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['Reset'])) {
      $newPassword = User::generateRandomPassword();

      if($model->changePassword($newPassword)) {
        Yii::app()->user->setFlash('success', 'Password has been reset to <strong>'.$newPassword.'</strong>');
        $this->controller->redirect(array('view', 'id' => $model->id));
      }
      else {
        Yii::app()->user->setFlash('error', 'Unable to reset password.');
      }
    }

    $this->controller->render('resetPassword', array(
      'model' => $model,
    ));
  }
}
