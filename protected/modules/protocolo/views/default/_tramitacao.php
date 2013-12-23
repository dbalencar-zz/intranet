<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tramitacao-grid',
	'dataProvider'=>$tramitacoesProvider,
	'columns'=>array(
		'or.sigla',
		'or_datahora',
		'de.sigla',
		'de_datahora',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{receber}{view}',
			'buttons'=>array(
				'view'=>array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/exibir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/tramitacao", array("id"=>$data->id))',
				),
				'receber'=>array(
					'label'=>'Receber',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/receber.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/receber", array("id"=>$data->id))',
					'options'=>array('title'=>'Receber','onClick'=>"if(confirm('Confirma o recebimento?'))return true;else return false"),
					'visible'=>'$data->destino==Yii::app()->getModule("user")->user()->unidade && !isset($data->de_datahora)',
				),
			),
		),
	),
)); ?>