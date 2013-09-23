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
		$this->redirect(array('visita/create'));
	}
}