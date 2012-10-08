<?php

class InactiveApplicationFilter extends CFilter {

  public $controller;

  public function preFilter() {
    if(isset($_GET['id'])) {
      $applicationTask = $this->controller->loadModel($_GET['id']);
      if($applicationTask->application->state0 === 'inactive') {
        Yii::app()->user->setFlash('error', '<strong>Your request cannot be completed</strong>: This application is inactive');
        $this->controller->redirect(array('applicationTask/view', 'id' => $applicationTask->id));
      }
    }
    elseif(isset($_GET['application_id'])) {
      $application = $this->controller->loadApplication($_GET['application_id']);
      if($application->state0 === 'inactive') {
        Yii::app()->user->setFlash('error', '<strong>Your request cannot be completed</strong>: This application is inactive');
        $this->controller->redirect(array('application/view', 'id' => $application->id));
      }
    }

    return true;
  }
}