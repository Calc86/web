<?php

/**
 * This is the model class for table "archive".
 *
 * The followings are the available columns in table 'archive':
 * @property integer $id
 * @property integer $cam_id
 * @property string $type
 * @property integer $date_start
 * @property integer $date_end
 * @property integer $date_rebuild
 * @property integer $time_rebuild
 * @property string $rebuilded
 * @property integer $watched
 * @property string $file
 */
class Archive extends CActiveRecord
{
    const LIVE = Cam::LIVE;
    const RECORD = Cam::RECORD;
    const MOTION = Cam::MOTION;
    const TIMELAPSE = 'timelapse';

    public $h1;
    public $h2;

    public $day;

    public function init(){
        // todo: разобрать этот мусор
        /** @var CWebApplication $app */
        $app = Yii::app();
        if(isset($app->session[$this->tableName().'_search_h1']))
            $this->h1 = $app->session[$this->tableName().'_search_h1'];
        else
            $this->h1 = 0;
        if(isset($app->session[$this->tableName().'_search_h2']))
            $this->h2 = $app->session[$this->tableName().'_search_h2'];
        else
            $this->h2 = 24;
        //throw new CException(Yii::app()->session[$this->tableName().'_search_h2']);
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'archive';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('day', 'safe'),
			array('cam_id', 'required'),
			array('cam_id, date_start, date_end, date_rebuild, time_rebuild, watched', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>4),
			array('rebuilded', 'length', 'max'=>11),
			array('file', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('h1, h2', 'safe', 'on'=>'search'),
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
            'cam'=>array(self::BELONGS_TO, 'Cam', 'cam_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cam_id' => 'Cam',
			'type' => 'Type',
			'date_start' => 'Date Start',
			'date_end' => 'Date End',
			'date_rebuild' => 'Date Rebuild',
			'time_rebuild' => 'Time Rebuild',
			'rebuilded' => 'Rebuilded',
			'watched' => 'Watched',
			'file' => 'File',
            'h1' => 'from',
            'h2' => 'to',
		);
	}

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @param int $y - year
     * @param int $m - month
     * @param int $d - day
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
	public function search($y,$m,$d)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        /** @var CWebApplication $app */
        $app = Yii::app();

        $app->session[$this->tableName().'_search_h1'] = $this->h1;
        $app->session[$this->tableName().'_search_h2'] = $this->h2;
        $start = mktime($this->h1,0,0,$m,$d,$y);
        $end =   mktime($this->h2,0,0,$m,$d,$y);
        $criteria->compare('cam_id',$this->cam_id);
        $criteria->addBetweenCondition('date_start',$start,$end);
        $criteria->addCondition("rebuilded='yes'");
        $criteria->order = 'date_end';

		/*$criteria->compare('id',$this->id);
		$criteria->compare('cam_id',$this->cam_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('date_start',$this->date_start);
		$criteria->compare('date_end',$this->date_end);
		$criteria->compare('date_rebuild',$this->date_rebuild);
		$criteria->compare('time_rebuild',$this->time_rebuild);
		$criteria->compare('rebuilded',$this->rebuilded,true);
		$criteria->compare('watched',$this->watched);
		$criteria->compare('file',$this->file,true);*/

        $dataProvider =new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));

		return $dataProvider;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Archive the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function pathMp4(){
        if(strpos($this->file, '.mp4') === false)
            return realpath($this->file.'.mp4');
        else
            return realpath($this->file);
    }

    public function pathAvi(){
        return realpath($this->file.'.avi');
    }

}
