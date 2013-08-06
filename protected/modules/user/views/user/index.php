<?php
$this->breadcrumbs=array(
	UserModule::t("Users"),
);
if(UserModule::isAdmin()) {
	$this->layout='//layouts/column2';
	$this->menu=array(
	    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
	    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
	);
}
?>

<h1><?php echo UserModule::t("List User"); ?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'name',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->profile->first_name." ".$data->profile->last_name),array("user/view","id"=>$data->id))',
		),
		'email',
		array(
			'name' => 'extension',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->profile->extension),array("user/view","id"=>$data->id))',
		),
		array(
			'name' => 'unidade',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->profile->unidade->sigla),array("user/view","id"=>$data->id))',
		),
	),
)); ?>
