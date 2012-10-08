<?php

class NewAction extends CAction {

  public function run($todo_id) {
    $todo = $this->controller->loadTodo($todo_id);
    $model = new TDActivity('add');
    $model->todo_id = $todo_id;

    $cuId = Yii::app()->user->id;

    // access check
    if(!($model->todo->assignee_id === $cuId || $model->todo->assigner_id === $cuId) && !Yii::app()->user->checkAccess('postJobActivity', array(
        'student' => $model->todo->student,
        'currentUser' => User::model()->findByPk($cuId),
    )))
        throw new CHttpException(403, 'You are not authorized to make this request!');


    if(isset($_POST['TDActivity']))
    {
      $model->attributes=$_POST['TDActivity'];
      if($model->save()) {
        $model->todo->updateLastActivityTime();
        Yii::app()->user->setFlash('success', 'Activity posted');
        $this->controller->redirect(array('todo/view','id'=>$model->todo_id));
      }
      else
        Yii::app()->user->setFlash('error', 'Unable to post activity.');
    }

    $this->controller->render('new',array(
      'model'=>$model,
    ));
  }
}
