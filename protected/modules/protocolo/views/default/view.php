<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

$this->breadcrumbs=array(
	'Protocolo'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Protocolar', 'url'=>array('create')),
	array('label'=>'Editar', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Excluir', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Deseja realmente excluir este item?')),
);
?>

<h1>Protocolo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'documento',
		'origem',
		'datahora',
		'usuarioText',
		'observacao',
	),
)); ?>

<br/>

<h1 style="float: left;">Tramitação</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'protocolo-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'origem',
		'or_datahora',
		'destino',
		'de_datahora',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
