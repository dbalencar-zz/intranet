<?php

/**
 * This is the model class for table "vinculo".
 *
 * The followings are the available columns in table 'vinculo':
 * @property integer $id
 * @property integer $protocolo
 * @property integer $vinculo
 * @property string $vinculado
 * @property integer $vin_usuario
 * @property string $desvinculado
 * @property integer $des_usuario
 */
class Vinculo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'vinculo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('protocolo, vinculo, vinculado, vin_usuario', 'required'),
			array('protocolo, vinculo, vin_usuario, des_usuario', 'numerical', 'integerOnly'=>true),
			array('desvinculado', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, protocolo, vinculo, vinculado, vin_usuario, desvinculado, des_usuario', 'safe', 'on'=>'search'),
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
			'pro'=>array(self::BELONGS_TO,'Protocolo','protocolo'),
			'vin'=>array(self::BELONGS_TO,'Protocolo','vinculo'),
			'vus'=>array(self::BELONGS_TO,'User','vin_usuario'),
			'dus'=>array(self::BELONGS_TO,'User','des_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'protocolo' => 'Protocolo',
			'vinculo' => 'Protocolo Apenso',
			'vinculado' => 'Apensado',
			'vin_usuario' => 'Apensador',
			'vinculadorText' => 'Apensador',
			'desvinculado' => 'Desapensado',
			'des_usuario' => 'Desapensador',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('protocolo',$this->protocolo);
		$criteria->compare('vinculo',$this->vinculo);
		$criteria->compare('vinculado',$this->vinculado,true);
		$criteria->compare('vin_usuario',$this->vin_usuario);
		$criteria->compare('desvinculado',$this->desvinculado,true);
		$criteria->compare('des_usuario',$this->des_usuario);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vinculo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getVinculadorText()
	{
		$profile = $this->vus->profile;
		return $profile->first_name.' '.$profile->last_name.' ('.$profile->unidade->nome.')';
	}
}
