<?php

/**
 * This is the model class for table "estados".
 *
 * The followings are the available columns in table 'estados':
 * @property string $id
 * @property string $protocolo_id
 * @property string $estado
 * @property string $justificativa
 * @property integer $usuario
 * @property string $datahora
 */
class Estado extends CActiveRecord
{
	const NORMAL='0';
	const ARQUIVADO='1';
	const EXTERNO='2';
	const APENSADO='3';
	const CANCELADO='9';
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'estado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('protocolo_id, estado, justificativa, usuario, datahora', 'required'),
			array('usuario', 'numerical', 'integerOnly'=>true),
			array('protocolo_id, estado', 'length', 'max'=>10),
			array('justificativa', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, protocolo_id, estado, justificativa, usuario, datahora', 'safe', 'on'=>'search'),
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
			'us'=>array(self::BELONGS_TO,'User','usuario'),
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
			'estado' => 'Nova Situação',
			'estadoText' => 'Situação',
			'justificativa' => 'Justificativa',
			'usuario' => 'Usuario',
			'usuarioText' => 'Usuário',
			'datahora' => 'Alteração',
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
		$criteria->compare('protocolo_id',$this->protocolo_id,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('justificativa',$this->justificativa,true);
		$criteria->compare('usuario',$this->usuario);
		$criteria->compare('datahora',$this->datahora,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Estados the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getEstadoOptions()
	{
		return array(
			Estado::NORMAL=>'Normal',
			Estado::ARQUIVADO=>'Arquivado',
			Estado::EXTERNO=>'Tramitação Externa',
			Estado::APENSADO=>'Apensado',
			Estado::CANCELADO=>'Cancelado',
		);
	}
	
	public function getEstadoText()
	{
		$options=$this->estadoOptions;
		return $options[$this->estado];
	}
	
	public function getUsuarioText()
	{
		$profile = $this->us->profile;
		return $profile->first_name.' '.$profile->last_name.' ('.$profile->unidade->nome.')';
	}
	
	protected function beforeSave()
	{
		if ($this->isNewRecord)
		{
			$this->usuario=Yii::app()->getModule('user')->user()->id;
			$this->datahora=new CDbExpression('NOW()');
		}
	
		return parent::beforeSave();
	}
}
