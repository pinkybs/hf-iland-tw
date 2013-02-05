<?php

require_once 'Hapyfish2/Application/Abstract.php';

class Hapyfish2_Application_Facebook extends Hapyfish2_Application_Abstract
{
    protected $_rest;

    protected $_puid;

    protected $_session_key;

    protected $_hfskey;

    public $newuser;

    public $params;

    public $fb_params;

    public $hf_params;

    public $data;

    /**
     * Singleton instance, if null create an new one instance.
     *
     * @param Zend_Controller_Action $actionController
     * @return Hapyfish2_Application_Facebook
     */
    public static function newInstance(Zend_Controller_Action $actionController)
    {
        if (null === self::$_instance) {
            self::$_instance = new Hapyfish2_Application_Facebook($actionController);
        }

        return self::$_instance;
    }

    public function get_params()
    {
		$this->params = array(
			'session_key' => $_GET['session_key'],
			'sig' => $_GET['sig']
		);

		$tmp = explode('_', $_GET['session_key']);
		$this->params['puid'] = $tmp[0];

		return $this->params;
    }

	public function get_valid_fb_params($params, $timeout = null, $namespace = 'fb_sig')
    {
        if (empty($params)) {
            return array();
        }

        $prefix = $namespace . '_';
        $prefix_len = strlen($prefix);
        $fb_params = array();

        foreach ($params as $name => $val) {
            if (strpos($name, $prefix) === 0) {
                $fb_params[substr($name, $prefix_len)] = $val;
            }
        }

        // validate that the request hasn't expired. this is most likely
        // for params that come from $_COOKIE
        if ($timeout && (!isset($fb_params['time']) || time() - $fb_params['time'] > $timeout)) {
            return array();
        }

        // validate that the params match the signature
        $signature = isset($params[$namespace]) ? $params[$namespace] : null;

        if (!$signature || (!$this->_rest->verifySignature($fb_params, $signature))) {
            //return array();
        }

        return $fb_params;
    }

    public function get_hf_params($params, $namespace = 'hf')
    {
        if (empty($params)) {
            return array();
        }

        $prefix = $namespace . '_';
        $prefix_len = strlen($prefix);
        $hf_params = array();
        foreach ($params as $name => $val) {
            if (strpos($name, $prefix) === 0) {
                $hf_params[$name] = $val;
            }
        }

        return $hf_params;
    }

    public function validate_fb_params()
    {
        $this->fb_params = $this->get_valid_fb_params($_GET, 48*3600, 'fb_sig');

        if (!$this->fb_params) {
            $this->fb_params = $this->get_valid_fb_params($_POST, 48*3600, 'fb_sig');
        }

        return !empty($this->fb_params);
    }

    public function getPlatformUid()
    {
    	return $this->_puid;
    }

    public function getRest()
    {
    	return $this->_rest;
    }

    public function getSessionKey()
    {
    	return $this->_session_key;
    }

    public function isNewUser()
    {
    	return $this->newuser;
    }

    protected function _getUser($data)
    {
        $user = array();
        $user['uid'] = '' . $this->_userId;
        $user['puid'] = $data['uid'];
        $user['name'] = $data['name'];
        $user['vuid'] = $data['email'];
        $user['figureurl'] = $data['tinyurl'];
        $sex = isset($data['sex']) ? $data['sex'] : '';
        if ($sex == '1') {
            $gender = 1;
        } else if ($sex == '0') {
            $gender = 0;
        } else {
            $gender = -1;
        }
        $user['gender'] = $sex;

        return $user;
    }

    public function validateFb($signed_request)
    {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

		// decode the data
        $sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
        $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);

