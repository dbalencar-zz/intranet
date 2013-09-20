<?php

/**
 * This is the model class for table "por_visita".
 *
 * The followings are the available columns in table 'por_visita':
 * @property string $id
 * @property string $visitante_id
 * @property integer $cracha
 * @property string $origem
 * @property string $destino
 * @property string $entrada
 * @property string $saida
 * @property string $observacao
 *
 * The followings are the available model relations:
 * @property Visitante $visitante
 */
class Visita extends CActiveRecord
{
	public $_nome;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'por_visita';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('visitante_id, cracha, origem, destino, entrada', 'required'),
			array('cracha', 'numerical', 'integerOnly'=>true),
			array('visitante_id', 'length', 'max'=>10),
			array('origem, destino', 'length', 'max'=>25),
			array('saida, observacao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cracha, visitante_id, _nome, origem, destino, entrada, saida, observacao', 'safe', 'on'=>'search'),
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
			'visitante' => array(self::BELONGS_TO, 'Visitante', 'visitante_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Ordem',
			'visitante_id' => 'Visitante',
			'cracha' => 'Crachá',
			'origem' => 'Origem',
			'destino' => 'Destino',
			'entrada' => 'Entrada',
			'saida' => 'Saída',
			'observacao' => 'Observação',
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

		$criteria->compare('id', $this->id);
		$criteria->compare('cracha',$this->cracha);
		$criteria->compare('visitante_id',$this->visitante_id);
		$criteria->compare('origem',$this->origem,true);
		$criteria->compare('destino',$this->destino,true);
		$criteria->compare('entrada',$this->entrada,true);
		$criteria->compare('saida',$this->saida,true);
		$criteria->compare('observacao',$this->observacao,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPendentes()
	{
		$criteria=new CDbCriteria;
		$criteria->with='visitante';
		$criteria->addCondition('saida is null');

		$criteria->compare('cracha',$this->cracha);
		$criteria->compare('visitante.nome',$this->_nome,true);
		$criteria->compare('origem',$this->origem,true);
		$criteria->compare('destino',$this->destino,true);
		$criteria->compare('entrada',$this->entrada,true);
		
		$sort=new CSort();
		$sort->attributes=array(
			'defaultOrder'=>'visitante.nome',
			'_nome'=>array(
				'asc'=>'visitante.nome',
				'desc'=>'visitante.nome desc',
			),
			'*',
		);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Visita the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
