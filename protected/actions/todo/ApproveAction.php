<?php

class ApproveAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

        // access check
        if(!Yii::app()->user->checkAccess('approveJob', array(
            'student' => $model->student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Approve'])) {
            $model->approved = true;
            if($model->save()) {
                Yii::app()->user->setFlash('success', 'Task has been approved.');
                $model->log('approved this task.');
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to approve task');

            $this->controller->redirect(array('todo/view','id'=>$model->id));
        }

        $this->controller->render('approve', array('model' => $model));
    }
}
