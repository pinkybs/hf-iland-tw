<?php

class Hapyfish2_Island_Bll_Invite
{
    const CONNECT_TIMEOUT = 4;
    const TIMEOUT = 4;
    const DNS_CACHE_TIMEOUT = 600;
    const RETRIES = 3;

	public static function add($inviteUid, $newUid, $time = null)
	{
		if (!$time) {
			$time = time();
		}

		Hapyfish2_Island_Bll_InviteLog::add($inviteUid, $newUid, $time);
		Hapyfish2_Island_Bll_Fragments::updateInviteNum($inviteUid);
		//add 1000 coin
		Hapyfish2_Island_HFC_User::incUserCoin($inviteUid, 1000);

		//add card
		//$ok = Hapyfish2_Island_HFC_Card::addUserCard($inviteUid, 26341, 1);
		//$cardInfo = Hapyfish2_Island_Cache_BasicInfo::getCardInfo(26341);
		//add 3 starfish
		$starNum = 3;
		$ok = Hapyfish2_Island_Bll_StarFish::add($inviteUid, $starNum, '');
		$targetuser = Hapyfish2_Platform_Bll_User::getUser($newUid);

		$feed = str_replace('{*nickname*}', $targetuser['name'], LANG_PLATFORM_INDEX_TXT_22);

		if ($ok) {
			$feed = array(
				'uid' => $inviteUid,
				'actor' => $inviteUid,
				'target' => $newUid,
				'template_id' => 0,
				//'title' => array('cardName' => $cardInfo['name']),
				'title' => array('title' => $feed),
				'type' => 3,
				'create_time' => $time
			);
			Hapyfish2_Island_Bll_Feed::insertMiniFeed($feed);
		} else {
			info_log('[' . $inviteUid . ':' . $newUid, 'invite_failure');
		}
	}

	public static function refresh($uid, $list)
	{
		if (empty($list)) {
			return;
		}

		$num1 = count($list);
		$log = Hapyfish2_Island_Bll_InviteLog::getAll($uid);
		$all = true;
		if ($log) {
			$num2 = count($log);
			if ($num1 == $num2) {
				return;
			}
			$all = false;
			$tmp = array();
			foreach ($log as $f) {
				$tmp[$f['fid']] = $f['time'];
			}
		}

		$data = array();
		foreach ($list as $v) {
			$puid = $v['uid'];
			$time = $v['mtime'];
			$user = Hapyfish2_Platform_Cache_UidMap::getUser($puid);
			if ($user) {
				$fid = $user['uid'];
				if ($all) {
					$data[$fid] = array('fid' => $fid, 'time' => strtotime($time));
				} else {
					if (!isset($tmp[$fid])) {
						$data[$fid] = array('fid' => $fid, 'time' => strtotime($time));
					}
				}
			}
		}

		if (!empty($data)) {
			foreach ($data as $user) {
				self::add($uid, $user['fid'], $user['time']);
			}
		}

	}

	public static function fbInviteDone($requestIds,$newpuid)
	{

		$rst = false;
		try {
		    //get inviter info from fb
			$objAppRequests = self::_getFbInviterInfo($requestIds);

		} catch (Exception $e) {
			info_log('fbInvite:'.$e->getMessage(), 'Island_Bll_Invite_Err');
			return false;
		}

		if ($objAppRequests) {
			/*if ($objAppRequests['to']['id'] == $newpuid && $objAppRequests['application']['id'] == APP_ID) {
				$inviteUser = Hapyfish2_Platform_Cache_UidMap::getUser($objAppRequests['from']['id']);
				$newUser = Hapyfish2_Platform_Cache_UidMap::getUser($newpuid);
				if ($inviteUser && $newUser) {
					//is invite already done
					$log = Hapyfish2_Island_Bll_InviteLog::getAll($inviteUser['uid']);
					foreach ($log as $f) {
						if ($f['fid'] == $newUser['uid']) {
							return false;
						}
					}
					Hapyfish2_Island_Bll_Invite::add($inviteUser['uid'], $newUser['uid']);
					$rst = true;
					info_log($inviteUser['uid'] . ' invite->' . $newUser['uid'] . 'DONE!', 'Bll_Invite_logs');
				}
			}*/
			if ($objAppRequests['id'] == $requestIds && $objAppRequests['application']['id'] == APP_ID) {
				$inviteUser = Hapyfish2_Platform_Cache_UidMap::getUser($objAppRequests['from']['id']);
				$newUser = Hapyfish2_Platform_Cache_UidMap::getUser($newpuid);
				if ($inviteUser && $newUser) {
					//is invite already done
					$log = Hapyfish2_Island_Bll_InviteLog::getAll($inviteUser['uid']);
					foreach ($log as $f) {
						if ($f['fid'] == $newUser['uid']) {
							return false;
						}
					}
					Hapyfish2_Island_Bll_Invite::add($inviteUser['uid'], $newUser['uid']);
					$rst = true;
					info_log($inviteUser['uid'] . ' invite->' . $newUser['uid'] . 'DONE!', 'Bll_Invite_logs');
				}
			}
		}
		else {
			info_log('fbInvite:get request info failed', 'Island_Bll_Invite_Err');
		}

		return $rst;
	}

