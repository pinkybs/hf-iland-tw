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

    	if (APP_STATUS == 0) {
    		$stop = true;
    		if (APP_STATUS_DEV == 1) {
    			$ip = $this->getClientIP();
	    		if ($ip == '27.115.48.202' || $ip == '122.147.63.223') {
	    			$stop = false;
	    		}
    		}
    		if ($stop) {
    			header('Location: ' . STATIC_HOST . '/maintance/index.html?v=' . date('YmdHi'));
    			exit;
    		}
    	}

    	try {
    		$application = Hapyfish2_Application_SnsplusKimo::newInstance($this);
        	$application->run();
    	} catch (Exception $e) {
    		err_log($e->getMessage());
    		//echo '加载数据出错，请重新进入。';
    		echo '<div style="text-align:center;margin-top:30px;"><img src="' . STATIC_HOST . '/maintance/images/problem1.gif" alt="加载数据出错，请重新进入" /></div>';
    		exit;
    	}

        $uid = $application->getUserId();
        $isnew = $application->isNewUser();
        $platformUid = $application->getPlatformUid();

        $rest = $application->getRest();
        $inviteParam = $rest->getParameters();

/*info_log(json_encode($inviteParam), 'aatestinvite');
info_log(json_encode(base64_decode($inviteParam['hf_uid'])), 'aatestinvite');
info_log(json_encode($inviteParam['hf_sig']), 'aatestinvite');*/

        if ($isnew) {
			$ok = Hapyfish2_Island_Bll_User::joinUser($uid);
        	Hapyfish2_Island_Event_Bll_Timegift::setup($uid);
        	if (!$ok) {
    			echo LANG_PLATFORM_INDEX_TXT_10;
    			exit;
        	}

            //是否邀请好友完成
            if (isset($inviteParam['hf_uid']) && isset($inviteParam['hf_sig'])) {
                $invitorUid = base64_decode($inviteParam['hf_uid']);
            	if ((int)$invitorUid) {
            		Hapyfish2_Island_Bll_Invite::inviteDone($uid, $invitorUid);
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

        /*$pgiftTF = Hapyfish2_Island_Bll_Permissiongift::getval($uid);
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
        }*/

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

        $time = time();
        $snsCode = md5('game_code='.APP_NAME.'time='.$time.'uid='.$uid.APP_SECRET);
		$this->view->snsUrl = 'http://sn.service.snsplus.com/?game_code='.APP_NAME.'&uid='.$platformUid.'&time='.$time.'&sig='.$snsCode;

        $this->render();
    }

    public function testAction()
    {
        echo 'hello snsplus tw kimo';

        if (function_exists('mcrypt_decrypt')) {
            echo '<br/>  mcrypt OK ';
        }
        exit;
    }
}