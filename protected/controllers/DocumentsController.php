<?php

class DocumentsController extends Controller
{
    public $layout = '//layouts/column3';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl',
            array(
                'application.filters.document.DisabledUserFilter - delete, download',
                'controller' => $this,
            ),
              array(
                  'application.filters.document.InactiveApplicationFilter + uploadApplicationDocument',
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
            'uploadStudentDocument' => 'application.actions.document.UploadStudentDocumentAction',
            'uploadApplicationDocument' => 'application.actions.document.UploadApplicationDocumentAction',
            'delete' => 'application.actions.document.DeleteAction',
            'download' => 'application.actions.document.DownloadAction',
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
