<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'estado-grid',
	'dataProvider'=>$estadosProvider,
	'columns'=>array(
		'estadoText',
		'datahora',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'buttons'=>array(
				'view'=>array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/exibir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/justificativa", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>