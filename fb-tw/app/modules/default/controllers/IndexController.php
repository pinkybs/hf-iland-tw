<?php

require_once(CONFIG_DIR . '/language.php');

/**
 * island index controller
 *
 * @copyright  Copyright (c) 2010 HapyFish
 * @create      2010/10    lijun.hu
 */
class IndexController extends Zend_Controller_Action
{
    public function init()
    {
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->staticUrl = STATIC_HOST;
        $this->view->hostUrl = HOST;
        $this->view->appId = APP_ID;
        $this->view->appKey = APP_KEY;
    }

    protected function getClientIP()
    {
    	$ip = false;
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ips = explode (', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
			if ($ip) {
				array_unshift($ips, $ip);
				$ip = false;
			}
			for ($i = 0, $n = count($ips); $i < $n; $i++) {
				if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
					$ip = $ips[$i];
					break;
				}
			}
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
    }

    public function indexAction()
    {
        /*$sig_api_key = $this->_request->getParam('signed_request');
    	if (empty($sig_api_key)) {
    		echo 'Error sig';
    		exit;
    	}*/
//info_log($this->_request->getParam('signed_request'), 'aa');

    	if (APP_STATUS == 0) {
    		$stop = true;
    		if (APP_STATUS_DEV == 1) {
    			$ip = $this->getClientIP();
	    		if ($ip == '27.115.48.202' || $ip == '122.147.63.223' || $ip == '114.32.107.235') {
	    			$stop = false;
	    		}
    		}
    		if ($stop) {
    			header('Location: ' . STATIC_HOST . '/maintance/index.html?v=' . date('YmdHi'));
    			exit;
    		}
    	}

    	$isAppLoadErr = false;
    	try {
    		$application = Hapyfish2_Application_Facebook::newInstance($this);
        	$application->run();
    	} catch (Exception $e) {
    	    $puid = $application->getPlatformUid();
    	    if (empty($puid)) {
    	        //echo '加载数据出错，请重新进入。';
        		echo '<div style="text-align:center;margin-top:30px;"><img src="' . STATIC_HOST . '/maintance/images/problem1.gif" alt="加载数据出错，请重新进入" /></div>';
        		exit;
    	    }
    	    //api called error or memcached can not reached or server sth err
    	    $isAppLoadErr = true;
    		$log = Hapyfish2_Util_Log::getInstance();
            $log->report('appLoadErr', array($puid, $e->getMessage()));
            err_log($e->getMessage());
            $errMsg = $e->getMessage();
    	}

        //check if can login game and play temperately
    	if ($isAppLoadErr) {
    	    $ptUser = Hapyfish2_Platform_Bll_UidMap::getUser($puid);
    	    if (empty($ptUser)) {
    	        //echo '加载数据出错，请重新进入。';
    	        $log = Hapyfish2_Util_Log::getInstance();
                $log->report('appFailLogin', array($puid, $errMsg));
        		echo '<div style="text-align:center;margin-top:30px;"><img src="' . STATIC_HOST . '/maintance/images/problem1.gif" alt="加载数据出错，请重新进入" /></div>';
        		exit;
    	    }

            $uid = $ptUser['uid'];
            $isnew = false;
            $platformUid = $ptUser['puid'];
            $sessionKey = $application->getSessionKey();

            header('P3P: CP=CAO PSA OUR');
            $t = time();
            $rnd = mt_rand(1, ECODE_NUM);
            $sig = md5($uid . $platformUid . $sessionKey . $t . $rnd . APP_KEY);
            $skey = $uid . '.' . $platformUid . '.' . base64_encode($sessionKey) . '.' . $t . '.' . $rnd . '.' . $sig;
            setcookie('hf_skey', $skey , 0, '/', str_replace(HTTP_PROTOCOL, '.', HOST));
    	}
    	//normally in game
    	else {
    	    $uid = $application->getUserId();
            $isnew = $application->isNewUser();
            $platformUid = $application->getPlatformUid();
            $sessionKey = $application->getSessionKey();
    	}

        $data = array('uid' => $uid, 'puid' => $platformUid, 'session_key' => $sessionKey);
        $context = Hapyfish2_Util_Context::getDefaultInstance();
        $context->setData($data);
        	
        if ($isnew) {
            $this->view->requestId = '';
			$ok = Hapyfish2_Island_Bll_User::joinUser($uid);
        	Hapyfish2_Island_Event_Bll_Timegift::setup($uid);
        	if (!$ok) {
    			echo LANG_PLATFORM_INDEX_TXT_10;
    			exit;
        	}

            //是否邀请好友完成
        	$requestIds = $this->_request->getParam('request_ids');
        	if ($requestIds) {
        		$rstIvt = Hapyfish2_Island_Bll_Invite::fbInviteDone($requestIds, $platformUid);
        		if ($rstIvt) {
        		    $this->view->requestId = $requestIds . '_' . $platformUid;
        		}
        	}
        } else {
        	$isAppUser = Hapyfish2_Island_Cache_User::isAppUser($uid);
        	if (!$isAppUser) {
        		$ok = Hapyfish2_Island_Bll_User::joinUser($uid);
        	    if (!$ok) {
    				echo LANG_PLATFORM_INDEX_TXT_10;
    				exit;
        		}
        	} else {
        		$status = Hapyfish2_Platform_Cache_User::getStatus($uid);
        		if ($status > 0) {
        			if ($status == 1) {
        				$msg = str_replace('{*uid*}', $uid, LANG_PLATFORM_INDEX_TXT_12);
        			} else if ($status == 2) {
        				$msg = str_replace('{*uid*}', $uid, LANG_PLATFORM_INDEX_TXT_13);
        			} else if ($status == 3)  {
        				$msg = str_replace('{*uid*}', $uid, LANG_PLATFORM_INDEX_TXT_14);
        			} else {
        				$msg = str_replace('{*uid*}', $uid, LANG_PLATFORM_INDEX_TXT_15);
        			}

        			echo $msg;
        			exit;
        		}

        	}
        }

        $pgiftTF = Hapyfish2_Island_Bll_Permissiongift::getval($uid);
        $this->view->pgiftTF = $pgiftTF;
        if( empty( $pgiftTF ) ) {
        	$lfb = Facebook_Client2::getInstance();
	        $lfb->setUser($application->data['user_id'], $application->data['oauth_token']);
	        $isfanTF = $lfb->getIsFan(); // true|false
        	$isfanTF = $isfanTF === true ? '1' : '0';

	        if( $isfanTF ) {
	        	$pgTF = Hapyfish2_Island_Bll_Permissiongift::setval($uid);
	        	if( $pgTF === true ) {
	        		$info = array('gold'=>10, 'type'=>10);
	        		Hapyfish2_Island_Bll_Gold::add($uid, $info);
	        		$this->view->pgiftTF = '1';
	        		$this->view->isfanTF = '1';
	        	}

	        } else {
	        	$this->view->isfanTF = $isfanTF;
	        }
        }

        //update friend count achievement
		$count = Hapyfish2_Platform_Bll_Friend::getFriendCount($uid);
        if ($count > 0) {
        	$achievement = Hapyfish2_Island_HFC_Achievement::getUserAchievement($uid);
        	if ($achievement['num_16'] < $count) {
        		$achievement['num_16'] = $count;
				try {
        			Hapyfish2_Island_HFC_Achievement::saveUserAchievement($uid, $achievement);

					//task id 3018,task type 16
					Hapyfish2_Island_Bll_Task::checkTask($uid, 3018);
				} catch (Exception $e) {
				}
        	}
        }

        $notice = Hapyfish2_Island_Cache_BasicInfo::getNoticeList();
        if (empty($notice)) {
        	$this->view->showNotice = false;
        } else {
        	$this->view->showNotice = true;
			$this->view->mainNotice = $notice['main'];
			$this->view->subNotice = $notice['sub'];
			$this->view->picNotice = $notice['pic'];
        }

        $this->view->uid = $uid;
        $rowUser = Hapyfish2_Platform_Bll_User::getUser($uid);
        $tmp = str_replace("'", "\'", $rowUser['name']);
        $tmp = str_replace('"', '\"', $tmp);
        $this->view->uname = str_replace("'", "\'", $tmp);
        $this->view->platformUid = $platformUid;
        $this->view->showpay = true;
        $this->view->newuser = $isnew ? 1 : 0;
        $this->view->iswatch = 0;

        $constCode = 'JKikd*l;21%@*(1Dad^';
		//$uid = $uid;
		$platform = 'fb';
		$game = 'fb_island';
		$time = time();
		$checkcode = md5($uid.$constCode.$time);
		//$this->view->faqUrl = 'http://feedback.snsplus.com/?uid=' . $platformUid . '&platform=' . $platform . '&game=' .$game . '&checkcode=' . $checkcode . '&time='.$time;
		//$this->view->faqUrl = 'mailto:service@snsplus.com?body=' . $platformUid . '&platform=' . $platform . '&game=' .$game . '&checkcode=' . $checkcode . '&time='.$time;
		
        $secret = '7a6715e71bce1c7b3852887ea4e054c9';
        $midPuid = Hapyfish2_Island_Tool_Island::encode($platformUid);
        
		$urlParams = array('time' => $time,
        				'platform_uid' => $midPuid,
        				'game_coding' => 'AIFSAA');
        
        $platSig = Hapyfish2_Island_Tool_Island::generate_sig($urlParams, $secret);
     	$urlParams['cs_sig'] = $platSig;
     	$urlParams = self::append_namespace($urlParams);
		$this->view->faqUrl = 'http://cs.gamagic.com/issue/?' . http_build_query($urlParams);
		$snsCode = md5('game_code='.APP_NAME.'time='.$time.'uid='.$platformUid.APP_SECRET);
		$this->view->snsUrl = 'http://sn.service.snsplus.com/?game_code='.APP_NAME.'&uid='.$platformUid.'&time='.$time.'&sig='.$snsCode;


    	/* for 外联通  20110702 */
		$this->view->connectSnsplus = '';
        $entrance = $this->_request->getParam('entrance');
        //from snsplus
        if ('connect' == $entrance) {
            $this->view->connectSnsplus = 'entrance=connect';
        }

        $this->render();
    }

    public function testAction()
    {
        echo 'hello fbtaiwanv2';
        exit;
    }
    
	public function append_namespace($params, $namespace = NS) {
		$prefix = $namespace . '_';
		foreach ($params as $name => $value) {
			if (strpos($name, $namespace) !== 0) {
				unset($params[$name]);
				$params[$prefix . $name] = $value;
			}
		}
		
		return $params;
	}
}