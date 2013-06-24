<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

if (Yii::app()->user->checkAccess('Recebedor'))
{
	$this->breadcrumbs=array(
		'Protocolo'=>array('/protocolo'),
		$model->protocolo,
	);
} else {
	$this->breadcrumbs=array(
		'Protocolo'=>array('/protocolo/default/pesquisar'),
		$model->protocolo,
	);
}

$this->menu=array(
	array('label'=>'Pesquisar', 'url'=>array('pesquisar')),
	array('label'=>'Protocolar', 'url'=>array('protocolar'), 'visible'=>Yii::app()->user->checkAccess('Protocolista')),
	array('label'=>'Apensar', 'url'=>'#', 'linkOptions'=>array('onclick'=>'js:load();'), 'visible'=>Yii::app()->user->checkAccess('Protocolista')),
);
?>

<script>
function load()
{
	$('.errorSummary').hide();
	$('.errorSummary ul').html('<li></li>');
	$('#Vinculo_vinculo').val('');
	$("#vinculoDialog").dialog("open");
}

function summary(data)
{
	var result = $.parseJSON(data);
	
	if(result.status==='success')
	{
		$.fn.yiiGridView.update('vinculo-grid');
		$('#vinculoDialog').dialog('close');
	} else {
		$('.errorSummary ul').html(result.error);
		$('.errorSummary').show();
	}
}
</script>

<?php $this->widget('zii.widgets.jui.CJuiAccordion',array(
	'panels'=>array(
		'Detalhes'=>$this->renderPartial('_detalhes',array('model'=>$model),true),
		'Apensos'=>$this->renderPartial('_apensos',array('vinculosProvider'=>$vinculosProvider),true),
		'Tramitação'=>$this->renderPartial('_tramitacao',array('tramitacoesProvider'=>$tramitacoesProvider),true),
	),
	'options'=>array(
		'animated'=>'bounceslide',
	),
)); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'vinculoDialog',
    'options'=>array(
        'title'=>'Apensar',
    	'modal'=>true,
        'autoOpen'=>false,
    	'width'=>'auto',
    ),
)); ?>

<?php echo $this->renderPartial('_vinculo', array('model'=>new Vinculo(),'protocolo'=>$model)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
