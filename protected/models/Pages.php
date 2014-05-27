<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property string $id
 * @property string $dtc
 * @property string $dte
 * @property integer $published
 * @property integer $deleted
 * @property string $alias
 * @property string $title
 * @property string $descr
 * @property string $text
 */
class Pages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alias, title, text', 'required'),
			array('published, deleted', 'numerical', 'integerOnly'=>true),
			array('dtc, dte', 'length', 'max'=>10),
			array('alias', 'length', 'max'=>50),
			array('title', 'length', 'max'=>255),
			array('descr', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dtc, dte, published, deleted, alias, title, descr, text', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'dtc' => 'Dtc',
			'dte' => 'Dte',
			'published' => 'Published',
			'deleted' => 'Deleted',
			'alias' => 'Alias',
			'title' => 'Title',
			'descr' => 'Descr',
			'text' => 'Text',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('dtc',$this->dtc,true);
		$criteria->compare('dte',$this->dte,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('descr',$this->descr,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeSave(){
        if(parent::beforeSave()){
            if($this->getIsNewRecord())
                $this->dtc = time();
            else
                $this->dte = time();
            return true;
        }
        else return false;
    }

    /**
     * @return Pages
     */
    public static function main_block(){
        $criteria = new CDbCriteria();
        //$criteria->limit = 1;
        $criteria->order = 'RAND()';

        $criteria->addCondition("alias='main_block'");
        return Pages::model()->find($criteria);

    }
}
