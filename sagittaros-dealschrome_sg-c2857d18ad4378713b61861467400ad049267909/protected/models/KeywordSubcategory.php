<?php

/**
 * This is the model class for table "Keyword_subcategory".
 *
 * The followings are the available columns in table 'Keyword_subcategory':
 * @property string $id
 * @property string $name
 * @property string $category
 *
 * The followings are the available model relations:
 * @property Keyword[] $keywords
 * @property KeywordCategory $category0
 */
class KeywordSubcategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KeywordSubcategory the static model class
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
		return 'Keyword_subcategory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, category', 'required'),
			array('name', 'length', 'max'=>255),
			array('category', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, category', 'safe', 'on'=>'search'),
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
			'keywords' => array(self::HAS_MANY, 'Keyword', 'subcategory'),
			'category0' => array(self::BELONGS_TO, 'KeywordCategory', 'category'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'category' => 'Category',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category',$this->category,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}