<?php

class DeleteAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

        // access check
        if(!Yii::app()->user->checkAccess('deleteDocument', array(
            'student' => $model->student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Delete'])) {
            if($model->delete()) {
                if($model->application)
                    $activity = $model->application->log('deleted '.$model->type0.' document: :document_'.$model->id.':');
                else
                    $activity = $model->student->log('deleted '.$model->type0.' document: :document_'.$model->id.':');

                // notify
                if($activity) {
                    $model->student->notify($activity);
                    if($model->type0 === 'general')
                        $model->student->notifyRoles($activity, array('manager', 'counselor'));
                    else
                        $model->student->notifyRoles($activity, array('manager', 'counselor', 'content-writer'));
                }

                if (file_exists($model->filePath) && unlink($model->filePath)) {
                    Yii::app()->user->setFlash('info', 'Document has been deleted.');
                }
                else {
                    Yii::app()->user->setFlash('warning', 'The document record has been deleted, but the file was not found!');
                }

                $this->controller->redirect(array('document/index','student_id'=>$model->student->id));
            }
            else
                Yii::app()->user->setFlash('error', 'Unable to delete document');
        }

        $this->controller->render('delete', array('model' => $model));
    }
}
