<?php

include 'Store.php';

$email = 'my@emailaddress.com';
$password = 'mysekritpassword';
$appKey = 'appkeyfromcafepress';
$storeName = 'storename';
$imgPath = '/image.png';

$merchandiseId = '2';

$cp = new Cafepress_Store( $appKey, $storeName);

$cp->authenticate( $email, $password );

$p = $cp->createProductWithDesign( $merchandiseId, $imgPath );

echo $p->getMarketUri();
