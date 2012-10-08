<?php
class HelpController extends Controller
{
    public $layout = '//layouts/column2fb';
    public $showProfileFor; // user profile on the left
    public $currentProfileMenuItem; // current profile highlighted item';
	
	public function actionIndex()
	{
		if(Yii::app()->user->type !== 'student')
			throw new CHttpException(404, 'not found');

		$student = User::model()->findByPk(Yii::app()->user->id);
    	$this->render('help', array(
    		'student' => $student,
    	));
	}

}

?>