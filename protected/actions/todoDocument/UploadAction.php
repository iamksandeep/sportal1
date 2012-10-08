<?php

class UploadAction extends CAction {

    private function assertBasePath($basePath) {
        return (!is_dir($basePath)) ? mkdir($basePath) : true;
    }

    public function run($todo_id) {
        $todo = $this->controller->loadTodo($todo_id);
        $model = new TDDocument('upload');
        $model->todo_id = $todo_id;

        $cuId = Yii::app()->user->id;

        // access check
        if(!($model->todo->assignee_id === $cuId || $model->todo->assigner_id === $cuId) && !Yii::app()->user->checkAccess('uploadJobDocument', array(
            'student' => $model->todo->student,
            'currentUser' => User::model()->findByPk($cuId),
        )))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['TDDocument'])) {
            $model->attributes = $_POST['TDDocument'];
            $model->file=CUploadedFile::getInstance($model,'file');

            // First validate only
            if($model->validate()) {
                // get the filename and extension
                $model->filename = $model->file->name;
                $model->extension = $model->file->extensionName;

                // save info to db
                if($model->save()) {
                    // check / create base path and save file
                    $success = ($this->assertBasePath($model->basePath) && $model->file->saveAs($model->filePath));

                    if($success) {
                        Yii::app()->user->setFlash('success', 'Document <strong>'.$model->title.'</strong> has been uploaded.');
                        $todo->log('uploaded document: <em>'.$model->title.'</em>');
                        $this->controller->redirect(array('todo/view','id'=>$todo->id));
                    }

                    // if file save failes, delete db data
                    $model->delete();
                }
            }

            Yii::app()->user->setFlash('error', 'Unable to upload document.');
        }

        $this->controller->render('upload', array('model' => $model, 'todo' => $todo));
    }
}
