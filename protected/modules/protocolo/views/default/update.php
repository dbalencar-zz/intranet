<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

$this->breadcrumbs=array(
	'Protocolo'=>array('admin'),
	$model->protocolo_id=>array('view','id'=>$model->protocolo_id),
	'Editar',
);

$this->menu=array(
	array('label'=>'Protocolar', 'url'=>array('create')),
);
?>

<?php echo $this->renderPartial('move', array('model'=>$model)); ?>