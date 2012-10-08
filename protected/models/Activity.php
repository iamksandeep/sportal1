<?php

/**
 * This is the model class for table "activity".
 *
 * The followings are the available columns in table 'activity':
 * @property integer $id
 * @property integer $student_id
 * @property integer $application_id
 * @property integer $application_task_id
 * @property string $comment
 * @property integer $log
 * @property integer $author_id
 * @property string $time
 *
 * The followings are the available model relations:
 * @property User $author
 * @property AtApplication $application
 * @property AtApplicationTask $applicationTask
 * @property User $student
 */
class Activity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Activity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'activity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// safe
			array('comment', 'required', 'on' => 'add, edit'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student_id, application_id, application_task_id, comment, log, author_id, time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'application' => array(self::BELONGS_TO, 'Application', 'application_id'),
			'applicationTask' => array(self::BELONGS_TO, 'ApplicationTask', 'application_task_id'),
			'student' => array(self::BELONGS_TO, 'User', 'student_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'student_id' => 'Student',
			'application_id' => 'Application',
			'application_task_id' => 'Application Task',
			'comment' => 'Comment',
			'log' => 'Log',
			'author_id' => 'Author',
			'time' => 'Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('application_id',$this->application_id);
		$criteria->compare('application_task_id',$this->application_task_id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('log',$this->log);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Do stuff before validation
	 * @return boolean parent::beforeValidate()
	 */
	protected function beforeValidate() {
		if($this->isNewRecord) {
			$this->time = new CDbExpression('NOW()');
			$this->author_id = Yii::app()->user->id;

			if($this->scenario === 'add') {
				$this->log = false;
			}
		}

		return parent::beforeValidate();
	}

	/**
	 * @return String parsed comment
	 */
	public function getParsedComment() {
		return SmartContentParser::parse($this->comment);
	}
}
