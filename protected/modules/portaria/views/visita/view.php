<?php
/* @var $this VisitaController */
/* @var $model Visita */

$this->breadcrumbs=array(
	'Portaria'=>array('visita/create'),
	'Exibir',
);

$this->menu=array(
	array('label'=>'Registrar Saída', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Confirma Saída?')),
);
?>

<h1>Visita</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'visitante.nome',
		'cracha',
		'origem',
		'destino',
		'entrada',
		'saida',
		'observacao',
	),
)); ?>
