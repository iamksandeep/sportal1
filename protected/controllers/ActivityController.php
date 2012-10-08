<?php

class ActivityController extends Controller
{
    public $layout = '//layouts/column2fb';
    public $showProfileFor; // user profile on the left
    public $currentProfileMenuItem; // current profile highlighted item

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
      array(
          'application.filters.activity.DisabledUserFilter - edit, delete',
          'controller' => $this,
      ),
      array(
          'application.filters.activity.InactiveApplicationFilter + postApplicationActivity, postApplicationTaskActivity',
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
			'postStudentActivity'=>'application.actions.activity.PostStudentActivityAction',
			'postApplicationActivity'=>'application.actions.activity.PostApplicationActivityAction',
			'postApplicationTaskActivity'=>'application.actions.activity.PostApplicationTaskActivityAction',
            'index' => 'application.actions.activity.IndexAction',
			'edit'=>'application.actions.activity.EditAction',
            'delete'=>'application.actions.activity.DeleteAction',
            'listAll'=>'application.actions.activity.ListAllAction',
		);
	}

    public function loadModel($id) {
        $model = Activity::model()->findByPk($id);

        if($model == null)
            throw new CHttpException(404, 'Requested page not found.');

        return $model;
    }

	public function loadUser($id) {
		$model = User::model()->findByPk($id);

		if($model == null)
			throw new CHttpException(404, 'Requested page not found.');

		return $model;
	}

	public function loadApplication($id) {
		$model = Application::model()->findByPk($id);

		if($model == null)
			throw new CHttpException(404, 'Requested page not found.');

		return $model;
	}

	public function loadApplicationTask($id) {
		$model = ApplicationTask::model()->findByPk($id);

		if($model == null)
			throw new CHttpException(404, 'Requested page not found.');

		return $model;
	}
}
