<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

if (Yii::app()->user->checkAccess('Recebedor'))
{
	$this->breadcrumbs=array(
		'Protocolo'=>array('/protocolo'),
		$model->pr->protocolo=>array('/protocolo/default/protocolo', 'id'=>$model->protocolo_id),
		'Tramitação',
	);
} else {
	$this->breadcrumbs=array(
		'Protocolo'=>array('/protocolo/default/pesquisar'),
		$model->pr->protocolo=>array('/protocolo/default/protocolo', 'id'=>$model->protocolo_id),
		'Tramitação',
	);
}

$this->menu=array(
	array('label'=>'Pesquisar', 'url'=>array('pesquisar')),
	array('label'=>'Protocolar', 'url'=>array('protocolar'), 'visible'=>Yii::app()->user->checkAccess('Protocolista')),
);
?>

<h1>Detalhes</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'or.nome',
		'usuarioOrigemText',
		'or_datahora',
		'de.nome',
		'usuarioDestinoText',
		'de_datahora',
		'despacho',
	),
)); ?>
