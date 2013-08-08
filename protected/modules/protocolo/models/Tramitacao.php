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
	public $_protocolo;
	
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
			array('_protocolo, origem, or_usuario, or_datahora, destino, despacho', 'safe', 'on'=>'search'),
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
			'usor'=>array(self::BELONGS_TO,'User','or_usuario'),
			'usde'=>array(self::BELONGS_TO,'User','de_usuario'),
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
			'or.nome' => 'Origem',
			'or_usuario' => 'Tramitador',
			'usuarioOrigemText' => 'Tramitador',
			'or_datahora' => 'Tramitado',
			'destino' => 'Destino',
			'de.sigla' => 'Destino',
			'de.nome' => 'Destino',
			'de_usuario' => 'Recebedor',
			'usuarioDestinoText' => 'Recebedor',
			'de_datahora' => 'Recebido',
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

		$criteria->compare('pr.protocolo',$this->protocolo,true);
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
	
	public function searchPendentes()
	{
		$lastMoves=new CDbCriteria;
		$lastMoves->join='LEFT JOIN tramitacao t2 ON t.id < t2.id and t.protocolo_id = t2.protocolo_id';
		$lastMoves->addCondition('t2.id is NULL');
	
		$arquivados=new CDbCriteria;
		$arquivados->join='LEFT JOIN protocolo p ON t.protocolo_id = p.id';
		$arquivados->compare('p.arquivado','<>1');
	
		$arquivados->mergeWith($lastMoves);
	
		$pendentes=new CDbCriteria;
		$pendentes->compare('t.origem', Yii::app()->getModule('user')->user()->profile->unidade->id, false, 'AND');
		$pendentes->addCondition('t.de_datahora is NULL');
		$pendentes->compare('t.destino',Yii::app()->getModule('user')->user()->profile->unidade->id, false, 'OR');
	
		$pendentes->mergeWith($arquivados);
	
		$pendentes->compare('p.protocolo',$this->_protocolo,true);
		$pendentes->compare('t.origem',$this->origem);
		$pendentes->compare('t.or_datahora',$this->or_datahora,true);
		$pendentes->compare('t.destino',$this->destino);
		$pendentes->compare('t.de_datahora',$this->de_datahora,true);
	
		//$pendentes->order='t.or_datahora desc, t.de_datahora desc';
	
		$sort = new CSort();
		$sort->attributes = array(
			'defaultOrder'=>'t.or_datahora desc, t.de_datahora desc',
			'_protocolo'=>array(
				'asc'=>'p.protocolo',
				'desc'=>'p.protocolo desc',
			),
			'*',
		);
		
		return new CActiveDataProvider($this, array('criteria'=>$pendentes,'sort'=>$sort));
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
	
	public function getUsuarioOrigemText()
	{
		if(!isset($this->usor))
			return null;
		
		$profile = $this->usor->profile;
		return $profile->first_name.' '.$profile->last_name.' ('.$profile->unidade->nome.')';
	}
	
	public function getUsuarioDestinoText()
	{
		if(!isset($this->usde))
			return null;
		
		$profile = $this->usde->profile;
		return $profile->first_name.' '.$profile->last_name.' ('.$profile->unidade->nome.')';
	}
}
