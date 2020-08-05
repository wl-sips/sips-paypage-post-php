<?php
//This file is used to calculate the seal using the HMAC-SHA256 AND SHA256 algorithms

function compute_seal_from_string($sealAlgorithm, $data, $secretKey)
{
   if(strcmp($sealAlgorithm, "HMAC-SHA-256") == 0){
      $hmac256 = true;
   }elseif(empty($sealAlgorithm)){
      $hmac256 = false;
   }else{
      $hmac256 = false;
   }
   return compute_seal($hmac256, $data, $secretKey);
}

function compute_seal($hmac256, $data, $secretKey)
{
   $serverEncoding = mb_internal_encoding();
   
   if(strcmp($serverEncoding, "UTF-8") == 0){
      $dataUtf8 = $data;
      $secretKeyUtf8 = $secretKey;
   }else{
      $dataUtf8 = iconv($serverEncoding, "UTF-8", $data);
      $secretKeyUtf8 = iconv($serverEncoding, "UTF-8", $secretKey);
   }
   if($hmac256){
      $seal = hash_hmac('sha256', $data, $secretKey);
   }else{
      $seal = hash('sha256',  $data.$secretKey);
   }
   return $seal;
}

?>