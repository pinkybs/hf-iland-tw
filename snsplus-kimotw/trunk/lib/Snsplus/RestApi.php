<?php

class Snsplus_RestApi
{
    public $api_key;
    public $secret;
    public $app_id;
    public $app_name;
    public $user_id;

    public $rest;

    protected static $_instance;

    /**
     * get instance object
     *
     * @return Snsplus_RestApi
     */
    public static function getInstance($process_request_params = true)
    {
        if (self::$_instance == null) {
            self::$_instance = new self(APP_KEY, APP_SECRET, APP_ID, APP_NAME, $process_request_params);
        }

        return self::$_instance;
    }

    public function __construct($api_key, $secret, $app_id, $app_name, $process_request_params = true)
    {
        $this->api_key = $api_key;
        $this->secret = $secret;
        $this->app_id = $app_id;
        $this->app_name = $app_name;

        $this->rest = new Snsplus_Rest_Snsplus($this->api_key, $this->secret, $process_request_params);
        $this->rest->set_server_addr(API_SERVER_ADDR);
    }

    public function setUser($user_id, $token)
    {
        try {
            $this->user_id = $user_id;
            $this->rest->set_user($user_id, $token);
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::setUser]: ' . $e->getMessage(), 'RestApi_Err');
        }
    }

    //get token
    public function getToken()
    {
        try {
            $data = $this->rest->get_auth_token();
            if($data) {
                return $data;
            }
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::getToken]: ' . $e->getMessage(), 'RestApi_Err');
        }
        return null;
    }

    //get params
    public function getParameters()
    {
        try {
            $data = $this->rest->get_params();
            if($data) {
                return $data;
            }
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::getParameters]: ' . $e->getMessage(), 'RestApi_Err');
        }
        return null;
    }

    //get snsplus id
    public function getUserId()
    {
        try {
            $data = $this->rest->get_loggedin_user();
            if($data) {
                return $data;
            }
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::getUserId]: ' . $e->getMessage(), 'RestApi_Err');
        }
        return null;
    }

    //get real platform id
    public function getUserPlatformId()
    {
        try {
            $data = $this->rest->api_client->user_getPlatformUser();
            if($data) {
                return $data;
            }
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::getUserPlatformId]: ' . $e->getMessage(), 'RestApi_Err');
        }
        return null;
    }

    //get user
    public function getUser()
    {
        try {
            $data = $this->rest->api_client->user_getInfo(null, 'id, name, birthday,gender, pic, about');
            if(isset($data)) {
                $user = array();
                $user['uid'] = $data['id'];
                $user['name'] = $data['name'];
                $user['sex'] = -1;
                if ($data['gender'] == 'M') {
                    $user['sex'] = 1;
                }
                else if ($data['gender'] == 'F') {
                    $user['sex'] = 0;
                }
                $user['headurl'] = $data['pic'];
                return $user;
            }
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::getUser]: ' . $e->getMessage(), 'RestApi_Err');
        }
        return null;
    }

    //get app friend uids
    public function getFriendIds()
    {
        try {
            $data = $this->rest->api_client->friends_getAppUsers();
            if ($data) {
                return $data;
            }
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::getFriendIds]: ' . $e->getMessage(), 'RestApi_Err');
        }
        return null;
    }

    //get  friend info
    public function getFriends($fids)
    {
        try {
            $strFids = implode(',', $fids);
            $data = $this->rest->api_client->user_getBatchInfo($strFids, 'id, name, birthday,gender, pic, about');
            if ($data) {
                $friends = array();
                foreach ($data as $v) {
                   $friends[$v['id']] = array('uid' => $v['id'], 'name' => $v['name'], 'headurl' => $v['pic']);
                }
                return $friends;
            }
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::getFriends]: ' . $e->getMessage(), 'RestApi_Err');
        }
        return null;
    }

    //get payment url
    public function getPaymentUrl($gameCode=null, $isTest=0)
    {
        try {
            $data = $this->rest->api_client->user_getPaymentUrl($gameCode, $isTest);
            if ($data) {
                return $data;
            }
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::getPaymentUrl]: ' . $e->getMessage(), 'RestApi_Err');
        }
        return null;
    }

    //get platform
    public function getPlatformName()
    {
        try {
            $data = $this->rest->api_client->platform_getName();
            if ($data) {
                return $data;
            }
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::getPlatformName]: ' . $e->getMessage(), 'RestApi_Err');
        }
        return null;
    }

    //get platform application url
    public function getPlatformAppUrl()
    {
        try {
            $data = $this->rest->api_client->platform_getApplicationUrl();
            if ($data) {
                return $data;
            }
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::getPlatformAppUrl]: ' . $e->getMessage(), 'RestApi_Err');
        }
        return null;
    }

    //get platform script
    public function getPlatformScript()
    {
        try {
            $data = $this->rest->api_client->platform_getScript();
            if ($data) {
                return $data;
            }
        }
        catch (Exception $e) {
            info_log('[Snsplus_RestApi::getPlatformScript]: ' . $e->getMessage(), 'RestApi_Err');
        }
        return null;
    }
}