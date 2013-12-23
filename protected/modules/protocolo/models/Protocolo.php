<?php

/**
 * This is the model class for table "protocolo".
 *
 * The followings are the available columns in table 'protocolo':
 * @property string $id
 * @property string $documento
 * @property string $origem
 * @property string $datahora
 * @property string $usuario
 * @property string $observacao
 */
class Protocolo extends CActiveRecord
{	
	private $_destino = null;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'protocolo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('documento, origem, assunto', 'required'),
			array('documento', 'length', 'max'=>50),
			array('origem, observacao', 'length', 'max'=>100),
			array('usuario', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('protocolo, documento, assunto, origem, estado', 'safe', 'on'=>'search'),
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
			'us'=>array(self::BELONGS_TO,'User','usuario'),
			'un'=>array(self::BELONGS_TO,'Unidade','unidade'),
			'vinculo'=>array(self::HAS_ONE,'Vinculo','vinculo','condition'=>'vinculo.desvinculado is NULL'),
			'vinculos'=>array(self::HAS_MANY,'Vinculo','protocolo','condition'=>'vinculos.desvinculado is NULL'),
			'vinculado'=>array(self::HAS_ONE,'Protocolo',array('protocolo'=>'id'),'through'=>'vinculo'),
			'tramitacao'=>array(self::HAS_ONE,'Tramitacao','protocolo_id','condition'=>'de_datahora is NULL'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Protocolo',
			'documento' => 'Documento',
			'origem' => 'Interessado',
			'datahora' => 'Protocolado',
			'usuarioText' => 'Protocolista',
			'unidadeText' => 'Unidade',
			'observacao' => 'Observação',
			'estado' => 'Situação',
			'estadoText' => 'Situação',
			'vinculado.protocolo' => 'Apensado',
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

		$criteria->compare('protocolo',$this->protocolo,true);
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('assunto',$this->assunto,true);
		$criteria->compare('origem',$this->origem,true);
		$criteria->compare('estado',$this->estado,false);
		$criteria->order='datahora desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPendentes()
	{
		$criteria=new CDbCriteria;
		$criteria->join='LEFT JOIN tramitacao t2 ON t.id = t2.protocolo_id';
		$criteria->addCondition('t2.protocolo_id is null');
		
		$criteria->compare('estado','<>1'); //Arquivado
		$criteria->compare('estado','<>3'); //Apensado
		$criteria->compare('estado','<>9');
		$criteria->compare('unidade',Yii::app()->getModule('user')->user()->profile->unidade->id);
		$criteria->compare('protocolo',$this->protocolo,true);
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('assunto',$this->assunto,true);
		$criteria->compare('datahora',$this->datahora,true);
		
		$sort = new CSort();
		$sort->defaultOrder=array('protocolo'=>CSort::SORT_ASC);
		$sort->attributes = array(
				'_protocolo'=>array(
						'asc'=>'p.protocolo',
						'desc'=>'p.protocolo desc',
				),
				'*',
		);
	
		return new CActiveDataProvider($this, array('criteria'=>$criteria,'sort'=>$sort));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Protocolo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
	{
		if ($this->isNewRecord)
		{
			$unidade=Unidade::model()->findByPk(Yii::app()->getModule('user')->user()->profile->unidade_id);
			$this->protocolo=$unidade->novoProtocolo;
			$this->usuario=Yii::app()->getModule('user')->user()->id;
			$this->unidade=Yii::app()->getModule('user')->user()->profile->unidade_id;
			$this->datahora=new CDbExpression('NOW()');
			$unidade->protocolo+=1;
			$unidade->save();
		}
		
		return parent::beforeSave();
	}
	
	public function getUsuarioText()
	{
		$profile = $this->us->profile;
		return $profile->first_name.' '.$profile->last_name.' ('.$profile->unidade->nome.')';
	}
	
	public function getUnidadeText()
	{
		return $this->un->id.' - '.$this->un->nome;
	}
	
	public function getDestino()
	{
		return $this->_destino;
	}
	
	public function setDestino($destino)
	{
		$this->_destino=$destino;
	}
	
	public function getEstadoText()
	{
		$options=Estado::model()->estadoOptions;
		return $options[$this->estado];
	}
	
	public function getReadOnly()
	{
		if (Yii::app()->user->isGuest)
			return true;
		
		$unidade=Yii::app()->getModule('user')->user()->profile->unidade_id;
		
		$ultimaTramitacao=new CDbCriteria;
		$ultimaTramitacao->join='LEFT JOIN tramitacao t2 ON t.id < t2.id and t.protocolo_id = t2.protocolo_id';
		$ultimaTramitacao->addCondition('t2.id is NULL');
		$ultimaTramitacao->compare('t.protocolo_id', $this->id, false);
		
		$tramitacao=Tramitacao::model()->find($ultimaTramitacao);
		
		if(is_null($tramitacao))
			return $unidade!=$this->un->id;
		elseif(!isset($tramitacao->destino) || !isset($tramitacao->de_datahora))
			return $unidade!=$tramitacao->origem;
		else
			return $unidade!=$tramitacao->destino;
	}
}
