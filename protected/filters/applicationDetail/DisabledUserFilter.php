<?php

class DisabledUserFilter extends CFilter {

  public $controller;

  public function preFilter() {
    if(isset($_GET['id'])) {
      $applicationDetail = $this->controller->loadModel($_GET['id']);
      if($applicationDetail->application->student->disabled) {
        Yii::app()->user->setFlash('error', '<strong>Your request cannot be completed</strong>: This user account is disabled');
        $this->controller->redirect(array('application/view', 'id' => $applicationDetail->application->id));
      }
    }
    elseif(isset($_GET['application_id'])) {
      $application = $this->controller->loadApplication($_GET['application_id']);
      if($application->student->disabled) {
        Yii::app()->user->setFlash('error', '<strong>Your request cannot be completed</strong>: This user account is disabled');
        $this->controller->redirect(array('application/view', 'id' => $application->id));
      }
    }

    return true;
  }
}