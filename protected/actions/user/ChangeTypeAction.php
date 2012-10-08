<?php

class ChangeTypeAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);
        $model->setScenario('change-type');

        // access check
        if($model->type0 === 'admin') $authCode = 'changeAdminAccType';
        elseif($model->type0 === 'superadmin') $authCode = 'changeSuperadminAccType';
        else $authCode = 'changeAccType';
        if(!Yii::app()->user->checkAccess($authCode, array(
            'student' => $model,
            'user' => $model,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if($model->save()) {
                Yii::app()->user->setFlash('success', 'User <strong>'.$model->email.'</strong> type has heen changed to <strong>'.$model->type0.'</strong>');
                $this->controller->redirect(array('view', 'id' => $model->id));
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to change type');
        }

        $this->controller->render('changeType', array('model' => $model));
    }
}
