<?php
include 'captcha.class.php';
$options['sessionName'] = 'vihash_namfrel';
//$options['fontPath'] = '.';
//$options['fontFile'] = 'anonymous.gdf';
$options['imageWidth'] = 150;
$options['imageHeight'] = 45;
//$options['allowedChars'] = '1234567890';
$options['stringLength'] = 4;
$options['charWidth'] = 30 + rand(0, 10);
$options['blurRadius'] = rand(30,60);
//$options['secretKey'] = 'mySecRetkEy';

$captcha = new Captcha($options);
$captcha->getCaptcha();