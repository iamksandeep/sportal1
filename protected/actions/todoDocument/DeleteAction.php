<?php

class DeleteAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

        $cuId = Yii::app()->user->id;

        // access check
        if(!($model->todo->assignee_id === $cuId || $model->todo->assigner_id === $cuId) && !Yii::app()->user->checkAccess('deleteJobDocument', array(
            'student' => $model->todo->student,
            'currentUser' => User::model()->findByPk($cuId),
        )))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Delete'])) {
            if($model->delete()) {
                $model->todo->log('deleted document: <em>'.$model->title.'</em>');

                if (file_exists($model->filePath) && unlink($model->filePath)) {
                    Yii::app()->user->setFlash('info', 'Document has been deleted.');
                }
                else {
                    Yii::app()->user->setFlash('warning', 'The document record has been deleted, but the file was not found!');
                }

                $this->controller->redirect(array('todo/view','id'=>$model->todo->id));
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to delete document');
        }

        $this->controller->render('delete', array('model' => $model));
    }
}
