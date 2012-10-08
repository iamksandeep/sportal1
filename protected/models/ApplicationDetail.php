<?php

/**
 * This is the model class for table "at_application_detail".
 *
 * The followings are the available columns in table 'at_application_detail':
 * @property integer $id
 * @property integer $application_id
 * @property string $title
 * @property string $content
 *
 * The followings are the available model relations:
 * @property Application $application
 */
class ApplicationDetail extends CActiveRecord
{
	// if not selected from drop down, allow custom title
	public $title_other;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ApplicationDetail the static model class
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
		return 'at_application_detail';
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
			array('title', 'required', 'on'=>'add, edit'),
			array('title_other, content', 'safe', 'on'=>'add, edit'),

			// other
			array('title, title_other', 'length', 'max'=>255),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, application_id, title, content', 'safe', 'on'=>'search'),
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
			'application' => array(self::BELONGS_TO, 'Application', 'application_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'application_id' => 'Application',
			'title' => 'Title',
			'content' => 'Content',
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
		$criteria->compare('application_id',$this->application_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return String parsed content
	 */
	public function getParsedContent() {
		return SmartContentParser::parse($this->content);
	}

	/**
	 * Do stuff before validation
	 * @return boolean parent::beforeValidate()
	 */
	protected function beforeValidate() {
		// if alternate title is set, use that
		if($this->title_other && $this->title_other != '')
			$this->title = $this->title_other;

		return parent::beforeValidate();
	}

	/**
	 * @return all unique titles in the db
	 */
	static public function getListOfTitles() {
		$details = ApplicationDetail::model()->findAll(array(
			'order' => 'title',
		));
		$arr = array();

		foreach($details as $d) {
			if(!in_array($d->title, $arr))
				$arr[$d->title] = $d->title;
		}

		return $arr;
	}

	/**
	 * Add some default details under an application
	 * @param  int $applicationId Application under which details are to be added
	 */
	static public function prepopulateApplication($applicationId) {
		$details = array(
			'Location',
			'SAT 1',
			'SAT 2',
			'English Proficiency',
			'Fee',
			'Scholarship',
			'University url',
			'Program url',
		);

		foreach($details as $detail) {
			$model = new ApplicationDetail('add');
			$model->application_id = $applicationId;
			$model->title = $detail;
			//$model->content = $content;
			$model->save();
		}
	}
}
