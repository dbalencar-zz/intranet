<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

if (Yii::app()->user->checkAccess('Authenticated'))
{
	$this->breadcrumbs=array(
		'Protocolo'=>array('/protocolo'),
		$model->protocolo_id=>array('/protocolo/default/view', 'id'=>$model->protocolo_id),
		'Tramitação',
	);
} else {
	$this->breadcrumbs=array(
		'Protocolo'=>array('/protocolo/default/admin'),
		$model->protocolo_id=>array('/protocolo/default/view', 'id'=>$model->protocolo_id),
		'Tramitação',
	);
}

$this->menu=array(
	array('label'=>'Pesquisar', 'url'=>array('admin')),
	array('label'=>'Protocolar', 'url'=>array('create'), 'visible'=>Yii::app()->user->checkAccess('Protocolista')),
);
?>

<h1>Protocolo #<?php echo $model->protocolo_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->pr,
	'attributes'=>array(
		'documento',
		'origem',
		'assunto',
		'datahora',
		'usuarioText',
		'observacao',
	),
)); ?>

<br/>

<h1 style="float: left;">Tramitação Detalhada</h1>

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
