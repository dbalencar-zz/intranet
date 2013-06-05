<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'protocolo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'documento'); ?>
		<?php echo $form->textField($model,'documento',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'documento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'origem'); ?>
		<?php echo $form->textField($model,'origem',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'origem'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'assunto'); ?>
		<?php echo $form->textField($model,'assunto',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'assunto'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'destino'); ?>
		<?php echo $form->dropDownList($model,'destino',Unidade::model()->listAll(Yii::app()->getModule('user')->user()->profile->unidade_id)); ?>
		<?php echo $form->error($model,'destino'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'observacao'); ?>
		<?php echo $form->textField($model,'observacao',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'observacao'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Protocolar' : 'Atualizar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->