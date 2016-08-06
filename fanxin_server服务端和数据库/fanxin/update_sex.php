<?php

require ('linkdate.php');



$sex =$_POST["sex"];

$hxid =$_POST["hxid"];

 







       mysql_query("SET NAMES 'utf8'");

    $ok_state=mysql_query("UPDATE  user SET  sex='$sex' WHERE  hxid ='$hxid'") ;

     

   

    if($ok_state ){

         $array = array(

                

                   'code'=>1

                   );

                    echo JSON($array);  

    

         

}else{

    $array = array(

                

                   'code'=>2

                   );

                    echo JSON($array);  

    

        

}

function JSON($array1) {

 arrayRecursive($array1, 'urlencode', true);

 $json1 = json_encode($array1);

 return urldecode($json1);

}







function arrayRecursive(&$array, $function, $apply_to_keys_also = false)

{

    static $recursive_counter = 0;

    if (++$recursive_counter > 1000) {

        die('possible deep recursion attack');

    }

    foreach ($array as $key => $value) {

        if (is_array($value)) {

            arrayRecursive($array[$key], $function, $apply_to_keys_also);

        } else {

            $array[$key] = $function($value);

        }

 

        if ($apply_to_keys_also && is_string($key)) {

            $new_key = $function($key);

            if ($new_key != $key) {

                $array[$new_key] = $array[$key];

                unset($array[$key]);

            }

        }

    }

    $recursive_counter--;

}







?>