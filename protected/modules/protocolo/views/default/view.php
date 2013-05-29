<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

$this->breadcrumbs=array(
	'Protocolo'=>array('/protocolo'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Pesquisar', 'url'=>array('admin')),
	array('label'=>'Protocolar', 'url'=>array('create'), 'visible'=>Yii::app()->user->checkAccess('Protocolista')),
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
		'or.sigla',
		'or_datahora',
		'de.sigla',
		'de_datahora',
	),
)); ?>
