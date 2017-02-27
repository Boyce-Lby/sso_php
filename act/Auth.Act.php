<?php
/**
 * ************
 * sso入口文件
 * ************
 */
namespace act;
class Auth{
    private $urlArr = array(
        'http://client.me',
        'http://client1.me'
    );
    private $table = 'user';
    private $db;
    
    public function __construct(){
        $this->db = \lib\Db\Db::Instance();
    }
    
    private function authUrl(){
        $origin = $_SERVER['HTTP_ORIGIN'];
        if (in_array($origin, $this->urlArr)) {
            header("Access-Control-Allow-Origin:" . $origin);
            header("Access-Control-Allow-Credentials: true ");
        }else{
            echo "error!";
            exit;
        }
    }
    
    public function checkLogin(){
        $this->authUrl();
        session_start();
        if(!isset($_COOKIE['usertoken'])){
            echo json_encode(array('login'=>'no'));
        }elseif(isset($_COOKIE['usertoken']) && $_COOKIE['usertoken'] == $_SESSION['token']){
            //Éú³ÉÒ»¸öÁÙÊ±token
            $tmptoken = \Common::str_random();
            $_SESSION[$_SESSION['token']] = $tmptoken;
            echo json_encode(array('login'=>'yes','tmptoken'=>$tmptoken));
        }
    }
    public function checkToken(){
        $this->authUrl();
        session_start();
        if(isset($_POST['token'])){
            setcookie('usertoken',$_POST['token'],null);
            setcookie('userid',$_POST['userid'],null);
            $_SESSION['token'] = $_POST['token'];
            echo json_encode(array('auth'=>'SUC'));
        }
    }
    
    public function authUser(){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        // $res = $this->db->table($this->table)->field("id,pwd,email")->where("uname='{$username}'")->find();
        // $res = $this->db->sql("SELECT id,pwd,email from user WHERE uname = '123123'");
        $res['pwd'] = md5('123123');
        if(!$res){
            echo json_encode(array('auth'=>'FAIL'));
        }else{
            if($res['pwd'] == $password){
                $token = \Common::str_random();
                echo json_encode(array('auth'=>'SUC','token'=>$token,'userid'=>'1'));
            }
        }
    }
    
    public function authToken(){
        $this->authUrl();
        session_start();
        $tmptoken = $_POST['tmptoken'];
        if($tmptoken == $_SESSION[$_SESSION['token']]){
            unset($_SESSION[$_SESSION['token']]);
            echo json_encode(array('auth'=>'SUC','userid'=>$_COOKIE['userid'],'sessionId'=>session_id()));
        }else{
            echo json_encode(array('auth'=>'FAIL'));
        }
    }
    public function logout(){
        $this->authUrl();
        setcookie('usertoken',"",time()-3600,'/');
        setcookie('userid',"",time()-3600,'/');
        session_start();
        setcookie('PHPSESSID',"",time()-3600,'/');
        unset($_SESSION['token']);
        echo json_encode(array('logout'=>"SUC","sessionId"=>session_id()));
    }
}
