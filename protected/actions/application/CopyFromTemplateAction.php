<?php

class CopyFromTemplateAction extends CAction {

    public function run($id, $item_to_copy) {
        if(!($item_to_copy === 'details' || $item_to_copy === 'checklist'))
            throw new CHttpException(400, 'Invalid request.');

        // load target application
        $model = $this->controller->loadModel($id);

        // Verify passed parameter
        if($item_to_copy === 'details' && !Yii::app()->user->checkAccess('templateApplicationDetail', array(
            'student' => $model->student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
        )))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        // Verify passed parameter
        if($item_to_copy === 'checklist' && !Yii::app()->user->checkAccess('templateApplicationTask', array(
            'student' => $model->student,
            'currentUser' => User::model()->findByPk(Yii::app()->user->id),
        )))
            throw new CHttpException(403, 'You are not authorized to make this request!');

        // access check
        //

        // show application drop down?
        $showApplicationDropdown = false;

        // if student has been selected
        $student = new User;
        $application = new Application;
        if(isset($_POST['User'])) {
            $student = $this->controller->loadUser($_POST['User']['id']);

            // show application drop down list for this student
            $showApplicationDropdown = true;
        }

        // if application has been selected
        if(isset($_POST['Application'])) {

            // load template application
            $application = $this->controller->loadModel($_POST['Application']['id']);

            // copy details from template application
            if($item_to_copy === 'details') $this->copyDetails($model, $application);
            else $this->copyChecklist($model, $application);

            // go back to target application
            Yii::app()->user->setFlash('success', 'Template has been copied');
            $this->controller->redirect(array('view','id'=>$model->id));
        }

        // render page
        $this->controller->render('copyFromTemplate',array(
          'model'=>$model,
          'student'=>$student,
          'application'=>$application,
          'showApplicationDropdown'=>$showApplicationDropdown,
        ));
    }

    private function copyDetails($target, $source) {
        foreach($source->applicationDetails as $detail) {
            // check if a detail with the same title already exists in the
            // target application?
            $oldDetail = ApplicationDetail::model()->findByAttributes(array(
                'title' => $detail->title,
                'application_id' => $target->id,
            ));

            // if it does and the content is empty, delete it
            if($oldDetail && strip_tags(trim($oldDetail->content)) == '')
                $oldDetail->delete();

            $d = new ApplicationDetail;
            $d->application_id = $target->id;
            $d->title = $detail->title;
            $d->content = $detail->content;
            $d->save();

            // activity log
            $activity = $target->log('added new application detail: <em>'.$d->title.'</em>');
            // notify
            if($activity) {
               $target->student->notifyRoles($activity, array('manager', 'counselor'));
               $target->student->notify($activity);
            }
        }
    }

    private function copyChecklist($target, $source) {
        foreach($source->applicationTasks as $task) {
            $t = new ApplicationTask;
            $t->application_id = $target->id;
            $t->title = $task->title;
            $t->description = $task->description;
            $t->save();

            // activity log
            $activity = $target->log('added checklist item: :applicationTask_'.$t->id.':');
            // notify
            if($activity) {
               $target->student->notifyRoles($activity, array('manager', 'counselor', 'content-writer'));
               $target->student->notify($activity);
            }
        }
    }
}
