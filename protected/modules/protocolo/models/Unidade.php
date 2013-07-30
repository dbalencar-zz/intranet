<?php

/**
 * This is the model class for table "unidade".
 *
 * The followings are the available columns in table 'unidade':
 * @property string $id
 * @property string $sigla
 * @property string $nome
 * @property integer $pai
 */
class Unidade extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'unidade';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sigla, nome, protocolo', 'required'),
			array('pai, protocolo', 'numerical', 'integerOnly'=>true),
			array('sigla', 'length', 'max'=>10),
			array('nome', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sigla, nome, pai', 'safe', 'on'=>'search'),
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
			'children'=>array(self::HAS_MANY,'unidade','pai','order'=>'nome'),
			'pai'=>array(self::HAS_ONE,'unidade','pai'),
			'profiles'=>array(self::HAS_MANY, 'Profile', 'unidade_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sigla' => 'Sigla',
			'nome' => 'Nome',
			'pai' => 'Pai',
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
		$criteria->compare('sigla',$this->sigla,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('pai',$this->pai);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Unidade the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function listAll($origem=null,$restrito=false)
	{
		$criteria=new CDbCriteria();
		$criteria->order='nome';
		if ($origem==23) $criteria->compare('id','<>'.$origem);
		elseif ($restrito) $criteria->compare('id',$origem);
		else $criteria->compare('id','<>'.$origem);
		return CHtml::listData($this->findAll($criteria),'id','nome');
	}
	
	public function getNovoProtocolo()
	{
		return date("y",time()).'.'.sprintf('%03d', $this->id).'.'.sprintf('%07d', $this->protocolo+1);
	}
}
