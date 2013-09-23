<?php

class VisitanteController extends RController
{
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Visitante;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Visitante']))
		{
			$model->attributes=$_POST['Visitante'];
			$model->user_id=Yii::app()->getModule('user')->user()->id;
			$model->datahora=new CDbExpression('NOW()');
			if($model->save())
			{
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
						'status'=>'success',
						'div'=>'Visitante cadastrado com sucesso',
						'label'=>$model->nome,
						'value'=>$model->id,
					));
					exit;
				}
				else 
					$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		if (Yii::app()->request->isAjaxRequest)
		{
			echo CJSON::encode(array(
				'status'=>'failure',
				'div'=>$this->renderPartial('_form', array('model'=>$model), true),
			));
			exit;
		}
		else 
			$this->render('create',array('model'=>$model));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Visitante']))
		{
			$model->attributes=$_POST['Visitante'];
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Visitante');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Visitante('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Visitante']))
			$model->attributes=$_GET['Visitante'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Visitante the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Visitante::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Visitante $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='visitante-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionSearchVisitante()
	{
		$res =array();

		if (isset($_GET['term']))
		{
			$criteria=new CDbCriteria();
			$criteria->addSearchCondition('nome', $_GET['term']);
			
			$models=Visitante::model()->findAll($criteria);
			foreach ($models as $model)
			{
				$res[] = array(
					'label'=>$model->nome,
					'value'=>$model->id,
				);
			}
		}

		echo CJSON::encode($res);
		Yii::app()->end();
	}
	
	public function actionRelatorio()
	{		
		$criteria=new CDbCriteria();
		
		$criteria->distinct=TRUE;
		$criteria->order='nome';
		
		$models=Visitante::model()->findAll($criteria);
		
		$this->layout='//layouts/relatorio';
		$this->render('rel_visitantes', array(
			'models'=>$models,
		));
	}
}
