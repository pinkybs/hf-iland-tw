<?php

require_once 'Hapyfish2/Application/Abstract.php';

class Hapyfish2_Application_SnsplusKimo extends Hapyfish2_Application_Abstract
{
    protected $_rest;

    protected $_puid;

    protected $_platformUid;

    protected $_session_key;

    protected $_hfskey;

    public $newuser;

    public $params;

    public $hf_params;

    public $data;

    /**
     * Singleton instance, if null create an new one instance.
     *
     * @param Zend_Controller_Action $actionController
     * @return Hapyfish2_Application_SnsplusKimo
     */
    public static function newInstance(Zend_Controller_Action $actionController)
    {
        if (null === self::$_instance) {
            self::$_instance = new Hapyfish2_Application_SnsplusKimo($actionController);
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

    public function getPlatformUid()
    {
    	return $this->_puid;
    }

    public function getRest()
    {
    	return $this->_rest;
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
        $user['figureurl'] = $data['headurl'];
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

    /**
     * _init()
     *
     * @return void
     */
    protected function _init()
    {
//info_log('request:'.json_encode($_REQUEST), 'frompt');

    	$request = $this->getRequest();
        $this->_rest = Snsplus_RestApi::getInstance();
    	if (!$this->_rest) {
            echo 'failed rest api from snsplus';
            exit;
        }
//info_log('param:'.json_encode($this->_rest->getParameters()), 'frompt');
//info_log($this->_rest->getPlatformScript(), 'aaa');
//info_log($this->_rest->getPlatformAppUrl(), 'aaa');

        $param = $this->_rest->getParameters();

        $sessionKey = $this->_rest->getToken();
        $puid = $this->_rest->getUserId();
        if (empty($sessionKey) || empty($puid)) {
            echo 'auth token or user id empty';
            exit;
        }

        $gameUrl = $this->_rest->getPlatformAppUrl();

        //from snsplus parameter
        $data = array();
        $data["user_id"] = $puid;
        $data["oauth_token"] = $sessionKey;

        //first time app
		if (empty($data["user_id"])) {
			echo("<script> top.location.href='" . $gameUrl . "'</script>");
			exit;
		}
		//$this->_rest->setUser($puid, $sessionKey);

        //OK
        $this->_appId = APP_ID;
        $this->_appName = APP_NAME;
        $this->_puid = $puid;
        $this->_platformUid = $param['me']['platform_uid'];
        $this->_session_key = $sessionKey;
        $this->hf_params = $this->get_hf_params($_POST+$_GET);
        $this->newuser = false;
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

        //真实平台uid 非snsplus uid
        $vuid = Hapyfish2_Platform_Cache_User::getVUID($uid);
        if (empty($vuid) || $this->_platformUid != $vuid) {
            Hapyfish2_Platform_Cache_User::updateVUID($uid, $this->_platformUid);
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
        $domain = str_replace('http://', '.', HOST);
        setcookie('hf_skey', $skey , 0, '/', $domain);
    }

}