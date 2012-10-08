<?php

class IndexAction extends CAction {

    private function getMnemonicUser($s) {
        // make sure that its a student
        $condition = 't.type <> :type
                    ';
        $params = array(
          ':type' => User::getTypeId('student'),
        );

        // search
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
            'params' => $params,
            'order' => 'name_first, name_last, id',
          ),
        ));
    }

    private function getAllStudents($s) {
        // make sure that its a student
        $condition = 't.type = :type
                      ';
        $params = array();
        $params[':type'] = User::getTypeId('student');

        // search
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
            'params' => $params,
            'order' => 'name_first, name_last, id',
          ),
        ));
    }

    private function getLevelBasedDataProvider($level, $s) {
        // make sure that its a student
        $condition = 't.type = :type
                      ';
        $params = array();
        $params[':type'] = User::getTypeId('student');

        // Profile conditions
        $condition .= 'AND pr_detail.category = :profileCategory
                      AND pr_detail.title = :profileTitle
                      AND pr_detail.content LIKE :profileContent
                    ';
        $params[':profileCategory'] = ProfileDetail::getCategoryId('program');
        $params[':profileTitle'] = 'Level';
        $params[':profileContent'] = '%'.addcslashes($level, '%').'%';

        // search
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
            'join' => 'LEFT JOIN pr_detail on t.id = pr_detail.student_id',
            'condition' => $condition,
            'params' => $params,
            'order' => 'name_first, name_last, id',
          ),
        ));
    }

    public function run() {
        // access check
        $currentUser = $this->controller->loadModel(Yii::app()->user->id);
        if($currentUser->type0 === 'student')
          throw new CHttpException(403, 'You are not authorized to make this request!');

        $this->controller->layout = "//layouts/column1";

        $s = null;
        if(isset($_POST['search'])) {
          $s = $_POST['search'];
        }

        $users = array();

        // get users
        $users['mnemonic'] = $this->getMnemonicUser($s);
        $users['ug'] = $this->getLevelBasedDataProvider('ug', $s);
        $users['pg'] = $this->getLevelBasedDataProvider('pg', $s);
        $users['allstudents'] = $this->getAllStudents($s);

        $this->controller->render('index', array(
          'userData' => $users,
          's' => $s,
        ));
    }
}
