<?php

require ('linkdate.php');
$uid = $_POST["uid"];
$check_uid = mysql_query("select hxid from user where fxid='$uid' limit 1");
$numrows = mysql_num_rows($check_uid);
if ($numrows !== 0) {
    mysql_query("SET NAMES 'utf8'");
    $get_user = mysql_query("SELECT * FROM user WHERE fxid='$uid' ");
    $user = array();
    while ($arr = mysql_fetch_array($get_user, MYSQL_ASSOC)) {

        $user = $arr;
    }

    if ($get_user) {


        $array = array('code' => 1, 'user' => $user);
        echo JSON($array);
    } else {

        $array = array('code' => 3, 'user' => '0');
        echo JSON($array);

    }

} else {
    $check_tel = mysql_query("select hxid from user where tel='$uid' limit 1");
    $numrows2 = mysql_num_rows($check_tel);
    if ($numrows2 !== 0) {
        mysql_query("SET NAMES 'utf8'");
        $get_user = mysql_query("SELECT * FROM user WHERE tel='$uid' ");
        $user = array();
        while ($arr = mysql_fetch_array($get_user, MYSQL_ASSOC)) {

            $user = $arr;
        }

        if ($get_user) {


            $array = array('code' => 1, 'user' => $user);
            echo JSON($array);
        } else {

            $array = array('code' => 3, 'user' => '0');
            echo JSON($array);

        }
    } else {


        $array = array(

            'code' => 2,
            'user' => '0',

            );
        echo JSON($array);
    }
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

