<?php

class UploadAction extends CAction {

    private function assertBasePath($basePath) {
        return (!is_dir($basePath)) ? mkdir($basePath) : true;
    }

    public function run($student_id) {
        $student = $this->controller->loadUser($student_id);
        $model = new Document('upload');
        $model->student_id = $student_id;

        // access check
        if(!Yii::app()->user->checkAccess('uploadDocument', array(
            'student' => $student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Document'])) {
            $model->attributes = $_POST['Document'];
            $model->file=CUploadedFile::getInstance($model,'file');

            // application selection
            $proceed = true;
            if($model->isApplicationDocument != 'yes')
                $model->application_id = null;
            if($model->application_id) {
                $application = Application::model()->findByPk($model->application_id);
                if(!$application || $application->student_id !== $student_id || $application->state0 === 'inactive') {
                    Yii::app()->user->setFlash('warning', 'The application you have selected is either invalid or disabled.');
                    $proceed = false;
                }
            }

            if($proceed) {
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
                            if($model->application)
                                $activity = $model->application->log('uploaded '.$model->type0.' document: :document_'.$model->id.':');
                            else
                                $activity = $model->student->log('uploaded '.$model->type0.' document: :document_'.$model->id.':');

                            // notify
                            if($activity) {
                                $model->student->notify($activity);
                                if($model->type0 === 'general')
                                    $model->student->notifyRoles($activity, array('manager', 'counselor'));
                                else
                                    $model->student->notifyRoles($activity, array('manager', 'counselor', 'content-writer'));
                            }
                            $this->controller->redirect(array('document/index','student_id'=>$student_id));
                        }

                        // if file save failes, delete db data
                        $model->delete();
                    }
                }
            }

            Yii::app()->user->setFlash('error', 'Unable to upload document.');
        }

        $this->controller->render('upload', array(
            'model' => $model,
            'student' => $student,
        ));
    }
}
