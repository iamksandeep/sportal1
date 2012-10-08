<?php

class DeleteAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

        // access check
        if(!Yii::app()->user->checkAccess('deleteActivity', array(
            'student' => $model->student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Delete'])) {
            if($model->delete()) {
                Yii::app()->user->setFlash('info', 'Activity has been deleted.');
                if($model->applicationTask)
                  $this->controller->redirect(array('applicationTask/view','id'=>$model->applicationTask->id));
                elseif($model->application)
                  $this->controller->redirect(array('application/view','id'=>$model->application->id));
                else
                  $this->controller->redirect(array('activity/index','student_id'=>$model->student->id));
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to delete activity');
        }

        $this->controller->render('delete', array('model' => $model));
    }
}
