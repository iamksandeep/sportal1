<?php

class TodoController extends Controller
{
    public $layout = '//layouts/column2fb';
    public $showProfileFor; // user profile on the left
    public $currentProfileMenuItem; // current profile highlighted item
    public $todo;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl - pendingCount, activityCount',
            array(
                'application.filters.todo.MarkAsReadFilter + view',
                'controller' => $this,
            ),
        );
    }

    /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	public function actions()
	{
		return array(
            'new'=>'application.actions.todo.NewAction',
            'newFromStudent'=>'application.actions.todo.NewFromStudentAction',
            'index'=>'application.actions.todo.IndexAction',
            'view'=>'application.actions.todo.ViewAction',
            'changeState'=>'application.actions.todo.ChangeStateAction',
            'edit'=>'application.actions.todo.EditAction',
            'approve'=>'application.actions.todo.ApproveAction',
            'pendingCount'=>'application.actions.todo.PendingCountAction',
            'activityCount'=>'application.actions.todo.ActivityCountAction',
            'pendingApprovals'=>'application.actions.todo.PendingApprovalsAction',
            'pendingApprovalsCount'=>'application.actions.todo.PendingApprovalsCountAction',
            'anyNewTasks'=>'application.actions.todo.AnyNewTasksAction',
		);
	}

      public function loadUser($id) {
        $model = User::model()->findByPk($id);

        if($model == null)
          throw new CHttpException(404, 'Requested page not found.');

        return $model;
      }

      public function loadModel($id) {
        $model = Todo::model()->findByPk($id);

        if($model == null)
          throw new CHttpException(404, 'Requested page not found.');

        return $model;
      }
}
