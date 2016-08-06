<?php

require ('linkdate.php');



$uids=$_POST["uids"];

$arr_uid=array();

$separator='66split88';

$arr_uid=explode($separator,$uids) ;

$arr=array(); 

$i=0;

 for($n=0;$n<count($arr_uid);$n++){

   

    $uid=$arr_uid[$n];

    mysql_query("SET NAMES 'utf8'");

    $result= mysql_query("SELECT * from user where hxid='$uid' ");  

    while ($rs = mysql_fetch_array($result,MYSQL_ASSOC)){

                 $arr[$i]=$rs; 

                    $i++;                    

          }  

 }



if($result){

            

          

          

           $array = array(

 

                    'code'=>1,

                    'friends'=>$arr

                  

                   );

                    echo JSON($array); 

}else{

          $array = array(

 

                   'code'=>2,
                   'error'=>$arr_uid
                           

                   );

                    echo JSON($array); 

    

    

}



function JSON($array1)

{

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