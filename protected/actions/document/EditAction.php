<?php

class EditAction extends CAction {

  public function run($id) {
    $model = $this->controller->loadModel($id);
    $student = $model->student;
    $model->setScenario('edit');

    // access check
    if(!Yii::app()->user->checkAccess('editDocumentDetails', array(
        'student' => $model->student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
        'document' => $model,
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['Document']))
    {
      $model->attributes=$_POST['Document'];

      // application selection
      $proceed = true;
      if($model->isApplicationDocument != 'yes')
          $model->application_id = null;
      if($model->application_id) {
          $application = Application::model()->findByPk($model->application_id);
          if(!$application || $application->student_id !== $student->id || $application->state0 === 'inactive') {
              Yii::app()->user->setFlash('warning', 'The application you have selected is either invalid or disabled.');
              $proceed = false;
          }
      }

      if($proceed && $model->save()) {
          Yii::app()->user->setFlash('success', 'Document <strong>'.$model->title.'</strong> details have been edited.');
          if($model->application)
              $activity = $model->application->log('edited '.$model->type0.' document: :document_'.$model->id.':');
          else
              $activity = $model->student->log('edited '.$model->type0.' document: :document_'.$model->id.':');

          // notify
          if($activity) {
              $model->student->notify($activity);
              if($model->type0 === 'general')
                  $model->student->notifyRoles($activity, array('manager', 'counselor'));
              else
                  $model->student->notifyRoles($activity, array('manager', 'counselor', 'content-writer'));
          }
          $this->controller->redirect(array('document/index','student_id'=>$student->id));
      }

      Yii::app()->user->setFlash('error', 'Unable to edit document details.');
    }

    $this->controller->render('edit',array(
      'model'=>$model,
      'student' => $student,
    ));
  }
}
