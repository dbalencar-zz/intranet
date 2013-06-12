<?php
/* @var $this ProtocoloController */
/* @var $model Protocolo */

$this->breadcrumbs=array(
	'Protocolo',
);

$this->menu=array(
	array('label'=>'Protocolar', 'url'=>array('create'), 'visible'=>Yii::app()->user->checkAccess('Protocolista')),
	array('label'=>'Pesquisar', 'url'=>array('admin')),
);
?>

<style>
.grid-view .button-column img
{
	border: 0;
	padding-right: 4px;
}
</style>

<h1><?php echo Yii::app()->getModule('user')->user()->profile->unidade->nome; ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pendentes-grid',
	'dataProvider'=>$pendentesProvider,
	'columns'=>array(
		'protocolo_id',
		'or.sigla',
		'or_datahora',
		'de.sigla',
		'de_datahora',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{receber}{tramitar}{arquivar}{update}{imprimir}{view}',
			'buttons'=>array(
				'view'=>array(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/exibir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/view", array("id"=>$data->protocolo_id))',
				),
				'receber'=>array(
					'label'=>'Receber',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/receber.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/receber", array("id"=>$data->id))',
					'options'=>array('title'=>'Receber','onClick'=>"if(confirm('Confirma o recebimento?'))return true;else return false"),
					'visible'=>'$data->destino==Yii::app()->getModule("user")->user()->unidade && !isset($data->de_datahora)',
				),
				'tramitar'=>array(
					'label'=>'Tramitar',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/tramitar.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/move", array("id"=>$data->protocolo_id))',
					'visible'=>'isset($data->de_datahora)',
				),
				'arquivar'=>array(
					'label'=>'Arquivar',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/arquivar.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/arquivar", array("id"=>$data->protocolo_id))',
					'options'=>array('title'=>'Arquivar','onClick'=>"if(confirm('Confirma o arquivamento?'))return true;else return false"),
					'visible'=>'isset($data->de_datahora)',
				),
				'imprimir'=>array(
					'label'=>'Imprimir',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/imprimir.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/print", array("id"=>$data->id))',
					'visible'=>'$data->origem==Yii::app()->getModule("user")->user()->unidade && !isset($data->de_datahora)',
				),
				'update'=>array(
					'label'=>'Editar',
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/editar.png',
					'url'=>'Yii::app()->createUrl("/protocolo/default/update", array("id"=>$data->id))',
					'visible'=>'$data->origem==Yii::app()->getModule("user")->user()->unidade && !isset($data->de_datahora)',
				),
			),
		),
	),
)); ?>