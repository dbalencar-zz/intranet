<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/protocolo.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body onload="window.print()">

<div class="container" id="page">

        <div id="header">
                <div id="logo"><img src="<?php echo Yii::app()->baseUrl; ?>/images/estado-logo.png"></img></div>
                <div id="logo1">GOVERNO DO ESTADO DO AMAZONAS</div>
        </div><!-- header -->

        <?php echo $content; ?>

        <div id="footer">
                <div id="img-logo-gov"><img src="<?php echo Yii::app()->baseUrl; ?>/images/governo-logo.png"></img></div>
                <p class="footer-left">Av. Torquato Tapajós, 5.555, Flores<br/>Fone: (092)3652-2009/3652-2008<br/>Manaus - AM - CEP 69058-830</p>
                <div id="img-logo-pc"><img src="<?php echo Yii::app()->baseUrl; ?>/images/sesp-logo.png"></img></div>
                <p class="footer-center"><b>SSP<br/>Secretaria de Estado de Segurança Pública do Amazonas</b><br/><?php echo Yii::app()->getModule('user')->user()->profile->unidade->nome; ?></p>
        </div><!-- footer -->

</div><!-- page -->

</body>
</html>
