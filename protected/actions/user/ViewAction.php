<?php

class ViewAction extends CAction {

    public function run($id) {
        $model = $this->controller->loadModel($id);
        $currentUser = $this->controller->loadModel(Yii::app()->user->id);

        // if user type is student, render student profile
        if($model->type0 === 'student') $this->renderStudentProfile($model, $currentUser);
        // else render mnemonic user profile
        elseif($model->id === $currentUser->id)
          $this->renderOwnProfile($model, $currentUser);
        else
          $this->renderMnemonicProfile($model, $currentUser);
    }

    private function getProfileDataProvider($studentId, $category) {
        return new CActiveDataProvider('ProfileDetail', array(
          'criteria' => array(
            'condition' => 'student_id = :studentId AND category = :category',
            'params' => array(
                ':studentId' => $studentId,
                ':category' => ProfileDetail::getCategoryId($category),
            ),
          ),
        ));
    }

    private function renderStudentProfile($model, $currentUser) {
        $this->controller->layout = '//layouts/column2fb';

        // access control
        if($currentUser->type0 === 'student' && $model->id !== $currentUser->id)
          throw new CHttpException(403, 'You are not authorized to make this request!');

        // applications
        $applicationData = new CActiveDataProvider('Application', array(
          'criteria' => array(
            'condition' => 'student_id = :student_id',
            'params' => array(':student_id' => $model->id),
            'order' => '(CASE WHEN deadline IS NULL THEN 1 ELSE 0 END) ASC,
                        deadline ASC, state DESC, university ASC',
          ),
        ));

        // academic details
        $academicData = new CActiveDataProvider('AcademicDetail', array(
          'criteria' => array(
            'condition' => 'student_id = :student_id',
            'params' => array(':student_id' => $model->id),
            'order' => 'level',
          ),
        ));

        // documents - general
        $generalDocumentData = new CActiveDataProvider('Document', array(
          'criteria' => array(
            'with' => array('student', 'uploader', 'application'),
            'condition' => 't.student_id = :student_id
                            AND t.type = :type
                            AND t.application_id IS NULL',
            'params' => array(
                          ':student_id' => $model->id,
                          ':type' => Document::getTypeId('general'),
                        ),
            'order' => 'upload_time DESC',
          ),
        ));

        // documents - content
        $contentDocumentData = new CActiveDataProvider('Document', array(
          'criteria' => array(
            'with' => array('student', 'uploader', 'application'),
            'condition' => 't.student_id = :student_id
                            AND t.type = :type
                            AND t.application_id IS NULL',
            'params' => array(
                          ':student_id' => $model->id,
                          ':type' => Document::getTypeId('content'),
                        ),
            'order' => 'upload_time DESC',
          ),
        ));

        // activity
        $activityData = new CActiveDataProvider('Activity', array(
          'criteria' => array(
            'with' => array('student', 'author', 'application', 'applicationTask'),
            'condition' => 't.student_id = :student_id',
            'params' => array(':student_id' => $model->id),
            'order' => 'time DESC',
          ),
        ));

        // assignments
        $roleAssignments = RoleAssignment::model()->findAll(array(
            'with' => array('user'),
            'condition' => 't.student_id = :student_id',
            'params' => array(':student_id' => $model->id),
            'order' => 't.role ASC, user.name_first ASC, user.name_last ASC',
        ));

        // tasks assigned to astudent
        if(Yii::app()->user->checkAccess('viewTasksToStudent', array(
            'student' => $model,
            'currentUser' => $currentUser,
          ))) {

          $tasksToStudent = array();
          $states = array('not-started', 'in-progress', 'complete');

          foreach($states as $state) {
            $tasksToStudent[$state] = new CActiveDataProvider('Todo', array(
              'criteria' => array(
                'with' => array('assignee', 'student'),
                'condition' => 'assignee_id = :assignee_id
                                AND state = :state',
                'params' => array(
                              ':assignee_id' => $model->id,
                              ':state' => Todo::getStateId($state),
                            ),
                'order' => '
                            CASE WHEN last_activity_time IS NULL THEN 0 ELSE 1 END DESC, last_activity_time DESC,
                            CASE WHEN complete_time IS NULL THEN 0 ELSE 1 END DESC, complete_time DESC,
                            CASE WHEN deadline IS NULL THEN 1 ELSE 0 END, deadline,
                            initiate_time',
              ),
            ));
          }
        }

        // profile details
        $profileData = array();
        $profileData['personal'] = $this->getProfileDataProvider($model->id, 'personal');
        $profileData['contact'] = $this->getProfileDataProvider($model->id, 'contact');
        $profileData['exam-scores'] = $this->getProfileDataProvider($model->id, 'exam-scores');
        $profileData['additional'] = $this->getProfileDataProvider($model->id, 'additional');
        $profileData['program'] = $this->getProfileDataProvider($model->id, 'program');

        $this->controller->render('//profile/index', array(
          'model' => $model,
          'applicationData' => $applicationData,
          'academicData' => $academicData,
          'activityData' => $activityData,
          'profileData' => $profileData,
          'generalDocumentData' => $generalDocumentData,
          'contentDocumentData' => $contentDocumentData,
          'tasksToStudent' => isset($tasksToStudent) ? $tasksToStudent : null,
          'roleAssignments' => RoleManager::groupRoles($roleAssignments),
        ));
    }

    private function renderOwnProfile($model, $currentUser) {
        // messages
        $messageData = array();
        $messageData['unread'] = $model->unreadMessageCount;

        // notifications
        $notificationData = array();
        $notificationData['unseen'] = Notification::model()->count('target_id = :targetId AND ack = 0', array(
            ':targetId' => $model->id,
        ));

        // jobs
        $jobData = array();
        $jobCondition = ' assignee_id = :assignee_id
                          AND state = :state
                          AND approved = 1';
        $jobParams = array(
                            ':assignee_id' => $model->id,
                            ':state' => Todo::getStateId('not-started'),
        );
        $jobData['not-started'] = Todo::model()->count($jobCondition, $jobParams);

        $jobParams = array(
                            ':assignee_id' => $model->id,
                            ':state' => Todo::getStateId('in-progress'),
        );
        $jobData['in-progress'] = Todo::model()->count($jobCondition, $jobParams);
        $jobData['new-activity'] = $model->jobActivityCount;

        // assigned students
        $studentData = array();
        $studentData['manager'] = RoleAssignment::model()->count('user_id = :userId AND role = :role', array(
                            ':userId' => $model->id,
                            ':role' => RoleManager::getRoleId('manager'),
        ));;
        $studentData['researcher'] = RoleAssignment::model()->count('user_id = :userId AND role = :role', array(
                            ':userId' => $model->id,
                            ':role' => RoleManager::getRoleId('researcher'),
        ));;
        $studentData['counselor'] = RoleAssignment::model()->count('user_id = :userId AND role = :role', array(
                            ':userId' => $model->id,
                            ':role' => RoleManager::getRoleId('counselor'),
        ));;
        $studentData['content-writer'] = RoleAssignment::model()->count('user_id = :userId AND role = :role', array(
                            ':userId' => $model->id,
                            ':role' => RoleManager::getRoleId('content-writer'),
        ));;

        $this->controller->render('view', array(
          'model' => $model,
          'messageData' => $messageData,
          'notificationData' => $notificationData,
          'jobData' => $jobData,
          'studentData' => $studentData,
        ));
    }

    private function renderMnemonicProfile($model, $currentUser) {
        $this->controller->render('view', array(
          'model' => $model,
        ));
    }
}
