<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

$this->breadcrumbs=array(
	'Protocolo'=>array('admin'),
	$model->protocolo_id=>array('protocolo','id'=>$model->protocolo_id),
	'Editar',
);

$this->menu=array(
	array('label'=>'Protocolar', 'url'=>array('protocolar')),
);
?>

<?php
/* @var $this TramitacaoController */
/* @var $model Tramitacao */
/* @var $form CActiveForm */

if (!CHtml::submitButton($model->isNewRecord)) {
	$this->breadcrumbs=array(
		'Protocolo'=>array('admin'),
		$model->protocolo_id=>array('view', 'id'=>$model->protocolo_id),
		'Tramitar',
	);
}
?>

<h1>Tramitar Protocolo #<?php echo $model->protocolo_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->pr,
	'attributes'=>array(
		'documento',
		'origem',
		'datahora',
		'usuarioText',
		'observacao',
	),
)); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tramitacao-move-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->hiddenField($model, 'protocolo_id'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'destino'); ?>
		<?php echo $form->dropDownList($model, 'destino', Unidade::model()->listAll(Yii::app()->getModule('user')->user()->profile->unidade->id)); ?>
		<?php echo $form->error($model,'destino'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'despacho'); ?>
		<?php echo $form->textField($model,'despacho', array('size'=>'50')); ?>
		<?php echo $form->error($model,'despacho'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Tramitar' : 'Atualizar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->