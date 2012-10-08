<?php

class EnableAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

        if(!($model->type0 === 'student' && Yii::app()->user->checkAccess('disableStudent', array(
                'currentUser' => User::model()->findByPk(Yii::app()->user->id),
                'student' => $model,
        ))))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Enable'])) {
            $model->disabled = false;
            if($model->save()) {
                Yii::app()->user->setFlash('success', 'User <strong>'.$model->email.'</strong> has been enabled.');
                $model->log('enabled user account');
                $this->controller->redirect(array('view', 'id' => $model->id));
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to enable account.');
        }

        $this->controller->render('enable', array('model' => $model));
    }
}
