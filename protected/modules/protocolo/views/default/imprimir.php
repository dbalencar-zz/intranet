<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    
    <title>Chamado <?php echo $model->id; ?></title>
</head>
<body>
<center>
<table width="900" >
	<tr>
		<td colspan="4" style="text-align: center; font-size:x-large; font-weight: bold;">PROTOCOLO #</td>
		<td style="text-align: center; font-size: medium; font-weight: bold;"><?php echo $model->protocolo_id; ?></td>
		<td style="text-align: center; font-size: large; font-weight: bold;">Tramitado em <?php echo $data = Yii::app()->dateFormatter->formatDateTime($model->or_datahora,'medium','medium'); ?></td>
	</tr>
</table>
<table width="900">
	<tr>
		<th colspan="5">INFORMAÇÕES</th>
	</tr>
	<tr>
		<td align="right">Documento:</td><td><?php echo $model->pr->documento; ?></td>
	</tr>
	<tr>
		<td align="right">Assunto:</td><td><?php echo $model->pr->assunto; ?></td>
	</tr>
	<tr>
		<td align="right">Interessado:</td><td><?php echo $model->pr->origem; ?></td>
	</tr>
	<tr>
		<td align="right">Protocolado:</td><td><?php echo Yii::app()->dateFormatter->formatDateTime($model->pr->datahora,'medium','medium'); ?></td>
	</tr>
	<tr>
		<td align="right">Protocolista:</td><td><?php echo $model->pr->usuarioText; ?></td>
	</tr>
	<tr>
		<td align="right">Observação:</td><td><?php echo $model->pr->observacao; ?></td>
	</tr>
</table>
<table width="900">
	<tr>
		<td colspan="2">DESPACHO (<?php echo $model->usuarioOrigemText; ?>): <p><?php echo $model->despacho; ?></p></td>
	</tr>
	<tr style="min-height: 300px;">
		<td style="width: 50%;">Recebido por <br/><br/><br/></td>
		<td>Data: _____/_____/__________ Horário _____:_____ h.</td>
	</tr>
</table>
</center>
</body>
</html>
