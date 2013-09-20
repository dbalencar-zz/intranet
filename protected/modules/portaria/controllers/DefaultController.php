<?php

class DefaultController extends RController
{
	public function filters()
	{
		return array(
				'rights',
		);
	}
	
	public function actionIndex()
	{
		if (Yii::app()->user->isGuest)
			$this->render('index');
		else 
			$this->redirect(array('visita/create'));
	}
}