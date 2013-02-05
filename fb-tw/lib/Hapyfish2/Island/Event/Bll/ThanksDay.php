<?php

/**
 * Event ThanksGivingDay
 *
 * @package    Island/Event/Bll
 * @copyright  Copyright (c) 2011 Happyfish Inc.
 * @create     2011/11/14    zhangli
*/
class Hapyfish2_Island_Event_Bll_ThanksDay
{	
	const TXT001 = '感恩節雇傭機器人';
	const TXT002 = '感恩節解雇好友';
	const TXT003 = '對不起，您已經幫了朋友5次忙，還是等明天吧!';
	const TXT004 = '對不起，您的愛心值不足，不能兌換';
	const TXT005 = '不能入駐自己的工地';
	const TXT006 = '不能解雇機器人';
	const TXT007 = '您的雕像已經5級，不需要補齊！';
	const TXT008 = '感恩節購買愛心';
	const TXT009 = '對不起，您今天已經去過該好友家了，請明天再來吧！';
	
	/**
	 * @感恩节初始化
	 * @param int $uid
	 * @param int $fid  (是自己的时候不传fid)
	 * @return Array
	 */
	public static function thDayInit($uid, $fid)
	{
		$result = array('status' => -1);
		
		//是自己的时候
		if ($fid != 0) {
			$result['content'] = 'serverWord_101';
			return $result;
			//$uid = $fid;
		}
		
		$nowTime = time();
		$endTime = strtotime('2011-11-29 23:59:59');
		$lastTime = $endTime - $nowTime;
		
		if ($lastTime <= 0) {
			$result['content'] = '活动已结束！';
			return $result;
		}
		
		//获取建筑等级
		$plantLevl = Hapyfish2_Island_Event_Cache_ThanksDay::getPlantLevel($uid);
        
		//获取用户的爱心值
		$hasLove = Hapyfish2_Island_Event_Cache_ThanksDay::hasLove($uid);
		
		//获取用户用的最大爱心值
		$hasLoveMax = Hapyfish2_Island_Event_Cache_ThanksDay::hasLoveMax($uid);
		
		$feedTrue = 0;
		/**
		if ($plantLevl < 5) {
			//获取雕像基础信息
			$plantVo = Hapyfish2_Island_Event_Cache_ThanksDay::aryPlant();
			$level = 0;
			foreach ($plantVo as $plkey => $plant) {
				if ($hasLoveMax < $plant['needLove']) {
					$level = $plantVo[$plkey - 1]['level'];
					break;
				}
			}
			
			if ($level == false) {
				if ($hasLoveMax >= $plantVo[4]['needLove']) {
					$level = 5;
					
					$nowTime = time();
					
					$dateFormat = date('Y-m-d H:i:s', $nowTime);
					
					//记录拥有5级沙雕的人
					info_log($dateFormat . '  ' . $uid, 'sculpture');
				}
			}
			
			if ($level > $plantLevl) {
				//升级用户雕像
				Hapyfish2_Island_Event_Cache_ThanksDay::addPlantLevel($uid, $level);
				$feedTrue = 1;

				//统计雕像等级
				$db = Hapyfish2_Island_Event_Dal_ThanksDay::getDefaultInstance();
				$hasFlag = $db->getFlag($uid);
				if (!$hasFlag) {
					try {
						$db->incFlag($uid, $level);
					} catch (Exception $e) {}
				} else {
					try {
						$db->updateFlag($uid, $level);
					} catch (Exception $e) {}
				}
				
				$plantLevl = $level;
			}
			
			if ($plantLevl == 5) {
				//雕像升级到5级的第二天才可以获取爱心值奖励
				Hapyfish2_Island_Event_Cache_ThanksDay::addLoveFlag($uid);
			}
		}
		
		//5级雕像每天可以获得50爱心
		if ($plantLevl == 5) {
			$canAddLove = Hapyfish2_Island_Event_Cache_ThanksDay::canAddLove($uid);
			
			if ($canAddLove == false) {
				info_log($uid, 'addThdayLoveOnce');
				Hapyfish2_Island_Event_Cache_ThanksDay::renewHasLove($uid, 50);
				
				//每天只能获得一次
				Hapyfish2_Island_Event_Cache_ThanksDay::addLoveFlag($uid);
				
				$nowTime = time();
				
				//发feed
				$feed = array('uid' => $uid,
							'template_id' => 0,
							'actor' => $uid,
							'target' => $uid,
							'type' => 3,
							'title' => array('title' => '5級雕像獎勵:<font color="#379636">50愛心</font>'),
							'create_time' => $nowTime);
			
				Hapyfish2_Island_Bll_Feed::insertMiniFeed($feed);
			}
		}
	
		//用户工地列表
		$siteList = Hapyfish2_Island_Event_Cache_ThanksDay::siteList($uid);
		
		//获取用户的爱心值
		$hasLove = Hapyfish2_Island_Event_Cache_ThanksDay::hasLove($uid);
		
		//获取用户用的最大爱心值
		$hasLoveMax = Hapyfish2_Island_Event_Cache_ThanksDay::hasLoveMax($uid);*/
		$siteList = array();
		
		$result['status'] = 1;
		$resultVo['result'] = $result;
		$resultVo['buildingLevel'] = (int)$plantLevl;
		$resultVo['hasLove'] = $hasLove;
		$resultVo['maxLove'] = $hasLoveMax;
		$resultVo['feedTrue'] = $feedTrue;
		$resultVo['siteList'] = $siteList;
		$resultVo['timeleft'] = $lastTime;
		
		return $resultVo;
	}
	
