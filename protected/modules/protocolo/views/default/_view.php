<?php
/* @var $this ProtocoloController */
/* @var $data Protocolo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('documento')); ?>:</b>
	<?php echo CHtml::encode($data->documento); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('assunto')); ?>:</b>
	<?php echo CHtml::encode($data->assunto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('origem')); ?>:</b>
	<?php echo CHtml::encode($data->origem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datahora')); ?>:</b>
	<?php echo CHtml::encode($data->datahora); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario')); ?>:</b>
	<?php echo CHtml::encode($data->us->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observacao')); ?>:</b>
	<?php echo CHtml::encode($data->observacao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arquivado')); ?>:</b>
	<?php echo CHtml::encode($data->arquivadoText); ?>
	<br />

</div>