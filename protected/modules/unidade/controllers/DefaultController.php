<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{	
		$data=$this->getData(Unidade::model()->findByPk('1'));
        $this->render('index',array('data'=>array($data)));
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
			'text'=>$unidade->sigla,
			'hasChildren'=>isset($children),
			'children'=>$children,
		);
	}
}