<?php

class DownloadAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

        $cuId = Yii::app()->user->id;

        // access check
        if(!($model->todo->assignee_id === $cuId || $model->todo->assigner_id === $cuId) && !Yii::app()->user->checkAccess('downloadJobDocument', array(
            'student' => $model->todo->student,
            'currentUser' => User::model()->findByPk($cuId),
        )))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        $file = $model->filePath;
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.$model->filename);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
        else {
            Yii::app()->user->setFlash('error', '<strong>Unable to fetch document.</strong> The file was not found.');
            $this->controller->redirect(array('todo/view','id'=>$model->todo->id));
        }
    }
}
