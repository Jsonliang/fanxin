<?php

require ('linkdate.php');

$hxid = $_POST["hxid"];
$image = $_POST["image"];

$target_path = "./upload/"; //接收文件目录

$target_path = $target_path . basename($_FILES['file']['name']);

if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {


    $ok_creat = "UPDATE user set avatar='$image' where hxid='$hxid'";

    mysql_query("SET NAMES 'utf8'");

    $get_first = mysql_query($ok_creat);


    if ($get_first) {


        $arr = array('code' => 1);


        echo JSON($arr);


    } else {


        $arr = array('code' => 2);


        echo JSON($arr);


    }


} else {


    $arr = array('code' => 3);


    echo JSON($arr);

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