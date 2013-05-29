<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

$this->breadcrumbs=array(
	'Protocolo'=>array('pendentes'),
	'Pesquisar'
);

$this->menu=array(
	array('label'=>'Protocolar', 'url'=>array('create'), 'visible'=>Yii::app()->user->checkAccess('Protocolista')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#protocolo-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Pesquisar</h1>

<br/>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo CHtml::submitButton('Pesquisar'); ?>
	</div>

<?php $this->endWidget(); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'protocolo-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'id',
		'documento',
		'origem',
		'datahora',
		array(
			'name'=>'usuario',
			'value'=>'$data->usuarioText',
		),
		'observacao',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>
