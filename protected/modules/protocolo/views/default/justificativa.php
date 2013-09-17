<?php
/* @var $this EstadoController */
/* @var $model Estado */

if (Yii::app()->user->checkAccess('Recebedor'))
{
	$this->breadcrumbs=array(
		'Protocolo'=>array('/protocolo'),
		$model->pr->protocolo=>array('protocolo','id'=>$model->protocolo_id),
		'Situação',
	);
}
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'estadoText',
		'justificativa',
		'usuarioText',
		'datahora',
	),
)); ?>
