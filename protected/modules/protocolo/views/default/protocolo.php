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

<h1>Detalhes</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'id'=>'protocolo-detail',
	'data'=>$model,
	'attributes'=>array(
		'documento',
		'assunto',
		'origem',
		'datahora',
		'usuarioText',
		'observacao',
		'arquivadoText',
	),
)); ?>

<br/>


<script>
$( document ).ready(function() {
	//$('#vinculo-grid').hide();
	//$('#tramitacao-grid').hide();
});

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

<h2>Adendos</h2>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vinculo-grid',
	'dataProvider'=>$vinculosProvider,
	'columns'=>array(
		'vin.protocolo',
		'vinculado',
		'vinculadorText',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}{view}',
			'buttons'=>array(
				'view'=>array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/exibir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/protocolo", array("id"=>$data->vinculo))',
				),
				'delete'=>array(
					'label'=>'Desapensar',
					'url'=>'Yii::app()->createUrl("/protocolo/default/desvincular", array("id"=>$data->id))',
					'visible'=>'Yii::app()->user->checkAccess("Desapensador")',
				),
			),
		),
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

<br/>

<h2>Tramitações</h2>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tramitacao-grid',
	'dataProvider'=>$tramitacoesProvider,
	'columns'=>array(
		'or.sigla',
		'or_datahora',
		'de.sigla',
		'de_datahora',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'buttons'=>array(
				'view'=>array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/exibir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/tramitacao", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>
