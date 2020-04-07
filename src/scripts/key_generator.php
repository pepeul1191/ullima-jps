<?php

require_once('../helpers/cipher_helper.php');

$value = 'sila123';
$key = '7o0YgRhn5UHzp';

$new_value = encrypt($key, $value);
var_dump($new_value);

$temp = 'Bd2vUh1UzAT47MpTC/lOhFgyny1dAO3RIusXQIiSY5A=';

$new_value = decrypt($key, $temp);
var_dump($new_value);