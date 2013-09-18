<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vinculo-grid',
	'dataProvider'=>$vinculosProvider,
	'columns'=>array(
		'vin.protocolo',
		'vinculado',
		'vinculadorText',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}{view}',
			'buttons'=>array(
				'view'=>array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/exibir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/protocolo", array("id"=>$data->vinculo))',
				),
				'delete'=>array(
					'label'=>'Desapensar',
					'url'=>'Yii::app()->createUrl("/protocolo/default/desvincular", array("id"=>$data->id))',
					'visible'=>'!$data->pro->readOnly && Yii::app()->user->checkAccess("Desapensador")',
				),
			),
		),
	),
)); ?>