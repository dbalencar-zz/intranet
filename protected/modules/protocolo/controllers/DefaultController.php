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
		return 'index, pesquisar, protocolo, tramitacao, justificativa, suggestedTags';
	}

	public function actionIndex()
	{
		if(Yii::app()->user->checkAccess('Recebedor'))
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
		$tramitacao=new Tramitacao('search');
		//$tramitacao->unsetAttributes();

		if(isset($_GET['Tramitacao']))
			$tramitacao->attributes=$_GET['Tramitacao'];
		
		$protocolo=new Protocolo('search');		
		//$protocolo->unsetAttributes();
		
		if(isset($_GET['Protocolo']))
			$protocolo->attributes=$_GET['Protocolo'];
		
		$this->render('inbox', array(
			'tramitacao'=>$tramitacao,
			'protocolo'=>$protocolo,
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
	
	public function actionTramitar($id)
	{
		$model=new Tramitacao();
	
		$model->protocolo_id=$id;
	
		if(isset($_POST['Tramitacao']))
		{
			$model->attributes=$_POST['Tramitacao'];
			
			$transaction=Yii::app()->db->beginTransaction();
			
			try
			{
				foreach($model->pr->vinculos as $n=>$vinculo)
				{
					$vin_tram=new Tramitacao();
					$vin_tram->attributes=$model->attributes;
					$vin_tram->protocolo_id=$vinculo->vinculo;
					$vin_tram->save();
				}
			}
			catch (Exception $e)
			{
				$transaction->rollBack();
			}
			
			if($model->save())
			{
				$transaction->commit();
				$this->redirect(array('inbox','id'=>$model->protocolo_id));
			}
			else $transaction->rollback();
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
			
			if($model->save())				
				$this->redirect(array('protocolo','id'=>$model->id));
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
	
	public function actionCancelarDestinar($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$transaction=Yii::app()->db->beginTransaction();
			
			try
			{
				$protocolo=$this->loadProtocolo($id);
			
				foreach ($protocolo->vinculos as $n=>$vinculo)
				{
					$vinculo->vin->tramitacao->delete();
				}
			
				if($protocolo->tramitacao->delete())
				{
					$transaction->commit();
					$this->redirect(array('protocolo','id'=>$id));
				}
				else $transaction->rollBack();
			}
			catch (Exception $e)
			{
				$transaction->rollBack();
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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
	
		$tramitacoes=new CDbCriteria();
		$tramitacoes->compare('protocolo_id',$id);
		$tramitacoes->order='or_datahora desc';
		$tramitacoesProvider=new CActiveDataProvider('Tramitacao', array('criteria'=>$tramitacoes));
		
		$vinculos=new CDbCriteria();
		$vinculos->compare('protocolo', $protocolo->id);
		$vinculos->addCondition('desvinculado is NULL');
		$vinculosProvider=new CActiveDataProvider('Vinculo', array('criteria'=>$vinculos));
		
		$estados=new CDbCriteria();
		$estados->compare('protocolo_id', $protocolo->id);
		$estados->order='datahora desc';
		$estadosProvider=new CActiveDataProvider('Estado', array('criteria'=>$estados));
	
		$this->render('protocolo',array(
				'model'=>$protocolo,
				'vinculosProvider'=>$vinculosProvider,
				'tramitacoesProvider'=>$tramitacoesProvider,
				'estadosProvider'=>$estadosProvider,
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
	
	public function loadVinculo($id)
	{
		$model=Vinculo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadEstado($id)
	{
		$model=Estado::model()->findByPk($id);
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
		$tramitacao=$this->loadTramitacao($id);
		
		$criteria=new CDbCriteria();
		$criteria->compare('t.protocolo', $tramitacao->protocolo_id);
		$criteria->addCondition('desvinculado is NULL');
		
		$vinculos=Vinculo::model()->with('vin')->findAll($criteria);
		
		$this->layout='protocolo';
		$this->render('imprimir',array(
			'model'=>$tramitacao,
			'vinculos'=>$vinculos,
		));
	}
	
	public function actionJustificativa($id)
	{
		$model=$this->loadEstado($id);
		
		$this->render('justificativa',array(
				'model'=>$model,
		));
	}
	
	public function actionEstado($protocolo,$estado)
	{				
		$model=new Estado();
		
		if(isset($_POST['Estado']))
		{
			$model->attributes=$_POST['Estado'];
			$model->usuario=Yii::app()->getModule('user')->user()->id;
			$model->datahora=new CDbExpression('NOW()');
			
			$transaction=Yii::app()->db->beginTransaction();
			
			try
			{	
				if($model->save())
				{
					$protocolo=$this->loadProtocolo($model->protocolo_id);
					$protocolo->estado=$model->estado;
					
					if($protocolo->save())
					{
						$transaction->commit();
						$this->redirect(array('protocolo', 'id'=>$protocolo->id));
					}
				}
			}
			catch (Exception $e)
			{
				$transaction->rollBack();
			}
		}
		
		$model->protocolo_id=$protocolo;
		$model->estado=$estado;
		
		switch ($this->loadProtocolo($model->protocolo_id)->estado)
		{
			case Estado::NORMAL:
				switch ($estado)
				{
					case Estado::ARQUIVADO:
						$estado='Arquivar';
						break;
					case Estado::EXTERNO:
						$estado='Externar';
						break;
					case Estado::CANCELADO:
						$estado='Cancelar';
						break;
				}
				break;
			case Estado::ARQUIVADO:
				$estado='Desarquivar';
				break;
			case Estado::EXTERNO:
				$estado='Reinternar';
				break;
		}
		
		$this->render('estado',array(
			'model'=>$model,
			'estado'=>$estado,
		));
	}
	
	public function actionVincular()
	{		
		$model = new Vinculo();
		$this->performAjaxValidationVinculo($model);
		
		if(Yii::app()->request->isAjaxRequest)
		{
			if(isset($_POST['Vinculo']))
			{
				$model->attributes=$_POST['Vinculo'];
				
				if(($model->vinculo===''))
					exit(json_encode(array('status'=>'fail','error'=>'<li>Protocolo deve ser preenchido!</li>')));
				
				$protocolo=Protocolo::model()->findByAttributes(array('protocolo'=>$model->vinculo));
				
				if(is_null($protocolo))
					exit(json_encode(array('status'=>'fail','error'=>'<li>Protocolo não encontrado!</li>')));

				if($model->protocolo===$protocolo->id)
					exit(json_encode(array('status'=>'fail','error'=>'<li>Protocolo não pode ser apensado a ele mesmo!</li>')));

				$criteria=new CDbCriteria();
				$criteria->compare('vinculo', $protocolo->id);
				$criteria->compare('protocolo', $model->protocolo);
				$criteria->addCondition('desvinculado is NULL');
				
				if(!is_null(Vinculo::model()->find($criteria)))
					exit(json_encode(array('status'=>'fail','error'=>'<li>Protocolo já apensado a este Protocolo!</li>')));
				
				$criteria=new CDbCriteria();
				$criteria->compare('vinculo', $protocolo->id);
				$criteria->addCondition('desvinculado is NULL');
				$vinculo=Vinculo::model()->find($criteria);
				if(!is_null($vinculo))
					exit(json_encode(array('status'=>'fail','error'=>'<li>Protocolo já apensado a outro Protocolo ('.$vinculo->pro->protocolo.')!</li>')));			
					
				$model->vinculo=$protocolo->id;
				$model->vinculado=new CDbExpression('NOW()');
				$model->vin_usuario=Yii::app()->getModule('user')->user()->id;
				
				$transaction=Yii::app()->db->beginTransaction();
				try
				{
					if ($model->save())
					{
						$protocolo->estado=Estado::APENSADO;
						if ($protocolo->save())
						{
							$transaction->commit();
							exit(json_encode(array('status'=>'success')));
						}
					}
					else
					{
						exit(json_encode(array('status'=>'fail','error'=>CHtml::errorSummary($model))));
					}
				}
				catch (Exception $e)
				{
					$transaction->rollBack();
				}
			} 
		}
	}
	
	protected function performAjaxValidationVinculo($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vinculo-form')
		{
			echo CActiveForm::validate($model,array('vinculo'));
			Yii::app()->end();
		}
	}
	
	public function actionDesvincular($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model=$this->loadVinculo($id);
			$model->des_usuario=Yii::app()->getModule('user')->user()->id;
			$model->desvinculado=new CDbExpression('NOW()');
			
			$transaction=Yii::app()->db->beginTransaction();
			try
			{
				if ($model->save())
				{
					$protocolo=$model->vin;
					$protocolo->estado=Estado::NORMAL;
					
					if ($protocolo->save())
						$transaction->commit();
				}
			}
			catch (Exception $e)
			{
				$transaction->rollBack();
			}
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
}