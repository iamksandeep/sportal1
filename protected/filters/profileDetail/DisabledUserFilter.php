<?php

class DisabledUserFilter extends CFilter {

  public $controller;

  public function preFilter() {
    if(isset($_GET['id'])) {
      $detail = $this->controller->loadModel($_GET['id']);
      if($detail->student->disabled) {
        Yii::app()->user->setFlash('error', '<strong>Your request cannot be completed</strong>: This user account is disabled');
        $this->controller->redirect(array('user/view', 'id' => $detail->student->id));
      }
    }
    elseif(isset($_GET['student_id'])) {
      $student = $this->controller->loadUser($_GET['student_id']);
      if($student->disabled) {
        Yii::app()->user->setFlash('error', '<strong>Your request cannot be completed</strong>: This user account is disabled');
        $this->controller->redirect(array('user/view', 'id' => $student->id));
      }
    }

    return true;
  }
}
