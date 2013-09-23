<?php

class VisitaController extends RController
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
		$filtro=new Visita('search');
		
		$filtro->unsetAttributes();
		if(isset($_GET['Visita']))
			$filtro->attributes=$_GET['Visita'];
		
		$model=new Visita;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Visita']))
		{
			$model->attributes=$_POST['Visita'];
			$model->entrada=new CDbExpression('NOW()');
			$model->ent_user_id=Yii::app()->getModule('user')->user()->id;
			if($model->save())
				$this->redirect(array('create'));
		}

		$this->render('create',array(
			'model'=>$model,
			'filtro'=>$filtro,
		));
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

		if(isset($_POST['Visita']))
		{
			$model->attributes=$_POST['Visita'];
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
		$model=$this->loadModel($id);
		$model->saida=new CDbExpression('NOW()');
		$model->sai_user_id=Yii::app()->getModule('user')->user()->id;
		$model->save();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('visita/create'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Visita');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Visita('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Visita']))
			$model->attributes=$_GET['Visita'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Visita the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Visita::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Visita $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='visita-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionRelatorio()
	{		
		$criteria=new CDbCriteria();
		
		$criteria->order='entrada';
		$criteria->with='visitante';
		
		$inicio=$_POST['inicio'];
		$fim=$_POST['fim'];
		if($inicio!='')
			if($fim!='')
				$criteria->addBetweenCondition(
					'entrada',
					Yii::app()->dateFormatter->format('yyyy-MM-dd', CDateTimeParser::parse($inicio,'dd/MM/yyyy')),
					Yii::app()->dateFormatter->format('yyyy-MM-dd 23:59:59', CDateTimeParser::parse($fim,'dd/MM/yyyy'))
				);
			else
				$criteria->addCondition('entrada > STR_TO_DATE("'.$inicio.'", "%d/%m/%Y")');
		elseif($fim!='')
			$criteria->addCondition('entrada < STR_TO_DATE("'.$fim.'", "%d/%m/%Y")');
	
		$models=Visita::model()->findAll($criteria);
	
		$this->layout='//layouts/relatorio';
		$this->render('rel_visitas', array(
			'inicio'=>$_POST['inicio'],
			'fim'=>$_POST['fim'],
			'models'=>$models,
		));
	}
}
