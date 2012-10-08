<?php

class IndexAction extends CAction {
    /**
     * Lists documents for a student
     * @param  int $student_id Primary Key of student user
     */
    public function run($student_id) {
        $student = $this->controller->loadUser($student_id);

        // access check
        if(!Yii::app()->user->checkAccess('viewDocuments', array(
            'student' => $student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
          )))
          throw new CHttpException(403, 'You are not authorized to make this request!');

        // Fetch global docs
        $condition = 't.student_id = :student_id AND t.application_id IS NULL
                    ';

        $params = array(
            ':student_id' => $student_id,
        );

        // search
        $as = $s = null;
        if(isset($_POST['search'])) {
            $as = $s = $_POST['search'];
            $as = $s = addcslashes($s, '%_'); // escape LIKE's special characters
            $condition .= 'AND (
                            t.title LIKE :s
                            OR t.description LIKE :s
                            OR t.filename LIKE :s
                            OR t.extension LIKE :s
                            OR uploader.name_first LIKE :s
                            OR uploader.name_last LIKE :s
                          )';
            $params[':s'] = '%'.$s.'%';
        }

        $globalDocs = new CActiveDataProvider('Document', array(
            'criteria' => array(
                'with' => array('uploader'),
                'condition' => $condition,
                'params' => $params,
                'order' => 'upload_time DESC',
            ),
            'pagination' => array('pageSize' => 20),
        ));

        // Fetch application docs
        $applicationDocs = array();
        foreach($student->applications as $a) {
            $condition = 't.student_id = :student_id
                          AND t.application_id = :application_id
                          ';

            $params = array(
                ':student_id' => $student_id,
                ':application_id' => $a->id,
            );

            // search
            if($as) {
                $condition .= 'AND (
                                t.title LIKE :s
                                OR t.description LIKE :s
                                OR t.filename LIKE :s
                                OR t.extension LIKE :s
                                OR uploader.name_first LIKE :s
                                OR uploader.name_last LIKE :s
                              )';
                $params[':s'] = '%'.$as.'%';
            }

            $docsData = new CActiveDataProvider('Document', array(
                            'criteria' => array(
                                'with' => array('uploader'),
                                'condition' => $condition,
                                'params' => $params,
                                'order' => 'upload_time DESC',
                            ),
                            'pagination' => array('pageSize' => 20),
                        ));

            if($docsData->totalItemCount > 0)
                array_push($applicationDocs, array(
                    'application' => $a,
                    'data' => $docsData,
                ));
        }

        $this->controller->render('index', array(
            'student' => $student,
            'globalDocs' => $globalDocs,
            'applicationDocs' => $applicationDocs,
            's' => $s,
        ));
    }
}
