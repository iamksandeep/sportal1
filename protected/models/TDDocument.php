<?php

/**
 * This is the model class for table "td_document".
 *
 * The followings are the available columns in table 'td_document':
 * @property integer $id
 * @property integer $todo_id
 * @property string $title
 * @property string $description
 * @property string $filename
 * @property string $extension
 * @property string $upload_time
 * @property integer $uploader_id
 *
 * The followings are the available model relations:
 * @property User $uploader
 * @property Todo $todo
 */
class TDDocument extends CActiveRecord
{
	public $file;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TDDocument the static model class
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
		return 'td_document';
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
			array('title', 'required', 'on' => 'upload'),
			array('description', 'safe', 'on' => 'upload'),
            array('file', 'file', 'types'=>'jpg, jpeg, png, gif, doc, docx, ppt, pptx, xls, xlsx, pdf, txt', 'on' => 'upload'),

            // other
			array('title', 'length', 'max'=>255),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, todo_id, title, description, filename, extension, upload_time, uploader_id', 'safe', 'on'=>'search'),
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
			'todo' => array(self::BELONGS_TO, 'Todo', 'todo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'todo_id' => 'Todo',
			'title' => 'Title',
			'description' => 'Description',
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
		$criteria->compare('todo_id',$this->todo_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('upload_time',$this->upload_time,true);
		$criteria->compare('uploader_id',$this->uploader_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
		return Yii::app()->basePath . '/documents/todo/' . $this->todo->id;
	}

	/**
	 * @return String stored lfilename for this document
	 */
	public function getFilePath() {
		return $this->getBasePath() . '/' . $this->id;
	}

	/**
	 * @return String parsed description
	 */
	public function getParsedDescription() {
		return SmartContentParser::parse($this->description);
	}
}
