<?php

class DefaultController extends RController
{
	public $defaultAction='index';

	public $layout='//layouts/column2';

	public function filters()
	{
		return array(
			'rights',
		);
	}
	
	public function allowedActions()
	{
		return 'index, pesquisar, protocolo, tramitacao, suggestedTags';
	}

	public function actionIndex()
	{
		if(Yii::app()->user->checkAccess('Tramitador'))
		{
			$this->redirect(array('inbox'));
		}
		else
		{
			$this->redirect(array('pesquisar'));
		}
	}
	
	public function actionInbox()
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
				
		$pendentes->order='t.or_datahora desc';
		$pendentesProvider=new CActiveDataProvider('Tramitacao', array('criteria'=>$pendentes));
		
		$this->render('inbox', array(
			'pendentesProvider'=>$pendentesProvider,
		));
	}
	
	public function actionReceber($id)
	{
		$model=$this->loadTramitacao($id);
		$model->de_usuario=Yii::app()->getModule('user')->user()->id;
		$model->de_datahora=new CDbExpression('NOW()');
		$model->save();
		
		$this->redirect(array('inbox'));
	}
	
	public function actionArquivar($id)
	{
		$model=$this->loadProtocolo($id);
		$model->arquivado=true;		
		$model->ar_usuario=Yii::app()->getModule('user')->user()->id;
		$model->ar_datahora=new CDbExpression('NOW()');
		$model->save();
	
		$this->redirect(array('inbox'));
	}
	
	public function actionTramitar($id)
	{
		$model=new Tramitacao();
	
		$model->protocolo_id=$id;
	
		if(isset($_POST['Tramitacao']))
		{
			$model->attributes=$_POST['Tramitacao'];
			if($model->save())
				$this->redirect(array('inbox','id'=>$model->protocolo_id));
		}
	
		$this->render('tramitar',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionProtocolar()
	{
		$model=new Protocolo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Protocolo']))
		{
			$model->attributes=$_POST['Protocolo'];
			$model->destino=$_POST['Protocolo']['destino'];
			
			$transaction=Yii::app()->db->beginTransaction();
			if($model->save())
			{
				$tramitacao=new Tramitacao();
				$tramitacao->protocolo_id=$model->id;
				$tramitacao->origem=Yii::app()->getModule('user')->user()->profile->unidade_id;
				$tramitacao->or_usuario=$model->usuario;
				$tramitacao->or_datahora=$model->datahora;
				$tramitacao->destino=$model->destino;
				
				if($tramitacao->save())
				{
					$transaction->commit();				
					$this->redirect(array('protocolo','id'=>$model->id));
				}
			}
			$transaction->rollBack();
		}

		$this->render('protocolar',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionDestinar($id)
	{
		$model=$this->loadTramitacao($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tramitacao']))
		{
			$model->attributes=$_POST['Tramitacao'];
			$model->or_usuario=Yii::app()->getModule('user')->user()->id;
			if($model->save())
				$this->redirect(array('inbox'));
		}

		$this->render('destinar',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionPesquisar()
	{
		$model=new Protocolo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Protocolo']))
			$model->attributes=$_GET['Protocolo'];

		$this->render('pesquisar',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionProtocolo($id)
	{
		$protocolo=$this->loadProtocolo($id);
	
		$criteria=new CDbCriteria();
		$criteria->compare('protocolo_id',$id);
		$criteria->order='or_datahora desc';
		$dataProvider=new CActiveDataProvider('Tramitacao', array('criteria'=>$criteria));
	
		$this->render('protocolo',array(
				'model'=>$protocolo,
				'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionTramitacao($id)
	{
		$model=$this->loadTramitacao($id);
	
		$this->render('tramitacao',array(
				'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Protocolo the loaded model
	 * @throws CHttpException
	 */
	public function loadProtocolo($id)
	{
		$model=Protocolo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadTramitacao($id)
	{
		$model=Tramitacao::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Protocolo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='protocolo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionImprimir($id)
	{
		$this->layout='protocolo';
		$this->render('imprimir',array(
				'model'=>$this->loadTramitacao($id),
		));
	}
}