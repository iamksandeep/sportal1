<?php

class SiteController extends Controller
{
    public $layout = '//layouts/column2';

    public function actions() {
        return array(
            'index' => 'application.actions.site.IndexAction',
            'login' => 'application.actions.site.LoginAction',
            'logout' => 'application.actions.site.LogoutAction',
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}