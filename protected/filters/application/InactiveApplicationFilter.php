<?php

class InactiveApplicationFilter extends CFilter {

  public $controller;

  public function preFilter() {
    if(isset($_GET['id']) && $_GET['item_to_copy'] === 'checklist') {
      $application = $this->controller->loadModel($_GET['id']);
      if($application->state0 === 'inactive') {
        Yii::app()->user->setFlash('error', '<strong>Your request cannot be completed</strong>: This application is inactive');
        $this->controller->redirect(array('application/view', 'id' => $application->id));
      }
    }

    return true;
  }
}
