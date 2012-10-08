<?php

/**
 * This is the model class for table "document".
 *
 * The followings are the available columns in table 'document':
 * @property integer $id
 * @property integer $student_id
 * @property integer $application_id
 * @property string $title
 * @property string $description
 * @property integer $type
 * @property string $filename
 * @property string $extension
 * @property string $upload_time
 * @property integer $uploader_id
 *
 * The followings are the available model relations:
 * @property User $uploader
 * @property User $student
 * @property AtApplication $application
 */
class Document extends CActiveRecord
{
	const ICON_CLASS = 'file';

	public $file;
	public $isApplicationDocument;

	/**
	 * @return array Document types
	 */
	static public function getTypes() {
		return array(
			0 => 'general',
			1 => 'content',
		);
	}

	/**
	 * @param  String $type type name
	 * @return int       type id (numerical)
	 */
	static public function getTypeId($type) {
		foreach(self::getTypes() as $typeId => $typeName) {
			if($typeName === $type)
				return $typeId;
		}
		return -1;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Document the static model class
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
		return 'document';
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
			array('title, type, isApplicationDocument', 'required', 'on' => 'upload, edit'),
			array('description, application_id', 'safe', 'on' => 'upload, edit'),
            array('file', 'file', 'types'=>'jpg, jpeg, png, gif, doc, docx, ppt, pptx, xls, xlsx, pdf, txt', 'on' => 'upload'),

            // other
			array('type, application_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student_id, application_id, title, description, type, filename, extension, upload_time, uploader_id', 'safe', 'on'=>'search'),
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
			'uploader' => array(self::BELONGS_TO, 'User', 'uploader_id'),
			'student' => array(self::BELONGS_TO, 'User', 'student_id'),
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
			'student_id' => 'Student',
			'application_id' => 'Application',
			'title' => 'Title',
			'description' => 'Description',
			'type' => 'Type',
			'filename' => 'Filename',
			'extension' => 'File extension',
			'upload_time' => 'Upload Time',
			'uploader_id' => 'Uploader',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('upload_time',$this->upload_time,true);
		$criteria->compare('uploader_id',$this->uploader_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return String Type of document
	 */
	public function getType0() {
		$types =  self::getTypes();
		return $types[$this->type];
	}

	protected function beforeValidate() {
		if($this->isNewRecord) {
			$this->upload_time = new CDbExpression('NOW()');
			$this->uploader_id = Yii::app()->user->id;
		}

		return parent::beforeValidate();
	}

	/**
	 * @return String base directory for storing this document (based on student)
	 */
	public function getBasePath() {
		return Yii::app()->basePath . '/documents/user/' . $this->student->id;
	}

	/**
	 * @return String stored lfilename for this document
	 */
	public function getFilePath() {
		return $this->getBasePath() . '/' . $this->id;
	}

	/**
	 * @param  int $id ID of model
	 * @return String     a link to model
	 */
	static public function getLinkFor($id) {
		$model = self::model()->findByPk($id);

		if($model) {
			$linkString = '<i class="icon-'.self::ICON_CLASS.'"></i> '.$model->title;
			return CHtml::link($linkString, array('document/download', 'id' => $id));
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
