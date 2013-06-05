<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

if (Yii::app()->user->checkAccess('Authenticated'))
{
	$this->breadcrumbs=array(
		'Protocolo'=>array('/protocolo'),
		'Pesquisar'
	);
} else {
	$this->breadcrumbs=array(
			'Protocolo',
	);
}

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

<div class="search-form wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'documento'); ?>
		<?php echo $form->textField($model,'documento',array('size'=>25,'maxlength'=>50)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'origem'); ?>
		<?php echo $form->textField($model,'origem',array('size'=>25,'maxlength'=>100)); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Pesquisar'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>

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
