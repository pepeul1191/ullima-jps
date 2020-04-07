<?php

if ( ! function_exists('encrypt'))
{
  function encrypt($key, $value){
    return base64_encode(
      mcrypt_encrypt(
        MCRYPT_RIJNDAEL_256, 
        md5($key), 
        $value, 
        MCRYPT_MODE_CBC, 
        md5(
          md5($key)
        )
      )
    );
  }
}

if ( ! function_exists('decrypt'))
{
  function decrypt($key, $value){
    rtrim(
      mcrypt_decrypt(
        MCRYPT_RIJNDAEL_256, 
        md5($key), 
        base64_decode($value), 
        MCRYPT_MODE_CBC, 
        md5(
          md5($key)
        )
      ), '\0'
    );
  }
}
