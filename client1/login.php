<?php
$username = $_POST['username'];
$password = $_POST['password'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://text.me/?c=Auth&a=authUser");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, array('username'=>$username,'password'=>$password));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
// var_dump($data);die;
$res = json_decode($data);
if($res->auth == 'SUC'){
    setcookie('userid',$res->userid,null,'/');
}
echo $data;