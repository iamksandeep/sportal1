<?php

class DownloadAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);

        // access check
        // content doc
        if($model->type0 === 'content' && !Yii::app()->user->checkAccess('downloadContentDocument', array(
            'student' => $model->student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
            'document' => $model,
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        // general doc
        if($model->type0 === 'general' && !Yii::app()->user->checkAccess('downloadGeneralDocument', array(
            'student' => $model->student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
            'document' => $model,
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
            if($model->application)
              $this->controller->redirect(array('application/view','id'=>$model->application->id));
            else
              $this->controller->redirect(array('user/view','id'=>$model->student->id));
        }
    }
}
