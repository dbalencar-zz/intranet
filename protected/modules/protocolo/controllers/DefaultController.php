<?php

class DefaultController extends RController
{
	public $defaultAction='pendentes';
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	
	public function filters()
	{
		return array(
			'rights',
		);
	}
	
	public function allowedActions()
	{
		return 'index, admin, view, tramitacao, suggestedTags';
	}

	public function actionPendentes()
	{
		
		$lastMoves=new CDbCriteria;
		$lastMoves->join='LEFT JOIN tramitacao t2 ON t.id < t2.id and t.protocolo_id = t2.protocolo_id';
		$lastMoves->addCondition('t2.id is NULL');
		
		$pendentes=new CDbCriteria;
		$pendentes->compare('t.origem', Yii::app()->getModule('user')->user()->profile->unidade->id, false, 'AND');
		$pendentes->addCondition('t.de_datahora is NULL');
		$pendentes->compare('t.destino',Yii::app()->getModule('user')->user()->profile->unidade->id, false, 'OR');

		$pendentes->mergeWith($lastMoves);
				
		$pendentes->order='t.de_datahora desc';
		$pendentesProvider=new CActiveDataProvider('Tramitacao', array('criteria'=>$pendentes));
		
		$this->render('pendentes', array(
			'pendentesProvider'=>$pendentesProvider,
		));
	}
	
	public function actionFile()
	{
		$this->render('file');
	}
	
	public function actionReceber($id)
	{
		$model=$this->loadTramitacao($id);
		$model->de_usuario=Yii::app()->getModule('user')->user()->id;
		$model->de_datahora=new CDbExpression('NOW()');
		$model->save();
		
		$this->redirect(array('pendentes'));
	}
	
	public function actionMove($id)
	{
		$model=new Tramitacao();
	
		$model->protocolo_id=$id;
	
		if(isset($_POST['Tramitacao']))
		{
			$model->attributes=$_POST['Tramitacao'];
			if($model->save())
				$this->redirect(array('default/view','id'=>$model->protocolo_id));
		}
	
		$this->render('move',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$protocolo=$this->loadProtocolo($id);
		
		$criteria=new CDbCriteria();
		$criteria->compare('protocolo_id',$id);
		$criteria->order='or_datahora desc';
		$dataProvider=new CActiveDataProvider('Tramitacao', array('criteria'=>$criteria));
		
		$this->render('view',array(
			'model'=>$protocolo,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
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
					$this->redirect(array('view','id'=>$model->id));
				}
			}
			$transaction->rollBack();
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadProtocolo($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Protocolo']))
		{
			$model->attributes=$_POST['Protocolo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadProtocolo($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Protocolo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Protocolo']))
			$model->attributes=$_GET['Protocolo'];

		$this->render('admin',array(
			'model'=>$model,
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
	
	public function actionPrint($id)
	{
		$this->layout='protocolo';
		$this->render('print',array(
				'model'=>$this->loadTramitacao($id),
		));
	}
}