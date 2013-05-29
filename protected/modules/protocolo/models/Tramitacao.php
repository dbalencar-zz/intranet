<?php

/**
 * This is the model class for table "tramitacao".
 *
 * The followings are the available columns in table 'tramitacao':
 * @property string $id
 * @property integer $destino
 * @property string $datahora
 * @property integer $usuario
 * @property string $estado
 * @property string $despacho
 */
class Tramitacao extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tramitacao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('protocolo_id, destino', 'required'),
			array('protocolo_id, destino', 'numerical', 'integerOnly'=>true),
			array('despacho', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('protocolo_id, origem, or_usuario, or_datahora, destino, despacho', 'safe', 'on'=>'search'),
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
			'pr'=>array(self::BELONGS_TO,'Protocolo','protocolo_id'),
			'or'=>array(self::BELONGS_TO,'Unidade','origem'),
			'de'=>array(self::BELONGS_TO,'Unidade','destino'),
			'us'=>array(self::BELONGS_TO,'User','or_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'protocolo_id' => 'Protocolo',
			'origem' => 'Origem',
			'or.sigla' => 'Origem',
			'or_usuario' => 'Usuário',
			'or_datahora' => 'Data/Hora',
			'destino' => 'Destino',
			'de.sigla' => 'Destino',
			'de_usuario' => 'Usuário',
			'de_datahora' => 'Data/Hora',
			'arquivado' => 'Arquivado',
			'despacho' => 'Despacho',
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

		$criteria->compare('protocolo_id',$this->protocolo_id,true);
		$criteria->compare('origem',$this->origem);
		$criteria->compare('or_usuario',$this->or_usuario);
		$criteria->compare('or_datahora',$this->or_datahora,true);
		$criteria->compare('destino',$this->destino);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('despacho',$this->despacho,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tramitacao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
	{
		if ($this->isNewRecord)
		{
			$this->origem=Yii::app()->getModule('user')->user()->profile->unidade->id;
			$this->or_usuario=Yii::app()->getModule('user')->user()->id;
			$this->or_datahora=new CDbExpression('NOW()');
		}
		
		return parent::beforeSave();
	}
	
	public function getUsuarioText()
	{
		$profile = $this->us->profile;
		return $profile->first_name.' '.$profile->last_name;
	}
}
