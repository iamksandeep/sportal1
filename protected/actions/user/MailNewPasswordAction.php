<?php

class MailNewPasswordAction extends CAction {

  public function run($id) {
    $model = $this->controller->loadModel($id);

    // access check
    if($model->type0 === 'student') $authCode = 'mailStudentPass';
    elseif($model->type0 === 'mnemonic') $authCode = 'mailMnemonicPass';
    elseif($model->type0 === 'admin') $authCode = 'mailAdminPass';
    elseif($model->type0 === 'superadmin') $authCode = 'mailSuperadminPass';
    else $authCode = 'error';
    if(!Yii::app()->user->checkAccess($authCode, array(
        'student' => $model,
        'user' => $model,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');


    if(isset($_POST['Mail'])) {
      $newPassword = User::randomPassword();

      if($model->changePassword($newPassword)) {
        // mail
        $to = $model->email;
        $subject = "New Password";
        $message = 'Your new login password is:\t\t'.$newPassword;
        $from = "info@sp.mnemonicedu.com";
        // prepare headers
        $headers = "From: " . $from . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        if(mail($to,$subject,$message,$headers)) {
          Yii::app()->user->setFlash('success', 'A new password has been mailed to '.$model->email);
          $this->controller->redirect(array('view', 'id' => $model->id));
        }
        else
          Yii::app()->user->setFlash('error', 'Unable to mail password.');
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to reset password.');
    }

    $this->controller->render('mailNewPassword', array(
      'model' => $model,
    ));
  }
}
