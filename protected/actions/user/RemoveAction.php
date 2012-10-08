<?php

class RemoveAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

        // access check
        if(!Yii::app()->user->checkAccess('removeUser', array(
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Remove'])) {
            if($model->delete()) {
                Yii::app()->user->setFlash('info', 'User <strong>'.$model->email.'</strong> has been removed.');
                $this->controller->redirect(array('index'));
            }
        }

        $this->controller->render('remove', array('model' => $model));
    }
}
