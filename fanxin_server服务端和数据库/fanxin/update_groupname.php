<?php
$groupId = $_POST["groupId"];
$groupName = $_POST["groupName"];
$groupName = str_replace("\\", "", $groupName);
$groupName = trimall($groupName);
//echo $groupName;
$groupName = rawurlencode($groupName);
$options = array(
    'client_id' => ' ', //你的信息
    'client_secret' => ' ', //你的信息
    'org_name' => ' ', //你的信息
    'app_name' => ' ', //你的信息
    );
$e = new Easemob($options);

$groupInfo = array(
    'groupname' => $groupName,
    'description' => ' ',
    'maxusers' => 200);


$result = $e->updateGroup($groupId, $groupInfo);
//$result = $e->getUserGroups('11223354');
// $result = $e->getGroupList();
// $result = $e->getGroupDetial("1423734662380237");

//print_r($result);
$aa = array();
$aa = $result["data"];
//print_r($aa);
$ok = $aa["groupname"];
if ($ok == 1) {
    $array = array('code' => 1);
    echo json_encode($array);

} else {

    $array = array('code' => 0);
    echo json_encode($array);

}

function trimall($str) //删除空格
{
    $qian = array(
        " ",
        "　",
        "\t",
        "\n",
        "\r");
    $hou = array(
        "",
        "",
        "",
        "",
        "");
    return str_replace($qian, $hou, $str);
}

/*
* --------------强调说明-------------
* 参数 数字int 最好填 String 如groupId 1423734662380237 ,传参时传getGroupDetial("1423734662380237");
*/
class Easemob
{


