<?php

class Snsplus_Rest_Snsplus {
    const VERSION = '2.0';
    public $api_client;
    private $api_key;
    private $secret;
    private $user;
    private $userinfo;
    private $signed_request = null;
    private $token = null;
    private $platform;
    private $lang;
    private $params = array();

    public function __construct($api_key, $secret, $process_request_params = true) {
        $this->api_key = $api_key;
        $this->secret = $secret;

        $this->api_client = new Snsplus_Rest_Client($api_key, $secret);
        if($process_request_params){
            $this->validate_params();
        }
    }

    /**
     * 設置server_addr
     */
    public function set_server_addr($addr) {
        $this->api_client->set_server_addr($addr);
    }

    /**
     *
     * 獲取當前用戶
     */
    public function get_loggedin_user() {
        return $this->user;
    }

    /**
     * 獲取當前用戶信息
     */
    public function get_userinfo() {
        return $this->userinfo;
    }

    /**
     * 參數處理與驗證
     *
     * @return boolean
     */
    private function validate_params() {
        $this->params = self::stripslashes($_GET) + self::stripslashes($_POST);

        $userinfo = null;
        $user = null;

        $signed_request = $this->get_param('signed_request');
        if(! empty($signed_request)){
            $this->params = $this->parse_signed_request($signed_request, $this->secret);
            $userinfo = $this->get_param('me');
            $user = isset($userinfo['id']) ? $userinfo['id'] : null;
            $this->signed_request = $signed_request;
        }
        $token = $this->get_param('token');
        if(empty($token)){
            throw new Exception('Invalid token value');
        }
        $this->userinfo = $userinfo;
        $this->platform = $this->get_param('platform');
        $this->lang = $this->get_param('lang');
        $this->set_user($user, $token);
    }

    /**
     * 获取傳遞的参数
     */
    public function get_param($name, $default = null) {
        $name = (string)$name;
        return isset($this->params[$name]) ? $this->params[$name] : $default;
    }
    /**
     * 獲取所有參數
     */
    public function get_params() {
        return $this->params;
    }
    /**
     * 設置SINGED_REQUEST
     */
    public function set_signed_request($signed_request) {
        if(! empty($signed_request)){
            $this->params = $this->parse_signed_request($signed_request, $this->secret);

            $token = $this->get_param('token');
            if(empty($token)){
                throw new Exception('Invalid token value');
            }
            $userinfo = $this->get_param('me');
            $user = isset($userinfo['id']) ? $userinfo['id'] : null;
            $this->platform = $this->get_param('platform');
            $this->lang = $this->get_param('lang');

            $this->userinfo = $userinfo;
            $this->set_user($user, $token);
            $this->signed_request = $signed_request;
        }
    }

    /**
     * 獲取signed_request
     */
    public function get_signed_request() {
        return $this->signed_request;
    }

    /**
     * 設置Token
     */
    public function set_auth_token($token) {
        if(! empty($token)){
            $this->userinfo = null;
            $user = null;
            $this->set_user($user, $token);
        }
    }

    /**
     * 獲取token
     */
    public function get_auth_token() {
        return $this->token;
    }

    /**
     * 返回平台名稱
     */
    public function get_platform() {
        return $this->platform;
    }

    /**
     * 返回語言代碼
     */
    public function get_lang() {
        return $this->lang;
    }

    /**
     * 設定當前用戶
     *
     * @param string $user
     * @param string $auth_token
     */
    public function set_user($user, $auth_token) {
        $this->user = $user;
        $this->token = $auth_token;
        $this->api_client->set_auth_token($auth_token);
    }

    /**
     *
     * 解密数据
     *
     * @param string $input 待解密的数据
     * @param string $secret
     * @param int $max_age 最大有效时间
     * @throws Exception
     */
    private function parse_signed_request($input, $secret, $max_age = 86400) {
        list($encoded_sig, $encoded_envelope) = explode('.', $input, 2);
        $envelope = json_decode(self::base64_url_decode($encoded_envelope), true);
        $algorithm = $envelope['algorithm'];

        if($algorithm != 'AES-256-CBC HMAC-SHA256' && $algorithm != 'HMAC-SHA256'){
            throw new Exception('Invalid request. (Unsupported algorithm.)');
        }

        if($envelope['issued_at'] < time() - $max_age){
            throw new Exception('Invalid request. (Too old.)');
        }

        if(self::base64_url_decode($encoded_sig) != hash_hmac('sha256', $encoded_envelope, $secret, true)){
            throw new Exception('Invalid request. (Invalid signature.)');
        }

        // for requests that are signed, but not encrypted, we're done
        if($algorithm == 'HMAC-SHA256'){
            return $envelope;
        }

        // otherwise, decrypt the payload
        return json_decode(trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $secret, self::base64_url_decode($envelope['payload']), MCRYPT_MODE_CBC, self::base64_url_decode($envelope['iv']))), true);
    }

    /**
     *
     * Base64解碼
     * @param string $input
     */
    private static function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * 移除斜线
     */
    private static function stripslashes($data) {
        ! defined('__MAGIC_QUOTES_GPC') && define('__MAGIC_QUOTES_GPC', function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc());
        if(__MAGIC_QUOTES_GPC){
            if(is_array($data)){
                foreach($data as $key => $value){
                    $data[$key] = self::stripslashes($value);
                }
                return $data;
            }else{
                return stripslashes($data);
            }
        }else{
            return $data;
        }
    }
}
?>