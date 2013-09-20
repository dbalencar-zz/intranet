<?php

class DefaultController extends RController
{
	public function filters()
	{
		return array(
			'rights',
		);
	}
	
	public function allowedActions()
	{
		return 'index';
	}
	
	public function actionIndex()
	{
		if(Yii::app()->user->checkAccess('Recepcionista'))
		{
			$this->redirect(array('visita/create'));
		}
		else
			$this->render('index');
	}
}