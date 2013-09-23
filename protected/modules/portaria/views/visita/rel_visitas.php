<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    
    <title>Visitas</title>
</head>
<body>
<center>
<h1>Relatório de Visitas</h1>

<div class="form">

<form method="post">

<div class="row">
	<?php echo CHtml::label('Data Inicial', 'inicio'); ?>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
    	'name'=>'inicio',
		'value'=>$inicio,
		'language'=>'pt',
	)); ?>
	<?php echo CHtml::label('Data Final', 'fim'); ?>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
	    'name'=>'fim',
		'value'=>$fim,
		'language'=>'pt',
	)); ?>
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton('Filtrar'); ?>
</div>

</form>

</div>

<table width="95%">
  <tr>
  	<th width="5%">Ord.</th>
  	<th width="5%">ID</th>
  	<th width="10%">Doc.</th>
  	<th width="20%">Nome</th>
  	<th width="10%">Origem</th>
  	<th width="10%">Destino</th>
  	<th width="12%">Entrada</th>
  	<th width="12%">Saída</th>
  	<th>Observação</th>
  </tr>
<?php foreach ($models as $n=>$model) { ?>
  <tr>
  	<td align="center"><?php echo $n+1; ?></td>
  	<td align="center"><?php echo $model->cracha; ?></td>
  	<td align="center"><?php echo $model->visitante->documento; ?></td>
  	<td align="center"><?php echo $model->visitante->nome; ?></td>
  	<td align="center"><?php echo $model->origem; ?></td>
  	<td align="center"><?php echo $model->destino; ?></td>
  	<td align="center"><?php echo $model->entrada; ?></td>
  	<td align="center"><?php echo $model->saida; ?></td>
  	<td align="center"><?php echo $model->observacao; ?></td>
  </tr>
<?php } ?>
</table>
</center>
</body>
</html>
	
