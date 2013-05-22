<?php

class DefaultController extends RController
{
	public $layout='//layouts/column2';
	
	private $_model;
	
	public function filters()
	{
		return array(
			'rights',
		);
	}
	
	public function allowedActions()
	{
		return 'index, suggestedTags';
	}
	
	public function actionIndex()
	{	
		//$data=$this->getData(Unidade::model()->findByPk('1'));
		$criteria=new CDbCriteria();
		$criteria->addCondition('pai IS NULL');
		$data=$this->getDatas(Unidade::model()->findAll($criteria));
		$unidades=array(
				'id'=>'0',
				'text'=>'Raiz',
				'hasChildren'=>'1',
				'children'=>$data,
		);
		//print_r($unidades); die;
        $this->render('index',array('data'=>array($unidades)));
	}
	
	public function actionCreate()
	{
		$model=new Unidade;
		
		if(isset($_GET['id']))
			$model->pai=$_GET['id'];
	
		// uncomment the following code to enable ajax-based validation
		/*
		 if(isset($_POST['ajax']) && $_POST['ajax']==='unidade-create-form')
		 {
		echo CActiveForm::validate($model);
		Yii::app()->end();
		}
		*/
	
		if(isset($_POST['Unidade']))
		{
			$model->attributes=$_POST['Unidade'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		$this->render('create',array('model'=>$model));
	}
	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		
		if(isset($_POST['Unidade']))
		{
			$model->attributes=$_POST['Unidade'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		$this->render('update',array(
				'model'=>$model,
		));
	}
	
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
	
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}
	
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Unidade::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
		
	protected function getData($unidade)
	{			
		$children=array();
		if(isset($unidade->children))
		{
			foreach ($unidade->children as $n=>$child)
			{
				$children[]=$this->getData($child);
			}
		}
		return array(
			'id'=>$unidade->id,
			'text'=>CHtml::link($unidade->sigla, array('view', 'id'=>$unidade->id)),
			'hasChildren'=>isset($children),
			'children'=>$children,
		);
	}
	
	protected function getDatas($unidades)
	{
		$result=array();
		
		foreach ($unidades as $unidade)
		{
			if(isset($unidade->children))
			{
				$children=$this->getDatas($unidade->children);
			}
			
			$result[]=array(
				'id'=>$unidade->id,
				'text'=>CHtml::link($unidade->sigla, array('view', 'id'=>$unidade->id)),
				'hasChildren'=>isset($children),
				'children'=>$children,
			);
		}
		
		return $result;
	}
}