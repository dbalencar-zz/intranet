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
	array('label'=>'Apensar', 'url'=>'#', 'linkOptions'=>array('onclick'=>'js:loadVinculo();'),
		'visible'=>!$model->readOnly && Yii::app()->user->checkAccess('Apensador') && $model->estado==Estado::NORMAL
	),
	array('label'=>'Arquivar', 'url'=>array('estado', 'protocolo'=>$model->id, 'estado'=>Estado::ARQUIVADO),
		'visible'=>!$model->readOnly && Yii::app()->user->checkAccess("Arquivista") && $model->estado==Estado::NORMAL
	),
	array('label'=>'Desarquivar', 'url'=>array('estado', 'protocolo'=>$model->id, 'estado'=>Estado::NORMAL),
		'visible'=>!$model->readOnly && Yii::app()->user->checkAccess("Arquivista") && $model->estado==Estado::ARQUIVADO
	),
	array('label'=>'Externar', 'url'=>array('estado', 'protocolo'=>$model->id, 'estado'=>Estado::EXTERNO),
		'visible'=>!$model->readOnly && Yii::app()->user->checkAccess("Tramitador") && $model->estado==Estado::NORMAL
	),
	array('label'=>'Reinternar', 'url'=>array('estado', 'protocolo'=>$model->id, 'estado'=>Estado::NORMAL),
		'visible'=>!$model->readOnly && Yii::app()->user->checkAccess("Recebedor") && $model->estado==Estado::EXTERNO
	),		
	array('label'=>'Cancelar', 'url'=>array('estado', 'protocolo'=>$model->id, 'estado'=>Estado::CANCELADO),
		'visible'=>!$model->readOnly && Yii::app()->user->checkAccess('Protocolista') && $model->estado==Estado::NORMAL
			&& !isset($model->vinculo) && empty($model->vinculos)
	),
);
?>

<script>
function loadVinculo()
{
	$('.errorSummary').hide();
	$('.errorSummary ul').html('<li></li>');
	$('#Vinculo_vinculo').val('');
	$("#vinculoDialog").dialog("open");
}

function summaryVinculo(data)
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

<?php if ($model->estado==Estado::APENSADO) {
	 
$this->widget('zii.widgets.jui.CJuiAccordion',array(
	'panels'=>array(
		'Detalhes'=>$this->renderPartial('_detalhes',array('model'=>$model),true),
	),
	'options'=>array(
		'animated'=>'bounceslide',
	),
));

} else {

$this->widget('zii.widgets.jui.CJuiAccordion',array(
	'panels'=>array(
		'Detalhes'=>$this->renderPartial('_detalhes',array('model'=>$model),true),
		'Situações'=>$this->renderPartial('_estados',array('estadosProvider'=>$estadosProvider),true),
		'Tramitação'=>$this->renderPartial('_tramitacao',array('tramitacoesProvider'=>$tramitacoesProvider),true),
		'Apensos'=>$this->renderPartial('_apensos',array('vinculosProvider'=>$vinculosProvider),true),
	),
	'options'=>array(
		'animated'=>'bounceslide',
	),
));

} ?>

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
