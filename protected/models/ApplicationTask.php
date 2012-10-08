<?php

/**
 * This is the model class for table "at_application_task".
 *
 * The followings are the available columns in table 'at_application_task':
 * @property integer $id
 * @property integer $application_id
 * @property string $title
 * @property string $description
 * @property integer $state
 *
 * The followings are the available model relations:
 * @property Application $application
 */
class ApplicationTask extends CActiveRecord
{
	const ICON_CLASS = 'list';

	// if not selected from drop down, allow custom title
	public $title_other;

	/**
	 * @return array task states
	 */
	static public function getStates() {
		return array(
			0 => 'not-started',
			1 => 'in-progress',
			2 => 'complete',
		);
	}

	/**
	 * @param  String $tate state name
	 * @return int       State id (numerical)
	 */
	static public function getStateId($state) {
		foreach(self::getStates() as $stateId => $stateName) {
			if($stateName === $state)
				return $stateId;
		}
		return -1;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ApplicationTask the static model class
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
		return 'at_application_task';
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
			array('title', 'required', 'on' => 'add, edit'),
			array('title_other', 'safe', 'on'=>'add, edit'),
			array('description', 'safe', 'on' => 'add, edit'),
			array('state', 'safe', 'on'=>'change-state'),

			// other
			array('state', 'numerical', 'integerOnly'=>true),
			array('title, title_other', 'length', 'max'=>255),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, application_id, title, description, state', 'safe', 'on'=>'search'),
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
			'activity' => array(self::HAS_MANY, 'Activity', 'application_task_id'),
			'relatedTodo' => array(self::HAS_MANY, 'Todo', 'application_task_id'),
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
			'description' => 'Description',
			'state' => 'State',
			'state0' => 'State',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Do stuff before validlating record
	 * @return boolean parent::beforeValidate()
	 */
	protected function beforeValidate() {
	    if ($this->isNewRecord && $this->getScenario() === 'add') {
	    	$this->state = 0;
	    }

		// if alternate title is set, use that
		if($this->title_other && $this->title_other != '')
			$this->title = $this->title_other;

	    return parent::beforeSave();
	}

	/**
	 * @return all unique titles in the db
	 */
	static public function getListOfTitles() {
		$details = ApplicationTask::model()->findAll(array(
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
	 * @return String State of task
	 */
	public function getState0() {
		$states =  self::getStates();
		return $states[$this->state];
	}

	/**
	 * @return String Label class for current task state
	 */
	public function getStateLabelClass() {
		switch($this->state0) {
			case 'not-started':
				return 'default';
				break;
			case 'in-progress':
				return 'warning';
				break;
			case 'complete':
				return 'success';
				break;
			default:
				return 'default';
		}
	}

	/**
	 * @return String Label class for current todo state
	 */
	public function getStateButtonClass() {
		switch($this->state0) {
			case 'not-started':
				return 'danger';
				break;
			case 'in-progress':
				return 'warning';
				break;
			case 'complete':
				return 'success';
				break;
			default:
				return 'default';
		}
	}

	/**
	 * @return String Icon class for current task state
	 */
	public function getStateIconClass() {
		switch($this->state0) {
			case 'not-started':
				return 'pause';
				break;
			case 'in-progress':
				return 'play';
				break;
			case 'complete':
				return 'check';
				break;
			default:
				return 'time';
		}
	}

	/**
	 * Logs activity for this application task
	 * @param  String $msg activity
	 * @return boolean      whether logging was successful
	 */
	public function log($msg) {
		return ActivityLogger::log($msg, $this->application->student->id, $this->application->id, $this->id);
	}

	/**
	 * @param  int $id ID of model
	 * @return String     a link to model
	 */
	static public function getLinkFor($id) {
		$model = self::model()->findByPk($id);

		if($model) {
			$linkString = '<i class="icon-'.self::ICON_CLASS.'"></i> '.$model->title;
			return CHtml::link($linkString, array('applicationTask/view', 'id' => $id));
		}

		return null;
	}

	/**
	 * @return String parsed description
	 */
	public function getParsedDescription() {
		return SmartContentParser::parse($this->description);
	}
}
