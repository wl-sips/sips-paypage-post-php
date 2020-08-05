<?php

// public API for user code
// returns a string that can be submitted to sips API to initiate a payment on
// Paypage Post interface
function flatten_to_sips_payload($input)
{
   $keyStack = array();
   return implode("|", flatten_undefined($input, $keyStack));
}

// utility method called by flatten_to_sips_payload and flatten_array
// returns a single dimensional array that can be imploded as a string with the
// required separator
function flatten_undefined($object, $keyStack)
{
   $result = array();
   if(is_array($object)){
      $result = array_merge($result, flatten_array($object, $keyStack));
   }else if(!empty($keyStack)){
      $result[] = implode('.', $keyStack) . '=' . $object;
   }else{
      $result[] = $object;
   }
   return $result;
}

// utility method called by flatten_undefined or by itself
// returns a single dimensional array representing this array
function flatten_array($array, $keyStack)
{
   $simpleValues = array();$result = array();
   
   foreach($array as $key => $value){
      if(is_int($key)){
         // Values without keys are added to results after ones having keys
         if(is_array($value)){
            $noKeyStack = array();
            $simpleValues = array_merge($simpleValues, flatten_array($value, $noKeyStack));
         }else{
            $simpleValues[] = $value;
         }
      }else{
         $keyStack[] = $key;
         $result = array_merge($result, flatten_undefined($value, $keyStack));
         array_pop($keyStack);
      }
   }
   
   if(!empty($simpleValues)){
      if(empty($keyStack)){
         $result = array_merge($result, $simpleValues);
      }else{
         $result[] = implode(".", $keyStack) . '=' . implode(",", $simpleValues);
      }
   }
   return $result;
}

?>
