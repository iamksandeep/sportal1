<?php

class AssignedToMeAction extends CAction {

    private function getDataProvider($userId, $role, $s) {
      $condition = 't.type = :type
                            AND role_assignment.user_id = :userId
                            AND role_assignment.role = :role
                            ';
      $params = array(
        ':type' => User::getTypeId('student'),
        ':userId' => $userId,
        ':role' => RoleManager::getRoleId($role),
      );

      if($s) {
        $s = addcslashes($s, '%_'); // escape LIKE's special characters
        $condition .= 'AND (
                        t.name_first LIKE :s
                        OR t.name_last LIKE :s
                        OR t.email LIKE :s
                      )';
        $params[':s'] = '%'.$s.'%';
      }

      return new CActiveDataProvider('User', array(
          'criteria' => array(
            'condition' => $condition,
            'join' => 'LEFT JOIN role_assignment ON role_assignment.student_id = t.id',
            'params' => $params,
            'order' => 't.name_first, t.name_last, t.id',
          ),
      ));
    }

    public function run() {
        // access check
        $currentUser = $this->controller->loadModel(Yii::app()->user->id);
        if($currentUser->type0 === 'student')
          throw new CHttpException(403, 'You are not authorized to make this request!');

        $this->controller->layout = "//layouts/column1";

        // search
        $s = null;
        if(isset($_POST['search']))
          $s = $_POST['search'];

        $dataProviders = array();
        foreach(RoleManager::getRoles() as $role) {
          $dataProviders[$role] = $this->getDataProvider($currentUser->id, $role, $s);
        }

        $this->controller->render('assignedToMe', array(
          'dataProviders' => $dataProviders,
          's' => $s,
        ));
    }
}
