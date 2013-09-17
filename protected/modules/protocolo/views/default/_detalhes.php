<?php

if($model->estado==Estado::APENSADO) {
	
$this->widget('zii.widgets.CDetailView', array(
	'id'=>'protocolo-detail',
	'data'=>$model,
	'attributes'=>array(
		'documento',
		'assunto',
		'origem',
		'datahora',
		'usuarioText',
		'observacao',
		'estadoText',
		array(
			'label'=>'Apensado',
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->vinculado->protocolo), array('protocolo','id'=>$model->vinculado->id)),
		),
	),
));

} else {

$this->widget('zii.widgets.CDetailView', array(
	'id'=>'protocolo-detail',
	'data'=>$model,
	'attributes'=>array(
		'documento',
		'assunto',
		'origem',
		'datahora',
		'usuarioText',
		'observacao',
		'estadoText',
	),
));

}