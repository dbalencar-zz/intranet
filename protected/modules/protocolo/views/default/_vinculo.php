<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */
/* @var $form CActiveForm */

$model->protocolo=$protocolo->id;
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vinculo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'protocolo'); ?>
	
	<div class="row">
		<?php echo CHtml::activeLabelEx($model, 'vinculo'); ?>
		<?php $this->widget('CMaskedTextField', array(
			'model' => $model,
			'attribute' => 'vinculo',
			'mask' => '99.999.9999999',
			'htmlOptions' => array('size' => 14)
		)); ?>
		<?php echo $form->error($model,'vinculo'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Apensar',array('default/vincular'),array('success'=>'summaryVinculo')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->