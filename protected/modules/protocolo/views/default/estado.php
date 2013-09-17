<?php
/* @var $this EstadoController */
/* @var $model Estado */
/* @var $form CActiveForm */

if (Yii::app()->user->checkAccess('Recebedor'))
{
	$this->breadcrumbs=array(
		'Protocolo'=>array('/protocolo'),
		$model->pr->protocolo=>array('protocolo','id'=>$model->protocolo_id),
		$estado,
	);
}
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'estado-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php $this->widget('zii.widgets.CDetailView', array(
		'id'=>'protocolo-detail',
		'data'=>$model->pr,
		'attributes'=>array(
			'documento',
			'assunto',
			'origem',
			'datahora',
			'usuarioText',
			'observacao',
			'estadoText',
		),
	)); ?>

	<?php echo $form->errorSummary($model); ?>

	<p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->hiddenField($model, 'protocolo_id'); ?>
	<?php echo $form->hiddenField($model, 'estado'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'justificativa'); ?>
		<?php echo $form->textField($model,'justificativa',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'justificativa'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Confirmar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->