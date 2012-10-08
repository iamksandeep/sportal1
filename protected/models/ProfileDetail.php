<?php

/**
 * This is the model class for table "pr_detail".
 *
 * The followings are the available columns in table 'pr_detail':
 * @property integer $id
 * @property integer $student_id
 * @property integer $category
 * @property string $title
 * @property string $content
 *
 * The followings are the available model relations:
 * @property User $student
 */
class ProfileDetail extends CActiveRecord
{
	// if not selected from drop down, allow custom title
	public $title_other;

	static public function getProfileDefaults() {
		return array(
			'program' => array(
				'Level',
				'Program',
				'Countries of interest',
			),
			'personal' => array(
				'Date of birth',
				'Gender',
			),
			'contact' => array(
				'Mobile no.',
				'Address',
			),
		);
	}

	/**
	 * @return array detail categories
	 */
	static public function getCategories() {
		return array(
			0 => 'personal',
			1 => 'contact',
			2 => 'exam-scores',
			3 => 'additional',
			4 => 'program',
		);
	}

	/**
	 * @param  String $tate category name
	 * @return int       Category id (numerical)
	 */
	static public function getCategoryId($category) {
		foreach(self::getCategories() as $categoryId => $categoryName) {
			if($categoryName === $category)
				return $categoryId;
		}
		return -1;
	}

    /**
     * @return String category name for given id
     */
    static public function getCategoryName($categoryId) {
        $categories =  self::getCategories();
        return $categories[$categoryId];
    }

	/**
	 * @return String category of detail
	 */
	public function getCategory0() {
		$states =  self::getCategories();
		return $states[$this->category];
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
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfileDetail the static model class
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
		return 'pr_detail';
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
			array('title', 'required'),
			array('title_other, content', 'safe', 'on'=>'add, edit'),

			// other
			array('title, title_other', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student_id, category, title, content', 'safe', 'on'=>'search'),
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
			'category' => 'Category',
			'title' => 'Type of detail',
			'content' => 'Value',
		);
	}

	/**
	 * @return all unique titles in the db for a cvategory
	 */
	static public function getListOfTitles($category) {
		$details = ProfileDetail::model()->findAllByAttributes(array(
			'category' => $category,
		), array(
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
		$criteria->compare('category',$this->category);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Add some default profile details under a student
	 * @param  int $userId User under which details are to be added
	 */
	static public function prepopulateUser($userId) {
		foreach(self::getProfileDefaults() as $category => $details) {
			self::prepopulateUserWithCategory($userId, $category);
		}
	}

	/**
	 * Add some default profile details under a student
	 * @param  int $userId User under which details are to be added
	 */
	static public function prepopulateUserWithCategory($userId, $category) {
		$defaults = self::getProfileDefaults();
		if(!isset($defaults[$category]))
			return false;

		foreach($defaults[$category] as $detail) {
			$model = new ProfileDetail('add');
			$model->category = ProfileDetail::getCategoryId($category);
			$model->student_id = $userId;
			$model->title = $detail;
			//$model->content = $content;
			$model->save();
		}
	}
}