        if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
            echo 'Unknown algorithm. Expected HMAC-SHA256';
            exit;
        }

        // check sig
        $expected_sig = hash_hmac('sha256', $payload, APP_SECRET, $raw = true);
        if ($sig !== $expected_sig) {
            echo 'Bad Signed JSON signature!';
            exit;
        }
        return true;
    }

    protected function _fromFb()
    {
        $signed_request = $this->getRequest()->getParam('signed_request');
		list($encoded_sig, $payload) = explode('.', $signed_request, 2);
		$data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
		return $data;
    }

    protected function _fromSnsplus()
    {
        $args = array();
        parse_str(trim($_COOKIE['fbs_' . APP_ID], '\\"'), $args);
        //info_log($_COOKIE['fbs_' . APP_ID], 'test_snsplus');
        ksort($args);
        $payload = '';
        foreach ($args as $key => $value) {
            if ($key != 'sig') {
              $payload .= $key . '=' . $value;
            }
        }
        if (md5($payload . APP_SECRET) != $args['sig']) {
            return null;
        }

        $retData = array();
        $retData['user_id'] = $args['uid'];
        $retData['oauth_token'] = $args['access_token'];
        return $retData;
    }

    /**
     * _init()
     *
     * @return void
     */
    protected function _init()
    {
        $request = $this->getRequest();

        $this->_rest = Facebook_Client2::getInstance();
    	if (!$this->_rest) {
            echo 'failed rest api from fb';
            exit;
        }

        $app_id = APP_ID;
		$canvas_page = HTTP_PROTOCOL.'apps.facebook.com/'. APP_NAME . '/?request_ids='.$request->getParam('request_ids');
		$auth_url = HTTP_PROTOCOL."www.facebook.com/dialog/oauth?client_id=" . $app_id . "&scope=email,read_stream,user_likes&redirect_uri=" . urlencode($canvas_page);

		$entrance = $request->getParam('entrance');
		//info_log(json_encode($_REQUEST), 'test_snsplus');
		//from snsplus
        if ('connect' == $entrance) {
            $data = $this->_fromSnsplus();
            if (empty($data)) {
                echo 'failed to get data from snsconnect';
                exit;
            }
            $log = Hapyfish2_Util_Log::getInstance();
            $log->report('snsconnect', array($data['user_id']));
        }
        //from fb
        else {
            $this->validateFb($request->getParam('signed_request'));
            $data = $this->_fromFb();
            //first time app
    		if (empty($data["user_id"])) {
    			echo("<script> top.location.href='" . $auth_url . "'</script>");
    			exit;
    		}
    		else {
    			if (!$data["user_id"]) {
    				echo 'failed rest api user id is null ';
    				exit;
    			}
    		}
        }

		$puid = $data["user_id"];
		$sessionKey = $data["oauth_token"];
		$this->_rest->setUser($puid,$sessionKey);

        //OK
        $this->_appId = APP_ID;
        $this->_appName = APP_NAME;
        $this->_puid = $puid;
        $this->_session_key = $sessionKey;
        $this->hf_params = $this->get_hf_params($_POST);
        $this->newuser = false;

        $this->data = $data;
    }

    protected function _updateInfo()
    {
    	$userData = $this->_rest->getUser();

    	if (!$userData) {
    		throw new Hapyfish2_Application_Exception('get user info error' . $this->_puid);
    	}

    	$puid = $this->_puid;
    	if ($puid != $userData['uid']) {
    		throw new Hapyfish2_Application_Exception('platform uid error' . $this->_puid);
    	}

    	try {
    		$uidInfo = Hapyfish2_Platform_Cache_UidMap::getUser($puid);
    		//first coming
    		if (!$uidInfo) {
    			$uidInfo = Hapyfish2_Platform_Cache_UidMap::newUser($puid);
    			if (!$uidInfo) {
    				throw new Hapyfish2_Application_Exception('generate user id error' . $this->_puid);
    			}
    			$this->newuser = true;
    		}
    	} catch (Exception $e) {
    	    info_log($e->getMessage(), 'pt-err');
    		throw new Hapyfish2_Application_Exception('get user id error' . $this->_puid);
    	}

        $uid = $uidInfo['uid'];
        if (!$uid) {
        	throw new Hapyfish2_Application_Exception('user id error' . $this->_puid);
        }

        $this->_userId = $uid;

        $user = $this->_getUser($userData);

        if ($this->newuser) {
        	Hapyfish2_Platform_Bll_User::addUser($user);
        	//add log
        	$logger = Hapyfish2_Util_Log::getInstance();
        	$logger->report('100', array($uid, $puid, $user['gender']));
        } else {
        	Hapyfish2_Platform_Bll_User::updateUser($uid, $user, true);
        }

        $fids = $this->_rest->getFriendIds();

        if ($fids !== null) {
        	//这块可能会出现效率问题，fids很多的时候，memcacehd get次数会很多
        	//优化方案，先根据fid切分到相应的memcached组，用getMulti方法，减少次数
        	$fids = Hapyfish2_Platform_Bll_User::getUids($fids);
			if ($this->newuser) {
        		Hapyfish2_Platform_Bll_Friend::addFriend($uid, $fids);
        	} else {
        		Hapyfish2_Platform_Bll_Friend::updateFriend($uid, $fids);
        		//Hapyfish2_Platform_Bll_Friend::addFriend($uid, $fids);
        	}
        }

        //email
        $email = Hapyfish2_Platform_Cache_User::getVUID($uid);
        if (empty($email)) {
            $email = $user['vuid'];
            Hapyfish2_Platform_Cache_User::updateVUID($uid, $email);
        }
    }

    public function getSKey()
    {
    	return $this->_hfskey;
    }

    /**
     * run() - main mothed
     *
     * @return void
     */
    public function run()
    {
		$this->_updateInfo();

        //P3P privacy policy to use for the iframe document
        //for IE
        header('P3P: CP=CAO PSA OUR');

        $uid = $this->_userId;
        $puid = $this->_puid;
        $session_key = $this->_session_key;
        $t = time();
        $rnd = mt_rand(1, ECODE_NUM);

        $sig = md5($uid . $puid . $session_key . $t . $rnd . APP_KEY);

        $skey = $uid . '.' . $puid . '.' . base64_encode($session_key) . '.' . $t . '.' . $rnd . '.' . $sig;
        $this->_hfskey = $skey;
        $domain = str_replace(HTTP_PROTOCOL, '.', HOST);
        setcookie('hf_skey', $skey , 0, '/', $domain);
    }

}