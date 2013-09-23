<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    
    <title>Visitantes</title>
</head>
<body>
<center>
<h1>Relatório de Visitantes</h1>
<table width="95%">
  <tr>
  	<th width="5%">Ord.</th>
  	<th width="20%">Documento</th>
  	<th>Nome</th>
  </tr>
<?php foreach ($models as $n=>$model) { ?>
  <tr>
  	<td align="center"><?php echo $n+1; ?></td>
  	<td align="center"><?php echo $model->documento; ?></td>
  	<td align="center"><?php echo $model->nome; ?></td>
  </tr>
<?php } ?>
</table>
</center>
</body>
</html>
	
