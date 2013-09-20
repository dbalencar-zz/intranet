<?php
/* @var $this VisitaController */
/* @var $model Visita */
/* @var $form CActiveForm */
?>

<script type="text/javascript">
function addVisitante()
{
    <?php echo CHtml::ajax(array(
		'url'=>array('visitante/create'),
        'data'=> "js:$(this).serialize()",
        'type'=>'post',
        'dataType'=>'json',
        'success'=>"function(data)
        {
        	if (data.status == 'failure')
            {
            	$('#dialogVisitante div.divForForm').html(data.div);
                $('#dialogVisitante div.divForForm form').submit(addVisitante);
            }
            else
            {
            	$('#dialogVisitante div.divForForm').html(data.div);
                setTimeout(\"$('#dialogVisitante').dialog('close') \",1500);
    		    $('#Visita_visitante_nome').val(data.label);
    			$('#Visita_visitante_id').val(data.value);
            }
 
		}",
	))?>;
    return false; 
}
 
</script>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'visita-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cracha'); ?>
		<?php echo $form->textField($model,'cracha'); ?>
		<?php echo $form->error($model,'cracha'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'visitante_id'); ?>
		<?php echo $form->hiddenField($model,'visitante_id'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
			'name'=>'Visita_visitante_nome',
    		'source'=>$this->createUrl('visitante/searchVisitante'),
    		'options'=>array(
				'minLength'=>'3',
            	'showAnim'=>'fold',
				'select'=>"js:function(event, ui) {
					event.preventDefault();
    				$('#Visita_visitante_nome').val(ui.item.label);
    				$('#Visita_visitante_id').val(ui.item.value);
				}",
    			'change'=>"js:function(event, ui) {
    				if (!ui.item) {
    					$('#Visita_visitante_id').val('');
    				}
    			}",
    		),
			'htmlOptions'=>array('size'=>'50'),
		)); ?>
		<?php echo CHtml::button('Novo', array('onclick'=>"{addVisitante(); $('#dialogVisitante').dialog('open');}")); ?>
		<?php echo $form->error($model,'visitante_id'); ?>
	</div>
	
	<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    	'id'=>'dialogVisitante',
    	'options'=>array(
        	'title'=>'Novo Cadastro (Visitante)',
	        'autoOpen'=>false,
    	    'modal'=>true,
        	'width'=>650,
        	'height'=>260,
    	),
	));?>
	
	<div class="divForForm"></div>
 
	<?php $this->endWidget();?>

	<div class="row">
		<?php echo $form->labelEx($model,'origem'); ?>
		<?php echo $form->textField($model,'origem',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'origem'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'destino'); ?>
		<?php echo $form->textField($model,'destino',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'destino'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'observacao'); ?>
		<?php echo $form->textArea($model,'observacao',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'observacao'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Cadastrar' : 'Salvar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
