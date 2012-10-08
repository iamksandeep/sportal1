<?php

class NewAction extends CAction {

    private function allowTodoToStudent($student, $currentUser) {
        return Yii::app()->user->checkAccess('assignJobToStudent', array(
                'student' => $student,
                'currentUser' => User::model()->findByPk(Yii::app()->user->id),
              ));
    }

    public function run($student_id, $assignee_id) {
        $student = $this->controller->loadUser($student_id);
        $assignee = $this->controller->loadUser($assignee_id);
        $model = new Todo('new');
        $model->student_id = $student->id;
        $model->assignee_id = $assignee->id;

        $currentUser = User::model()->findByPk(Yii::app()->user->id);

        // check if from student
        if($currentUser->type0 === 'student')
            throw new CHttpException(403, 'You are not authorized to make this request!');

        // check if to student
        if($student_id == $assignee_id && !$this->allowTodoToStudent($student, $currentUser))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        if(isset($_POST['Todo'])) {
            $model->attributes = $_POST['Todo'];

            if($model->save()) {
                Yii::app()
                ->user
                ->setFlash( 'success',
                'New task <em>'
                .$model->title
                .'</em> assigned to <strong>'
                .$assignee->name
                .'</strong>');

                $this->controller->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->controller->render('new', array(
            'model' => $model,
            'student' => $student,
            'assignee' => $assignee,
        ));
    }
}
