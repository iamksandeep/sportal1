<?php

class DocumentController extends Controller
{
    public $showProfileFor; // user profile on the left
    public $currentProfileMenuItem; // current profile highlighted item
    public $layout = '//layouts/column2fb';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
            array(
                'application.filters.document.DisabledUserFilter - delete, download, index',
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
            'upload' => 'application.actions.document.UploadAction',
            'edit' => 'application.actions.document.EditAction',
            'delete' => 'application.actions.document.DeleteAction',
            'download' => 'application.actions.document.DownloadAction',
            'index' => 'application.actions.document.IndexAction',
		);
	}

    public function loadModel($id) {
        $model = Document::model()->findByPk($id);

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
}