	/**
	 * @雇佣机器人
	 * @param int $uid
	 * @param int $id
	 * @param int $siteId
	 * @return Array
	 */
	public static function thDayRobot($uid, $id, $siteId)
	{
		$result = array('status' => -1);
		
		//雇佣的机器人ID和工地ID不能为空
		if (!$id || !$siteId) {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		if (!in_array($siteId, array(1, 2, 3, 4))) {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		if (!in_array($id, array(1, 2, 3))) {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		//获取机器人信息
		$robotData = Hapyfish2_Island_Event_Cache_ThanksDay::getRobotData($id);
		
    	//获得用户gold
		$userGold = Hapyfish2_Island_HFC_User::getUserGold($uid);
		
		//宝石不足
		if ($robotData['needGold'] > $userGold) {
    		$result['content'] = 'serverWord_140';
    		$resultVo = array('result' => $result);
    		return $resultVo;
		}
		
		//判断当前工地是否可以雇佣机器人
		$siteRobot = Hapyfish2_Island_Event_Cache_ThanksDay::getSiteById($uid, $siteId);
		if ($siteRobot == false) {
    		$result['content'] = 'serverWord_101';
    		$resultVo = array('result' => $result);
    		
    		return $resultVo;
		}
		
		//机器人入住工地
		Hapyfish2_Island_Event_Cache_ThanksDay::incSite($uid, $siteId, $id, $robotData);
		
		//获取用户等级
		$userLevelInfo = Hapyfish2_Island_HFC_User::getUserLevel($uid);
		$userLevel = $userLevelInfo['level'];
		
		$nowTime = time();
		
		//扣除宝石
		$goldInfo = array('uid' => $uid,
						'cost' => $robotData['needGold'],
						'summary' => self::TXT001,
						'user_level' => $userLevel,
						'create_time' => $nowTime,
						'cid' => '',
						'num' => 0);

        $ok2 = Hapyfish2_Island_Bll_Gold::consume($uid, $goldInfo);

		if ($ok2) {
			try {
				Hapyfish2_Island_HFC_Achievement::updateUserAchievementByField($uid, 'num_19', $goldInfo['cost']);

				//task id 3068,task type 19
				$checkTask = Hapyfish2_Island_Bll_Task::checkTask($uid, 3068);
				if ( $checkTask['status'] == 1 ) {
					$result['finishTaskId'] = $checkTask['finishTaskId'];
				}
	        } catch (Exception $e) {}
	        
	        info_log($uid . ',' . $id, 'thDayBuyRobot');
		}
		
		$result['status'] = 1;
		$result['goldChange'] = -$goldInfo['cost'];
		$resultVo['result'] = $result;
		
		return $resultVo;
	}
	
	/**
	 * @解雇好友
	 * @param int $uid
	 * @param int $fid
	 * @param int $siteId
	 * @return Array
	 */
	public static function thDayDisMiss($uid, $fid, $siteId)
	{
		$result = array('status' => -1);
		
		//好友ID和工地ID不能为空
		if (!$fid || !$siteId) {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		if (!in_array($siteId, array(1, 2, 3, 4))) {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		//机器人不能解雇
		if (in_array($fid, array(1, 2, 3))) {
			$result['content'] = self::TXT006;
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		//解雇好友许花费1宝石
		$needGood = 1;
		
    	//获得用户宝石
		$userGold = Hapyfish2_Island_HFC_User::getUserGold($uid);
		
		//宝石不足
		if ($needGood > $userGold) {
    		$result['content'] = 'serverWord_140';
    		$resultVo = array('result' => $result);
    		return $resultVo;
		}
		
		//把好友从工地解雇
		Hapyfish2_Island_Event_Cache_ThanksDay::delSite($uid, $siteId);
		
		$nowTime = time();
		
		//获取用户等级
		$userLevelInfo = Hapyfish2_Island_HFC_User::getUserLevel($uid);
		$userLevel = $userLevelInfo['level'];
		
		//扣除宝石
		$goldInfo = array('uid' => $uid,
						'cost' => $needGood,
						'summary' => self::TXT002,
						'user_level' => $userLevel,
						'create_time' => $nowTime,
						'cid' => '',
						'num' => 0);

        $ok2 = Hapyfish2_Island_Bll_Gold::consume($uid, $goldInfo);

		if ($ok2) {
			try {
				Hapyfish2_Island_HFC_Achievement::updateUserAchievementByField($uid, 'num_19', $goldInfo['cost']);

				//task id 3068,task type 19
				$checkTask = Hapyfish2_Island_Bll_Task::checkTask($uid, 3068);
				if ( $checkTask['status'] == 1 ) {
					$result['finishTaskId'] = $checkTask['finishTaskId'];
				}
	        } catch (Exception $e) {}
	        
	        info_log($uid . ',' . $fid, 'thDayDisMiss');
		}
		
		$result['status'] = 1;
		$result['goldChange'] = -$goldInfo['cost'];
		$resultVo['result'] = $result;
		
		return $resultVo;
	}
	
	/**
	 * @入驻好友工地
	 * @param int $uid
	 * @param int $fid
	 * @param int $siteId (好友的工地ID)
	 * @return Array
	 */
	public static function thDayCheckIn($uid, $fid, $siteId)
	{
		$result = array('status' => -1);

		if ($uid == $fid) {
			$result['content'] = self::TXT005;
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		if (!in_array($siteId, array(1, 2, 3, 4))) {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		//好友ID和好友工地ID不能为空
		if (!$fid || !$siteId) {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		//每天每人最多可以入驻5次好友的工地
		$num = Hapyfish2_Island_Event_Cache_ThanksDay::getInSiteNum($uid);
		if ($num >= 5) {
			$result['content'] = self::TXT003;
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		//每人每天只能入驻同一个好友工地一次
//		$incSameFidSite = Hapyfish2_Island_Event_Cache_ThanksDay::getSameFidSite($uid, $fid);
//		if ($incSameFidSite == false) {
//			$result['content'] = self::TXT009;
//			$resultVo = array('result' => $result);
//			return $resultVo;
//		}
		
		//判断当前工地是否可以入驻
		$siteData = Hapyfish2_Island_Event_Cache_ThanksDay::getSiteById($fid, $siteId);
		if ($siteData == false) {
    		$result['status'] = 'serverWord_101';
    		$resultVo = array('result' => $result);
    		return $resultVo;
		}

		//入驻好友工地
		Hapyfish2_Island_Event_Cache_ThanksDay::incFidSite($fid, $uid, $siteId);

		//入驻好友工地统计
		try {
			$db = Hapyfish2_Island_Event_Dal_ThanksDay::getDefaultInstance();
			$db->incSite($uid, $fid, time());
		} catch (Exception $e) {}
		
		//记录入驻次数
		Hapyfish2_Island_Event_Cache_ThanksDay::addInSiteNum($uid);
		
		//入驻好友工地成功,自己立刻获得5爱心
		Hapyfish2_Island_Event_Cache_ThanksDay::renewHasLove($uid, 5);
		
		$result['status'] = 1;
		$resultVo['result'] = $result;
		
		return $resultVo;
	}
	
	/**
	 * @兑换礼包
	 * @param int $uid
	 * @param int $id
	 * @return Array
	 */
	public static function thDayExch($uid, $id)
	{
		$result = array('status' => -1);
		
		//礼包ID不能为空,切只能是三个礼包中的一个
		if (!in_array($id, array(1, 2, 3))) {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		$nowTime = time();
		$endTime = strtotime('2011-11-29 23:59:59');
		$lastTime = $endTime - $nowTime;
		
		if ($lastTime <= 0) {
			$result['content'] = '活动已结束！';
			return $result;
		}
		
		//获取用户的爱心值
		$hasLove = Hapyfish2_Island_Event_Cache_ThanksDay::hasLove($uid);
		
		//获取礼包信息
		$giftList = Hapyfish2_Island_Event_Cache_ThanksDay::getGiftList();
		
		//获取当前要兑换的物品
		foreach ($giftList as $key => $value) {
			if ($key == $id) {
				$data = $value;
				break;
			}
		}	

		//判断用户的爱心是否足够
		if ($hasLove < $data['needLove']) {
			$result['content'] = self::TXT004;
			$resultVo = array('result' => $result);
			return $resultVo;
		}
	
		//发东西
		$compensation = new Hapyfish2_Island_Bll_Compensation();

		if ($data['cid'] && $data['num']) {
			foreach ($data['cid'] as $cidKey => $cid) {
				$compensation->setItem($cid, $data['num'][$cidKey]);
			}
		}
			
		$ok = $compensation->sendOne($uid, '恭喜你用' . $data['needLove'] . '愛心兌換了：');
		
		if ($ok) {
			//减少用户爱心值
			Hapyfish2_Island_Event_Cache_ThanksDay::renewHasLove($uid, -$data['needLove']);
			
			info_log($uid . ',' . $id . ',' . $data['needLove'], 'thDayExch');
		} else {
			info_log($uid . ',' . $id . ',' . $data['needLove'], 'thDayExchErr');
			
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		$result['status'] = 1;
        $result['itemBoxChange'] = true;
		$resultVo['result'] = $result;
		
		return $resultVo;
	}
	
	/**
	 * @排行榜
	 * @return Array
	 */
	public static function thDayRank()
	{
		$list = Hapyfish2_Island_Event_Cache_ThanksDay::getRanList();
		
		$resultVo['list'] = $list;
		
		return $resultVo;
	}
	
	/**
	 * @购买爱心值
	 * @param int $uid
	 * @param int $love
	 * @return Array
	 */
	public static function thDayBuyLove($uid, $love)
	{
		$result = array('status' => -1);
		
		//购买的爱心值不能少0
		if ($love <= 0) {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
    	//获得用户gold
		$userGold = Hapyfish2_Island_HFC_User::getUserGold($uid);
		
		//宝石不足
		if ($love > $userGold) {
    		$result['content'] = 'serverWord_140';
    		$resultVo = array('result' => $result);
    		
    		return $resultVo;
		}
		
		$nowTime = time();
		
		//增加爱心
		Hapyfish2_Island_Event_Cache_ThanksDay::renewHasLove($uid, $love);
		
		if ($love > 3000) {
			info_log($uid . ',' . $love, 'buyLove3000');
		}
		
		//统计购买爱心值
		$db = Hapyfish2_Island_Event_Dal_ThanksDay::getDefaultInstance();
	
		$before = $db->getBuyLove($uid);
	
		if (!$before) {
			try {
				$db->incBuyLove($uid, $love);
			} catch (Exception $e) {}			
		} else {
			try {
				$db->addBuyLove($uid, $love);
			} catch (Exception $e) {}
		}
		
		info_log($uid . ',' . $love, 'addThdayBuyLove');
		
		//获取用户等级
		$userLevelInfo = Hapyfish2_Island_HFC_User::getUserLevel($uid);
		$userLevel = $userLevelInfo['level'];
		
		//扣除宝石
		$goldInfo = array('uid' => $uid,
						'cost' => $love,
						'summary' => self::TXT008 . $love,
						'user_level' => $userLevel,
						'create_time' => $nowTime,
						'cid' => '',
						'num' => 0);

        $ok2 = Hapyfish2_Island_Bll_Gold::consume($uid, $goldInfo);

		if ($ok2) {
			try {
				Hapyfish2_Island_HFC_Achievement::updateUserAchievementByField($uid, 'num_19', $goldInfo['cost']);

				//task id 3068,task type 19
				$checkTask = Hapyfish2_Island_Bll_Task::checkTask($uid, 3068);
				if ( $checkTask['status'] == 1 ) {
					$result['finishTaskId'] = $checkTask['finishTaskId'];
				}
	        } catch (Exception $e) {}
		}
		
		$result['status'] = 1;
		$result['goldChange'] = -$love;
		$resultVo['result'] = $result;
		
		return $resultVo;
	}
	
	/**
	 * @宝石补齐雕像
	 * @param int $uid
	 */
	/**
	public static function thDayComplete($uid)
	{
		$result = array('status' => -1);
		
		//获取建筑等级
		$plantLevl = Hapyfish2_Island_Event_Cache_ThanksDay::getPlantLevel($uid);
		if ($plantLevl >= 5) {
			$result['content'] = self::TXT007;
			$resultVo = array('result' => $result);
			return $resultVo;
		}
        
		//获取雕像基础信息
		$plantVo = Hapyfish2_Island_Event_Cache_ThanksDay::aryPlant();
		
		//获取用户用的最大爱心值
		$hasLoveMax = Hapyfish2_Island_Event_Cache_ThanksDay::hasLoveMax($uid);
		
		//补齐需要爱心值
		$needGold = $plantVo[4]['needLove'] - $hasLoveMax;

    	//获得用户gold
		$userGold = Hapyfish2_Island_HFC_User::getUserGold($uid);
		
		//宝石不足
		if ($needGold > $userGold) {
    		$result['content'] = 'serverWord_140';
    		$resultVo = array('result' => $result);
    		
    		return $resultVo;
		}
		
		//升级用户雕像为5级
		Hapyfish2_Island_Event_Cache_ThanksDay::addPlantLevel($uid, 5);
		
		//补齐雕像花费的宝石等于获得的爱心值数
		Hapyfish2_Island_Event_Cache_ThanksDay::renewHasLove($uid, $needGold);
		
		$nowTime = time();
		
		//获取用户等级
		$userLevelInfo = Hapyfish2_Island_HFC_User::getUserLevel($uid);
		$userLevel = $userLevelInfo['level'];
		
		//扣除宝石
		$goldInfo = array('uid' => $uid,
						'cost' => $needGold,
						'summary' => '补齐感恩节雕像',
						'user_level' => $userLevel,
						'create_time' => $nowTime,
						'cid' => '',
						'num' => 0);

        $ok2 = Hapyfish2_Island_Bll_Gold::consume($uid, $goldInfo);

		if ($ok2) {
			try {
				Hapyfish2_Island_HFC_Achievement::updateUserAchievementByField($uid, 'num_19', $goldInfo['cost']);

				//task id 3068,task type 19
				$checkTask = Hapyfish2_Island_Bll_Task::checkTask($uid, 3068);
				if ( $checkTask['status'] == 1 ) {
					$result['finishTaskId'] = $checkTask['finishTaskId'];
				}
	        } catch (Exception $e) {}
		}
		
		//记录拥有5级沙雕的人
		info_log($uid . ',' . 'com', 'sculpture-5');
		
		$result['status'] = 1;
		$result['goldChange'] = -$needGold;
		$resultVo['result'] = $result;
		
		return $resultVo;
	}
	*/
	
	/**
	 * @感恩节发雕像
	 */
	public static function sendPlant()
	{
		//5星沙雕建筑
		$db = Hapyfish2_Island_Event_Dal_ThanksDay::getDefaultInstance();
		$uids = $db->getAllUser();
		
		$cid = 125332;
		$com = new Hapyfish2_Island_Bll_Compensation();
		
		foreach ($uids as $uid) {					
			$com->setItem($cid, 1);
			$ok = $com->sendOne($uid, '感恩節建築：');
			if($ok){
				info_log($uid, 'thday-' . $cid);
			}
		}
				
		return true;
	}
	
	public static function getPlant($num)
	{
		$uids[1] = array(3102,3415,7575,7975,9534,9638,11080,11230,11701,11755,15151,17648,17961,21793,22813,24296,24553,34203,34821,34829,35167,36677,38121,38558,39619,39972,39986,41108,42234,47211,47295,49414,49942,51628,53826,54504,54684,55382,56488,56723,59249,59458,64339,66424,68432,70047,74119,74964,78252,79392,79565,79647,82785,84609,84726,86096,86161,87759,87828,92847,93810,96902,97569,99686,104706,106197,106807,108491,111811,112956,115039,115567,115830,118426,118568,119484,119485,119777,126052,127305,127503,128793,129599,129862,130401,130661,130686,132097,132270,135262,135562,139893,140754,142416,142427,144444,144544,144986,145082,145446,146126,147228,149055,151787,152317,154967,156353,156853,157735,159560,159933,163261,163912,165540,166686,173096,173234,173679,174549,175216,178323,178500,179510,180715,180822,184538,184992,185737,185989,186676,187375,188224,188760,189447,194720,198769,201813,202997,206940,207675,208041,210166,210383,212636,216985,219890,220138,220589,221209,222372,222447,224808,225083,225376,227838,229019,230472,231337,231679,233218,237520,239125,241535,242006,246597,247118,247599,249410,250450,252254,253376,257751,259535,260699,262095,263198,264131,264887,268694,269910,271323,271326,273020,273079,273380,274414,275341,275465,277524,279236,279353,295100,295887,297176,297722,299313,299543,302046,304204,304977);
		$uids[2] = array(305210,306281,307750,311185,316649,320070,322528,322559,324258,326503,326801,328416,329955,330428,332470,335209,337621,337745,338784,339364,344354,344870,347742,347753,348367,349207,351331,352425,354790,357228,359701,364103,366799,367117,368421,375278,379429,381209,381329,385355,388109,388931,389148,391288,391739,392859,393591,393914,400170,404854,405691,407519,408322,412834,414455,416572,418053,422256,422319,423019,425593,430709,434848,436349,438853,440659,444366,446254,448010,449869,458401,459235,461145,461592,462117,465983,475575,479333,479707,481657,487484,489310,490769,490792,491122,492245,492633,492966,494330,494573,494668,494826,498778,501556,501853,505970,507510,509923,511657,511921,512069,517387,524181,527592,533711,535962,538756,548119,548312,549855,552196,553148,554572,555076,556389,556563,557161,557489,561843,562432,569705,577157,577745,577871,580000,582332,588698,591864,592118,592310,597140,606047,611753,615128,615522,616762,617105,617340,618709,623321,623360,624705,628428,630585,632538,634221,634305,635910,636188,636476,637323,638292,638857,642295,642720,643735,644411,648678,649912,650991,657877,659163,661153,661680,661989,664652,667006,667282,668898,670416,670993,672985,675190,681814,682662,683180,688673,689429,689684,692965,693702,694872,699605,700824,702653,702706,711469,714312,717187,717856,718109,718836,721362,722721,723913,724159,725090,726102,727320,729752);
		$uids[3] = array(740865,745851,748191,749023,753380,755658,756841,757962,758188,762806,763622,763630,765451,766160,767908,768403,768819,774904,776064,777627,778119,778348,779069,785440,787339,787487,787598,789223,791653,791713,795762,796727,796903,799879,800582,802640,802790,803825,803904,804018,805867,806205,807699,808596,810951,811213,812052,813448,827586,829717,831389,832938,834585,845113,845213,851086,851332,851381,852501,854254,856046,858503,858505,861044,861349,861525,861882,862549,863795,863803,863844,863989,864500,866214,866306,866584,866724,866863,867079,867089,868604,868933,869213,869376,870021,870311,873739,875080,875661,875958,876250,877355,877374,877467,877646,878709,880495,881083,881676,881735,882027,882685,883062,883744,883754,885466,885523,885904,886707,887092,887721,887732,888451,888468,888575,888703,889864,890382,891201,891537,891787,892107,892135,892193,893113,893929,894036,894126,894349,896275,897238,897413,898249,899783,900088,900191,900964,901098,901489,901645,903767,904068,904727,905421,905729,907962,908059,908330,909089,909121,909717,910340,910518,911119,911333,911344,914397,915167,916040,917127,917426,919106,919141,919646,919848,919862,924641,924728,925031,925780,925985,926507,926839,927486,928911,929078,929350,932947,933722,934045,934162,934547,937893,938670,938855,939958,940921,943717,943837,946961,946991,949100,950822,952730,955347,955938,956250,956618,961388,963038);
		$uids[4] = array(963554,963568,964751,965452,968594,969654,970363,971705,976218,976480,977067,977225,978050,979127,980862,980935,981397,982498,984037,984837,985528,986070,986930,988801,988956,989831,993239,993857,995176,1003950,1005570,1006716,1007043,1009227,1012868,1014364,1015196,1019559,1022752,1023706,1024098,1024422,1024823,1025799,1029883,1030093,1030874,1035120,1039129,1041857,1044735,1045447,1046612,1047561,1051278,1053667,1054199,1054333,1054674,1055089,1058606,1059034,1068692,1072755,1072900,1079906,1085042,1086668,1087798,1090467,1092902,1094380,1094652,1096545,1097481,1098467,1098780,1100491,1101449,1103560,1103825,1107355,1109893,1110313,1110350,1110956,1115539,1116449,1117508,1118102,1118706,1120612,1120800,1120957,1124823,1128245,1130637,1130827,1139786,1141565,1144536,1148894,1149081,1149846,1151114,1154650,1156274,1162142,1165804,1171306,1171654,1172090,1172393,1172562,1173208,1173376,1173467,1173866,1174495,1175804,1176458,1179979,1181180,1181680,1182195,1182853,1184017,1184371,1186968,1187961,1188052,1188558,1189875,1190726,1192760,1192808,1194923,1197772,1200091,1200721,1200967,1202196,1205837,1206520,1207475,1207588,1208424,1210738,1215680,1216822,1217117,1218081,1219166,1220050,1220472,1221418,1222381,1224060,1224511,1225254,1231916,1232992,1235017,1238359,1239088,1239319,1241114,1241540,1242942,1242974,1245522,1245796,1246025,1248095,1248528,1250091,1252514,1252577,1253323,1254033,1262812,1264124,1265063,1267011,1267089,1270526,1271773,1272322,1274455,1282505,1283802,1283817,1284836,1284926,1285045,1285286,1289278,1289298,1289822,1289871);
		$uids[5] = array(1290371,1295491,1297011,1301139,1301985,1303393,1307845,1308714,1312226,1315277,1315403,1316079,1316973,1317142,1317416,1317473,1318195,1318766,1324961,1326827,1327335,1329167,1329805,1331353,1333653,1334699,1335346,1335479,1335852,1336686,1337852,1338521,1339244,1340482,1341787,1341848,1348963,1349330,1349360,1349440,1349538,1353512,1354005,1354154,1356029,1357748,1357979,1358504,1359031,1360323,1360891,1361060,1361627,1361715,1364228,1364792,1365258,1366094,1368307,1369526,1370122,1372091,1372782,1373303,1375077,1376881,1379352,1380380,1380832,1381383,1382247,1382366,1383491,1385845,1387762,1389821,1391662,1393160,1393342,1393898,1395072,1396537,1398066,1398837,1402312,1402636,1404866,1404961,1406517,1407249,1409750,1410159,1410898,1411180,1413784,1414794,1417122,1418379,1423293,1425867,1426382,1428544,1429819,1430313,1430697,1430753,1435306,1435674,1438816,1439579,1439599,1439603,1439636,1443321,1447363,1447799,1449573,1449637,1449975,1451355,1451622,1451629,1454469,1454830,1455068,1458703,1459291,1460357,1466233,1467131,1470518,1471142,1471420,1473959,1474054,1474168,1477448,1478128,1479154,1479960,1482269,1483572,1485517,1487056,1487224,1497141,1497163,1497245,1498303,1499782,1500762,1501659,1503298,1504209,1505505,1509153,1512791,1513840,1513845,1514110,1515593,1517208,1517228,1517905,1521005,1525636,1527072,1527238,1529589,1537460,1538621,1539238,1539893,1541014,1541462,1542465,1547958,1548242,1548629,1551305,1551396,1557032,1558092,1562006,1565607,1566819,1569025,1573931,1575593,1577684,1578076,1579339,1581711,1583350,1584073,1584961,1589303,1592173,1593544,1596943);
		$uids[6] = array(1597939,1603154,1605777,1606702,1606807,1607635,1607927,1609455,1609955,1611959,1616421,1616552,1616583,1616710,1618444,1619751,1620916,1621782,1622990,1623062,1623840,1624682,1625664,1626831,1627475,1630206,1632647,1635717,1636157,1637344,1638851,1639791,1639846,1641267,1641880,1643127,1643659,1644246,1644877,1644887,1645223,1645254,1646899,1647301,1648152,1648349,1648504,1656784,1657068,1657671,1659804,1661534,1663352,1665052,1666418,1669135,1673933,1674049,1674070,1675242,1676637,1676706,1677775,1679144,1679307,1679825,1680511,1681070,1683915,1684448,1684872,1685889,1686193,1689261,1691390,1693602,1694113,1699005,1701687,1703042,1707455,1707796,1709068,1711292,1716104,1717893,1718094,1718477,1719039,1720112,1720681,1720856,1721152,1725554,1729192,1730059,1730098,1730193,1730879,1733411,1733894,1734564,1738212,1738596,1741634,1742094,1742646,1743719,1743739,1744914,1746494,1750056,1751665,1754390,1755613,1761878,1762803,1762899,1767414,1768521,1771887,1772319,1773661,1774183,1775019,1775309,1775528,1777653,1778943,1781150,1782176,1783005,1783893,1785186,1785341,1785367,1788167,1788531,1793479,1793801,1795024,1795814,1797995,1798340,1798646,1799392,1800133,1802224,1802470,1802597,1803449,1806705,1806998,1807111,1807231,1808355,1808709,1811196,1811566,1814168,1815024,1816819,1817063,1818742,1818773,1822257,1823105,1823629,1826529,1826555,1827522,1827545,1829415,1830779,1830887,1833068,1833661,1835105,1835393,1836437,1840958,1841048,1842079,1845043,1846932,1848851,1849281,1849633,1849926,1852078,1862808,1863221,1864001,1866252,1866514,1871337,1873637,1873951,1879270,1879479);
		$uids[7] = array(1880142,1884982,1892422,1895065,1897078,1897845,1900805,1902414,1906819,1908743,1912538,1912573,1915902,1920356,1923213,1927807,1929641,1935743,1941494,1948765,1950274,1951195,1961109,1961965,1962735,1962784,1967458,1968759,1968987,1969492,1970743,1970793,1971732,1972570,1973314,1974761,1976103,1977535,1980612,1981988,1984018,1984092,1987305,1987360,1987659,1991463,1995433,1995935,1998891,2001890,2003219,2003957,2005603,2005787,2010397,2011411,2011448,2012889,2014244,2014670,2015770,2016855,2018028,2018530,2018531,2019744,2022070,2023734,2024181,2024187,2025240,2025245,2025254,2025793,2026697,2027949,2028011,2031316,2035178,2035660,2036315,2036661,2037386,2037491,2039207,2039582,2040743,2042148,2042961,2043029,2045450,2051907,2052355,2061241);
		
		$cid = 125332;
		$db = Hapyfish2_Island_Dal_Plant::getDefaultInstance();
		
		$numArr = array();
		
		foreach ($uids[$num] as $uid) {
			$id = 0;	
			$id = $db->getOneCount($uid, $cid);
			$numArr[$uid] = $id;
		}
				
		return $numArr;
	}
	
	/**
	 * @排行榜奖励
	 */
	public static function sendRankPlant()
	{
		$send = new Hapyfish2_Island_Bll_Compensation();
		
		$nowTime = time();
		
		$list = Hapyfish2_Island_Event_Cache_ThanksDay::getRanList();
		foreach ($list as $listArr) {	
			$ok2 = Hapyfish2_Island_Bll_GiftPackage::addGift($listArr['uid'], 26441, 10);
			$ok2 = Hapyfish2_Island_Bll_GiftPackage::addGift($listArr['uid'], 67441, 10);
			$ok2 = Hapyfish2_Island_Bll_GiftPackage::addGift($listArr['uid'], 74841, 10);
			$ok2 = Hapyfish2_Island_Bll_GiftPackage::addGift($listArr['uid'], 124832, 1);
			
			$title = '感恩節排行榜獎勵：船隻加速卡IIIx10,一鍵收取卡x10,雙倍經驗卡x10,禮物蛋糕店x1';
			
			//发feed
			$feed = array('uid' => $listArr['uid'],
						'template_id' => 0,
						'actor' => $listArr['uid'],
						'target' => $listArr['uid'],
						'type' => 3,
						'title' => array('title' => $title),
						'create_time' => $nowTime);
		
			Hapyfish2_Island_Bll_Feed::insertMiniFeed($feed);
			
			if($ok2){
				info_log($listArr['uid'], 'thdayRank');
			}
		}
		
		if ($ok2) {
			return count($list);
		} else {
			return false;
		};
	}
	
}