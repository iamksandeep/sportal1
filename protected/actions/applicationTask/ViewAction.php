<?php

class ViewAction extends CAction {

  public function run($id) {
    $model = $this->controller->loadModel($id);

    $currentUser = User::model()->findByPk(Yii::app()->user->id);

    // access control
    if($currentUser->type0 === 'student' && $model->application->student->id !== $currentUser->id)
      throw new CHttpException(403, 'You are not authorized to make this request!');

    // activity
    $activityData = new CActiveDataProvider('Activity', array(
      'criteria' => array(
        'condition' => 'application_task_id = :application_task_id',
        'params' => array(':application_task_id' => $model->id),
        'order' => 'time DESC',
      ),
    ));

    $this->controller->render('view',array(
      'model'=>$model,
      'activityData' => $activityData,
    ));
  }
}
