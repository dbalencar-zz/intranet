<?php
$this->breadcrumbs=array(
	'Unidades'=>array('index'),
	$model->sigla=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>'Adicionar Unidade', 'url'=>array('create')),
);
?>

<h1><?php echo $model->nome; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>