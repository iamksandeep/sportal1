<?php

class PostStudentActivityAction extends CAction {

  public function run($student_id) {
    $student = $this->controller->loadUser($student_id);
    $model = new Activity('add');
    $model->student_id = $student_id;

    // access check
    if(!Yii::app()->user->checkAccess('postStudentActivity', array(
        'student' => $student,
        'currentUser' => User::model()->findByPk(Yii::app()->user->id),
      )))
      throw new CHttpException(403, 'You are not authorized to make this request!');

    if(isset($_POST['Activity']))
    {
      $model->attributes=$_POST['Activity'];
      if($model->save()) {
        Yii::app()->user->setFlash('success', 'Activity posted');
        // notify
         $student->notifyRoles($model, array('manager', 'counselor'));
         $student->notify($model);

        $this->controller->redirect(array('activity/index','student_id'=>$model->student_id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to post activity.');
    }

    $this->controller->render('postStudentActivity',array(
      'model'=>$model,
    ));
  }
}
