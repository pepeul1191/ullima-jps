<?php

if ( ! function_exists('string_num'))
{
  function string_num($length){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random = '';
    for ($i = 0; $i < $length; $i++) {
      $random .= $characters[rand(0, $characters_length - 1)];
    }
    return $random;
  }
}
