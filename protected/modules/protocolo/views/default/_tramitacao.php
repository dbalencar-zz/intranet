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
			'template'=>'{view}',
			'buttons'=>array(
				'view'=>array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/exibir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/tramitacao", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>