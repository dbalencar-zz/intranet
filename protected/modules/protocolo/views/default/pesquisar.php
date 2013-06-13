<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

if (Yii::app()->user->checkAccess('Tramitador'))
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
	array('label'=>'Protocolar', 'url'=>array('pesquisar'), 'visible'=>Yii::app()->user->checkAccess('Protocolista')),
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
		<?php echo $form->label($model,'protocolo'); ?>
		<?php echo $form->textField($model,'protocolo',array('size'=>14,'maxlength'=>14)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'documento'); ?>
		<?php echo $form->textField($model,'documento',array('size'=>25,'maxlength'=>50)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'assunto'); ?>
		<?php echo $form->textField($model,'assunto',array('size'=>25,'maxlength'=>100)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'origem'); ?>
		<?php echo $form->textField($model,'origem',array('size'=>25,'maxlength'=>100)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'arquivado'); ?>
		<?php echo $form->dropDownList($model,'arquivado',$model->simNaoOptions,array('empty'=>'Todos')); ?>
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
		'protocolo',
		'documento',
		'assunto',
		'origem',
		'datahora',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'buttons'=>array(
				'view'=>array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/exibir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/protocolo", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
