<?php $this->widget('zii.widgets.CDetailView', array(
	'id'=>'protocolo-detail',
	'data'=>$model,
	'attributes'=>array(
		'documento',
		'assunto',
		'origem',
		'datahora',
		'usuarioText',
		'observacao',
		'arquivadoText',
	),
)); ?>