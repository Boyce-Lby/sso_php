<?php
include '../mod/lbySessionHandler.php';

$session = new lbySessionHandler(array(
    'HOST'=>'127.0.0.1',
    'PORT'=>'6379'
));
session_set_save_handler($session,true);
$sessionId = $_POST['sessionId'];
session_id($sessionId);
session_start();
if(!isset($_SESSION['userid'])){
    $userid = $_COOKIE['userid'];
    setcookie('userid',"",time()-3600,'/');
    $_SESSION['userid'] = $userid;
}
echo json_encode(array('auth'=>'SUC','sessionId'=>$sessionId,'userid'=>$_SESSION['userid']));
