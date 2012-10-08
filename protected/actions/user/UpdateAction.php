<?php

class UpdateAction extends CAction {

    public function run($id) {
        $this->controller->layout = '//layouts/column2fb';
        $model = $this->controller->loadModel($id);
        $model->setScenario('update');

        // access check
        if($model->type0 === 'student') $authCode = 'editStudentAcc';
        elseif($model->type0 === 'mnemonic') $authCode = 'editMnemonicAcc';
        elseif($model->type0 === 'admin') $authCode = 'editAdminAcc';
        elseif($model->type0 === 'superadmin') $authCode = 'editSuperadminAcc';
        else $authCode = 'error';
        if(!Yii::app()->user->checkAccess($authCode, array(
            'student' => $model,
            'user' => $model,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if($model->save()) {
                Yii::app()->user->setFlash('success', 'User <strong>'.$model->email.'</strong> has been updated.');
                $model->log('updated account details');
                $this->controller->redirect(array('view', 'id' => $model->id));
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to update user details');
        }

        $this->controller->render('update', array('model' => $model));
    }
}
