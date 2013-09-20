<?php
/* @var $this VisitaController */
/* @var $model Visita */

$this->breadcrumbs=array(
	'Portaria'=>array('visita/create'),
	'Cadastro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'visita-grid',
	'dataProvider'=>$filtro->searchPendentes(),
	'filter'=>$filtro,
	'columns'=>array(
		'cracha',
		array(
			'class'=>'DataColumn',
			'name'=>'_nome',
			'value'=>'$data->visitante->nome',
			'evaluateHtmlOptions'=>true,
			'htmlOptions'=>array('title'=>'"{$data->visitante->nome}"'),
		),
		'origem',
		'destino',
		'entrada',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {delete}',
			'deleteConfirmation'=>'Confirma Saída?',
		),
	),
)); ?>