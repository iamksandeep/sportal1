<?php

class ApplicationTaskController extends Controller
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
          'application.filters.applicationTask.DisabledUserFilter - view',
          'controller' => $this,
      ),
      array(
          'application.filters.applicationTask.InactiveApplicationFilter - view',
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
			'add'=>'application.actions.applicationTask.AddAction',
      'view'=>'application.actions.applicationTask.ViewAction',
			'edit'=>'application.actions.applicationTask.EditAction',
			'changeState'=>'application.actions.applicationTask.ChangeStateAction',
			'remove'=>'application.actions.applicationTask.RemoveAction',
		);
	}

    public function loadModel($id) {
        $model = ApplicationTask::model()->findByPk($id);

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
}