	private static function _getFbInviterInfo($requestIds)
	{
	    info_log($requestIds, 'Bll_Invite_logs');

	    $objAppRequests = '';
	    //get app token from cache
		$key = 'fb:apptoken:invite';
    	$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
    	$token = $cache->get($key);
//info_log($token, 'aaa');    	
    	if (!$token) {
        	//get app token
			//$token = file_get_contents('https://graph.facebook.com/oauth/access_token?client_id='.APP_ID.'&client_secret='.APP_SECRET.'&grant_type=client_credentials');
			$param = array();
			$param['client_id'] = APP_ID;
			$param['client_secret'] = APP_SECRET;
			$param['grant_type'] = 'client_credentials';
			$token = self::_curlRequest('https://graph.facebook.com/oauth/access_token', $param);
			if ($token && strpos($token, 'access_token=') !== false) {
				$cache->set($key, $token);
//info_log('token renewed:'.$token, 'aaa');
				//$objAppRequests = json_decode(file_get_contents('https://graph.facebook.com/'.$requestIds.'?method=get&'.$token), true);
				$aryTmp = explode('=', $token);
				$param2 = array();
				$param2['method'] = 'get';
				$param2[$aryTmp[0]] = $aryTmp[1];
				$objAppRequests = json_decode(self::_curlRequest('https://graph.facebook.com/'.$requestIds, $param2), true);
			}
    	}
    	else {
    		//$objAppRequests = json_decode(file_get_contents('https://graph.facebook.com/'.$requestIds.'?method=get&'.$token), true);
    		$aryTmp = explode('=', $token);
			$param2 = array();
			$param2['method'] = 'get';
			$param2[$aryTmp[0]] = $aryTmp[1];
			$objAppRequests = json_decode(self::_curlRequest('https://graph.facebook.com/'.$requestIds, $param2), true);

//info_log('token load from cache:'.$token, 'aaa');
    		if ($objAppRequests && isset($objAppRequests['error'])) {
        		//$token = file_get_contents('https://graph.facebook.com/oauth/access_token?client_id='.APP_ID.'&client_secret='.APP_SECRET.'&grant_type=client_credentials');
        		$param = array();
				$param['client_id'] = APP_ID;
				$param['client_secret'] = APP_SECRET;
				$param['grant_type'] = 'client_credentials';
				$token = self::_curlRequest('https://graph.facebook.com/oauth/access_token', $param);
				if ($token && strpos($token, 'access_token=') !== false) {
					$cache->set($key, $token);
//info_log('token renewed2:'.$token, 'aaa');
					//$objAppRequests = json_decode(file_get_contents('https://graph.facebook.com/'.$requestIds.'?method=get&'.$token), true);
					$aryTmp = explode('=', $token);
    				$param2 = array();
    				$param2['method'] = 'get';
    				$param2[$aryTmp[0]] = $aryTmp[1];
    				$objAppRequests = json_decode(self::_curlRequest('https://graph.facebook.com/'.$requestIds, $param2), true);
				}
    		}
    	}
    	return $objAppRequests;
	}

    private static function _curlRequest($url, $params=null)
    {

        $post_string = self::_create_post_string($params);
        $reqUrl = $url . '?' . $post_string;
        //echo $reqUrl.'<br /><br />';
        //echo $url . '?' . $post_string;
        //exit;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $reqUrl);
        //curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //max connect time
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CONNECT_TIMEOUT);
        //max curl execute time
        curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);
        //cache dns 1 hour
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, self::DNS_CACHE_TIMEOUT);
        //renren can get and send data encoding by gzip
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');

        $ua = 'PHP-cURL/HapyFish-FBRest/2.0';
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$result = @curl_exec($ch);

        $errno = @curl_errno($ch);
        $error = @curl_error($ch);
        curl_close($ch);

        if ($errno != CURLE_OK) {
            info_log('curl'. $error, 'fb_invite_api_call_failed');
            throw new Facebook_Rest_Exception("HTTP Error: " . $error, $errno);
        }

        //echo $result;
//info_log($result, 'aaa');
        return $result;
    }

    private static function _create_post_string($params)
    {
        $post_params = array();
        foreach ($params as $key => &$val) {
            $post_params[] = $key.'='.urlencode($val);
        }
        return implode('&', $post_params);
    }
}