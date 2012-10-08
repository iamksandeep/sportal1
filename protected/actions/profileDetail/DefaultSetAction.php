<?php

class DefaultSetAction extends CAction {

  public function run($student_id, $category) {
    $student = $this->controller->loadUser($student_id);
    ProfileDetail::prepopulateUserWithCategory($student_id, ProfileDetail::getCategoryName($category));
    $this->controller->redirect(array('user/view','id'=>$student->id));
  }
}
