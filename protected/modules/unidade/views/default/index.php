<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);

$this->menu=array(
		array('label'=>'Adicionar Unidade', 'url'=>array('create')),
);
?>

<?php $this->widget('CTreeView',array('data'=>$data,'animated'=>'fast','collapsed'=>false,'htmlOptions'=>array('class'=>'filetree'))); ?>
