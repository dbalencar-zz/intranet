<?php
$this->breadcrumbs=array(
	'Unidades'=>array('index'),
	$model->sigla,
);

$this->menu=array(
	array('label'=>'Adicionar Unidade', 'url'=>array('create', 'id'=>$model->id)),
	array('label'=>'Editar Unidade', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Excluir Unidade', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Confirma?')),
);
?>

<h1><?php echo $model->nome; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'id',
			'type'=>'raw',
			'value'=>sprintf('%03d', $model->id),
		),
		'sigla',
		'nome',
		'protocolo',
	),
)); ?>
