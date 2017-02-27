<?php
/**
 * ************
 * Common类 定义一些公共函数
 * ************
 */
class Common{
    const chars = 'abcdefgABCDEFG012hijklmnHIJKLMN3456opqrstOPQRST789UVWXYZuvwxyz';
    
    
    static public function str_random(){
        //随机生成token串
        $chars = self::chars;
        $token = '';
        for($i = 0; $i < 5; $i++){
            $str = substr($chars,0,mt_rand(0, strlen($chars)-1));
            $token .= $str.$chars[mt_rand(0, strlen($str)-1)];
        }
        $token = md5($token);
        return $token;
    }
    
    /**
     * 自定义实现json_encode功能的函数
     * @param mixed $data
     */
    static public function onmpw_json_encode($data){
        if(is_object($data)) return false;
        if(is_array($data)){
            $data = self::deal_array($data);
        }
        return urldecode(json_encode($data));
    }
    static private function deal_array($data){
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                if (is_array($val)) {
                    $data[$key] = self::deal_array($val);
                } else {
                    $data[$key] = urlencode($val);
                }
            }
        } elseif (is_string($data)) {
            $data = urlencode($data);
        }
        return $data;
    }
	
}