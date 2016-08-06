 <?php



require ('linkdate.php');





//$time = date("Y-m-d H:i:s", time()); //时间标签

$usernick = $_POST["usernick"];

$usertel = $_POST["usertel"];

$password = $_POST["password"];

$image = $_POST["image"];

$check_tel = mysql_query("SELECT count(*) FROM user WHERE tel='$usertel' ");

while ($row2 = mysql_fetch_array($check_tel, MYSQL_NUM)) {



    $num2 = $row2[0];

}

if ($num2 == 0) {



    if ($image == "false") {

        $image = "0";



        mysql_query("SET NAMES 'utf8'");

        $ok_insert = "INSERT INTO user(fxid,nick,tel,password,avatar,sex,region,time,sign)

              values('0','$usernick','$usertel','$password','$image','0','0','0','0')";

        mysql_query("SET NAMES 'utf8'");

        $insert_result = mysql_query($ok_insert);

        if ($insert_result) {



          $get_hxid=  mysql_query("SELECT hxid FROM user WHERE tel='$usertel' ");

           while ($row = mysql_fetch_array($get_hxid, MYSQL_NUM)) {



                $hxid = $row[0];

            }

            if($hxid!=NULL){

                 $array = array('code' => 1,'hxid' =>$hxid );

                echo JSON($array);

                

            }else{

                $array = array('code' => 5);

                echo JSON($array);

            }



           

        } else {

            $array = array('code' => 3);

            echo JSON($array);

        }

    } else {

        $target_path = "./upload/"; //接收文件目录

        $target_path = $target_path . basename($_FILES['file']['name']);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {

            mysql_query("SET NAMES 'utf8'");

            $ok_insert = "INSERT INTO user(fxid,nick,tel,password,avatar,sex,region,time,sign)

              values('0','$usernick','$usertel','$password','$image','0','0','$time','0')";

            mysql_query("SET NAMES 'utf8'");

            $insert_result = mysql_query($ok_insert);

            if ($insert_result) {

                 $get_hxid=  mysql_query("SELECT hxid FROM user WHERE tel='$usertel' ");

           while ($row = mysql_fetch_array($get_hxid, MYSQL_NUM)) {



                $hxid = $row[0];

            }

            if($hxid!=NULL){

                 $array = array('code' => 1,'hxid' =>$hxid );

                echo JSON($array);

                

            }else{

                $array = array('code' => 5);

                echo JSON($array);

            }



           

            } else {

                $array = array('code' => 3);

                echo JSON($array);

            }

        } else {

            $array = array('code' => 4);

            echo JSON($array);



        }

    }





} else {

    $array = array('code' => 2);

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



 