    private $host = 'https://a1.easemob.com';
    private $client_id;
    private $client_secret;
    private $org_name;
    private $app_name;
    private $token = '';
    /*
    * ------------------------
    * 公共方法             开始
    * ------------------------
    */
    /**
     * 初始化参数
     *
     * @param array $options   
     * @param $options['client_id']     
     * @param $options['client_secret'] 
     * @param $options['org_name']      
     * @param $options['app_name']       
     */
    public function __construct($options)
    {
        $this->client_id = $options['client_id'];
        $this->client_secret = $options['client_secret'];
        $this->org_name = $options['org_name'];
        $this->app_name = $options['app_name'];
    }
    private function request($api_name, $data, $method = 'POST')
    {
        //$data = array("name" => "Hagrid", "age" => "36");
        if (isset($data)) {
            $data_string = json_encode($data);
        }
        $ch = curl_init($this->host . "/$this->org_name/$this->app_name/" . $api_name);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if (strtoupper($method) != 'GET') {

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_USERAGENT,
            'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)'); // 模拟用户使用的浏览器

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                //'Accept: application/json',
                'Authorization: Bearer ' . $this->getToken()
                // 'Content-Length: ' . strlen($data_string)
                ));
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        curl_close($ch);
        return $result;
    }

    /*
    * 取得TOKEN
    */
    public function getToken($reGet = false)
    {
        if (!$this->token || $reGet == true) {
            $path = "/$this->org_name/$this->app_name/token";
            $data = array(
                'grant_type' => 'client_credentials',
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret);
            $data_string = json_encode($data);

            $ch = curl_init($this->host . $path);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
            curl_setopt($ch, CURLOPT_USERAGENT,
                'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)'); // 模拟用户使用的浏览器
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $result = curl_exec($ch);
            $result_arr = json_decode($result, true);
            if (isset($result_arr['error'])) {
                echo $result;
                exit;
            } else {
                $this->token = $result_arr['access_token'];
            }
            return $this->token;
        } else {
            return $this->token;
        }
    }
    /*
    * ------------------------
    * 公共方法             结束
    * ------------------------
    */

    /*
    * ------------------------------------
    * 群组方法             开始
    * ------------------------------------
    */
    /*
    * 获取app中所有的群组
    */
    public function getGroupList()
    {
        $result = $this->request('chatgroups', '', 'GET');
        return $result;
    }
    /*
    * 获取一个或者多个群组的详情
    * $groupList mix  String or Array  
    *  demo: $groupList = array('1423734662380237', '1423734662380238)
    */
    public function getGroupDetial($groupList)
    {

        if (gettype($groupList) == 'array') {
            $group_list = implode(',', $groupList);
        } else {
            $group_list = $groupList;
        }

        $result = $this->request('chatgroups' . '/' . $group_list, '', 'GET');
        return $result;
    }
    /*
    * 
    * $groupInfo Array 群信息参数如下;
    "groupname":"testrestgrp12", //群组名称, 此属性为必须的
    "desc":"server create group", //群组描述, 此属性为必须的
    "public":true, //是否是公开群, 此属性为必须的
    "maxusers":300, //群组成员最大数(包括群主), 值为数值类型,默认值200,此属性为可选的
    "approval":true, //加入公开群是否需要批准, 没有这个属性的话默认是true（不需要群主批准，直接加入）, 此属性为可选的
    "owner":"jma1", //群组的管理员, 此属性为必须的
    "members":["jma2","jma3"] //群组成员,此属性为可选的,但是如果加了此项,数组元素至少一个（注：群主jma1不需要写入到members里面）
    * demo:
    * $groupInfo = array(
    'groupname' => 'leee',
    'desc'       => 'leeff',
    'owner' => 'sy1'
    );
    */
    public function createGroup($groupInfo)
    {
        $groupInfo['public'] = isset($groupInfo['public']) ? $groupInfo['public'] : true; //默认公开
        $groupInfo['approval'] = isset($groupInfo['approval']) ? $groupInfo['maxusers'] : false; //默认需要审核

        $result = $this->request('chatgroups', $groupInfo, 'POST');
        return $result;
    }

    /*
    * 更新群组信息
    * @param $groupId int 群组id  必填
    * $param $groupInfo array 群组信息 必填
    * 参数说明：
    * $groupInfo = array( "groupname":"testrestgrp12", //群组名称 可选
    "description":"update groupinfo", //群组描述 可选
    "maxusers":300, //群组成员最大数(包括群主), 值为数值类型 可选
    )
    */

    public function updateGroup($groupId, $groupInfo = array())
    {
        $result = $this->request('chatgroups' . '/' . $groupId, $groupInfo, 'PUT');
        return $result;
    }
    /*
    * 群组删除
    * @param $groupId 必填 群组ID Stirng
    */
    public function deleteGroup($groupId)
    {
        $result = $this->request('chatgroups' . '/' . $groupId, '', 'DELETE');
        return $result;
    }
    /*
    * 获取群组用户
    * @param $groupId 必填 群组ID Stirng
    */
    public function getGroupUsers($groupId)
    {
        $result = $this->request('chatgroups' . '/' . $groupId . '/users', '', 'GET');
        return $result;
    }
    /*
    * 群组批量加人
    * @param $groupId 必填 群组ID Stirng
    * @param $users 必填    用户名  mix(String,array)
    */
    public function addGroupUsers($groupId, $users)
    {
        if (gettype($users) != 'array') {
            $users[] = $users;
        }
        $data['usernames'] = $users;
        $result = $this->request('chatgroups' . '/' . $groupId . '/users', $data, 'POST');
        return $result;
    }

    /*
    * 群组减人：从群中移除某个成员。
    * @param $groupId 群组id 必填 String
    * @param $user 用户名 必填 String
    */
    public function deleteGroupUser($groupId, $user)
    {
        $result = $this->request('chatgroups' . '/' . $groupId . '/users/' . $user, '',
            'DELETE');
        return $result;
    }
    /*
    * 获取一个用户参与的所有群组
    * $user String 用户名 必填
    */
    public function getUserGroups($user)
    {
        $result = $this->request('users/' . $user . '/joined_chatgroups', '', 'GET');
        return $result;
    }
    /*
    * ------------------------------------
    * 群组方法             结束
    * ------------------------------------
    */

}
