<?php

class AddAction extends CAction {

    public function run($type) {
        $model = new User('add');
        $model->type = $type;

        // access check
        $authCode = 'add' . ucfirst($model->type0) . 'Acc';
        if(!Yii::app()->user->checkAccess($authCode, array(
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
        )))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if($model->save()) {
                // prepopulate profile
                if($model->type0 === 'student')
                    ProfileDetail::prepopulateUser($model->id);

                Yii::app()->user->setFlash('success', 'User <strong>'.$model->email.'</strong> has been added.');
                $this->controller->redirect(array('view', 'id' => $model->id));
            }
        }

        $model->password = $model->password_repeat = '';

        $this->controller->render('add', array('model' => $model));
    }
}
