<?php

class DisabledUserFilter extends CFilter {

  public $controller;

  public function preFilter() {
    if(isset($_GET['student_id'])) {
      $student = $this->controller->loadUser($_GET['student_id']);
      if($student->disabled) {
        Yii::app()->user->setFlash('error', '<strong>Your request cannot be completed</strong>: This user account is disabled');
        $this->controller->redirect(array('user/view', 'id' => $student->id));
      }
    }
    elseif(isset($_GET['application_id'])) {
      $application = $this->controller->loadApplication($_GET['application_id']);
      if($application->student->disabled) {
        Yii::app()->user->setFlash('error', '<strong>Your request cannot be completed</strong>: This user account is disabled');
        $this->controller->redirect(array('application/view', 'id' => $application->id));
      }
    }
    elseif(isset($_GET['application_task_id'])) {
      $applicationTask = $this->controller->loadApplicationTask($_GET['application_task_id']);
      if($applicationTask->application->student->disabled) {
        Yii::app()->user->setFlash('error', '<strong>Your request cannot be completed</strong>: This user account is disabled');
        $this->controller->redirect(array('applicationTask/view', 'id' => $applicationTask->id));
      }
    }

    return true;
  }
}