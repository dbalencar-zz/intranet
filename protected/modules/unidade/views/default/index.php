<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>

<h2>Tree View</h2>

<?php $this->widget('CTreeView',array('data'=>$data,'animated'=>'fast','collapsed'=>false,'htmlOptions'=>array('class'=>'filetree'))); ?>
