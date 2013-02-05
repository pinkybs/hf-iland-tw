<?php

class ToolsController extends Zend_Controller_Action
{
	function vaild()
	{

	}

	function check()
	{
		$uid = $this->_request->getParam('uid');
		if (empty($uid)) {
			echo 'uid can not empty';
			exit;
		}

		$isAppUser = Hapyfish2_Island_Cache_User::isAppUser($uid);
		if (!$isAppUser) {
			echo 'uid error, not app user';
			exit;
		}

		return $uid;
	}

	public function addcoinAction()
	{
		$uid = $this->check();
		$coin = $this->_request->getParam('coin');
		if (empty($coin) || $coin <= 0) {
			echo 'add coin error, must > 1';
			exit;
		}

		Hapyfish2_Island_HFC_User::incUserCoin($uid, $coin);

		echo 'OK';
		exit;
	}

	public function addgoldAction()
	{
		$uid = $this->check();
		$gold = $this->_request->getParam('gold');
		if (empty($gold) || $gold <= 0) {
			echo 'add gold error, must > 1';
			exit;
		}

		$goldInfo = array(
			'uid' => $uid,
			'gold' => $gold,
			'type' => 0
		);
		Hapyfish2_Island_Bll_Gold::add($uid, $goldInfo);

		echo 'OK';
		exit;
	}

	public function addstarfishAction()
	{
		$uid = $this->check();
		$starfish = $this->_request->getParam('starfish');
		if (empty($starfish) || $starfish <= 0) {
			echo 'add starfish error, must > 1';
			exit;
		}

		Hapyfish2_Island_HFC_User::incUserStarFish($uid, $starfish);

		echo 'OK';
		exit;
	}

	public function addexpAction()
	{
		$uid = $this->check();
		$exp = $this->_request->getParam('exp');
		if (empty($exp) || $exp <= 0) {
			echo 'add exp error, must > 1';
			exit;
		}

		Hapyfish2_Island_HFC_User::incUserExp($uid, $exp);

		echo 'OK';
		exit;
	}

	public function addcardAction()
	{
		$uid = $this->check();
		$cid = $this->_request->getParam('cid');
		if (empty($cid)) {
			echo 'card id[cid] can not empty';
			exit;
		}

		$count = $this->_request->getParam('count');
		if (empty($count) || $count <= 0) {
			echo 'add card number[count] error, must > 1';
			exit;
		}

		$cardInfo = Hapyfish2_Island_Cache_BasicInfo::getCardInfo($cid);
		if (!$cardInfo) {
			echo 'card id[cid] error, not exists';
			exit;
		}

		Hapyfish2_Island_HFC_Card::addUserCard($uid, $cid, $count);

		echo 'OK';
		exit;
	}

	public function addachievementAction()
	{
		$uid = $this->check();
		$num = $this->_request->getParam('num');
		if (empty($num)) {
			echo 'num can not empty';
			exit;
		}

		if ($num <=0 || $num > 17) {
			echo 'num error, must > 0 and < 18';
			exit;
		}

		$count = $this->_request->getParam('count');
		if (empty($count) || $count <= 0) {
			echo 'add count error, must > 1';
			exit;
		}

		$field = 'num_' . $num;
		Hapyfish2_Island_HFC_Achievement::updateUserAchievementByField($uid, $field, $count);

		echo 'OK';
		exit;
	}

	public function adddailyachievementAction()
	{
		$uid = $this->check();
		$num = $this->_request->getParam('num');
		if (empty($num)) {
			echo 'num can not empty';
			exit;
		}

		if ($num <=0 || $num > 17) {
			echo 'num error, must > 0 and < 18';
			exit;
		}

		$count = $this->_request->getParam('count');
		if (empty($count) || $count <= 0) {
			echo 'add count error, must > 1';
			exit;
		}

		$field = 'num_' . $num;
		Hapyfish2_Island_HFC_AchievementDaily::updateUserAchievementDailyByField($uid, $field, $count);

		echo 'OK';
		exit;
	}

	public function cleardailytaskAction()
	{
		$uid = $this->check();
		Hapyfish2_Island_Cache_TaskDaily::clearAll($uid);

		echo 'OK';
		exit;
	}

	public function changelevelAction()
	{
		$uid = $this->check();
		$level = $this->_request->getParam('level');
		if (empty($level)) {
			echo 'level can not empty';
			exit;
		}

		if ($level <=0 || $level > 200) {
			echo 'level error, level > 0 and < 200';
			exit;
		}

		$levelInfo = array('level' => $level);
		$islandLevelInfo = Hapyfish2_Island_HFC_User::getUserLevel($uid);
		$curIslandLevel = $islandLevelInfo['island_level'];

		$levelInfo['island_level'] = Hapyfish2_Island_Cache_BasicInfo::getIslandLevelInfoByUserLevel($level, 1);
		$levelInfo['island_level_2'] = Hapyfish2_Island_Cache_BasicInfo::getIslandLevelInfoByUserLevel($level, 2);
		$levelInfo['island_level_3'] = Hapyfish2_Island_Cache_BasicInfo::getIslandLevelInfoByUserLevel($level, 3);
		$levelInfo['island_level_4'] = Hapyfish2_Island_Cache_BasicInfo::getIslandLevelInfoByUserLevel($level, 4);

		Hapyfish2_Island_HFC_User::updateUserLevel($uid, $levelInfo);
		$exp = Hapyfish2_Island_Cache_BasicInfo::getUserLevelExp($level);
		Hapyfish2_Island_HFC_User::updateUserExp($uid, $exp + 1, true);

		$step = $levelInfo['island_level'] - $curIslandLevel;

		Hapyfish2_Island_HFC_Plant::upgradeCoordinate($uid, $step);
		Hapyfish2_Island_HFC_Building::upgradeCoordinate($uid, $step);
		echo 'OK';
		exit;
	}

	public function changelevelnoislandAction()
	{
		$uid = $this->check();
		$level = $this->_request->getParam('level');
		if (empty($level)) {
			echo 'level can not empty';
			exit;
		}

		if ($level <=0 || $level > 200) {
			echo 'level error, level > 0 and < 200';
			exit;
		}

		$levelInfo = array('level' => $level);
		$islandLevelInfo = Hapyfish2_Island_HFC_User::getUserLevel($uid);
		$curIslandLevel = $islandLevelInfo['island_level'];

		$levelInfo['island_level'] = $islandLevelInfo['island_level'];
		$levelInfo['island_level_2'] = $islandLevelInfo['island_level_2'];
		$levelInfo['island_level_3'] = $islandLevelInfo['island_level_3'];
		$levelInfo['island_level_4'] = $islandLevelInfo['island_level_4'];

		Hapyfish2_Island_HFC_User::updateUserLevel($uid, $levelInfo);
		$exp = Hapyfish2_Island_Cache_BasicInfo::getUserLevelExp($level);
		Hapyfish2_Island_HFC_User::updateUserExp($uid, $exp + 1, true);

		$step = $levelInfo['island_level'] - $curIslandLevel;

		Hapyfish2_Island_HFC_Plant::upgradeCoordinate($uid, $step);
		Hapyfish2_Island_HFC_Building::upgradeCoordinate($uid, $step);
		echo 'OK';
		exit;
	}

	public function clearhelpAction()
	{
		$uid = $this->check();
		Hapyfish2_Island_Cache_UserHelp::clearHelp($uid);
		echo 'OK';
		exit;
	}
	public function inituserhelpAction()
	{
		$uid = $this->check();
		$info = array('help' => '' ,'help_gift' => '');
		$dalUserHelp = Hapyfish2_Island_Dal_UserHelp::getDefaultInstance();
        $dalUserHelp->update($uid, $info);

		echo 'OK';
		exit;
	}

	public function loadgiftAction()
	{
		$list = Hapyfish2_Island_Cache_BasicInfo::loadGiftList();
		$key = 'island:giftlist';
		$localcache = Hapyfish2_Cache_LocalCache::getInstance();
		$localcache->set($key, $list);
		echo 'OK';
		exit;
	}

	public function fixAction()
	{
		$uid = $this->check();
		$data = Hapyfish2_Island_HFC_Plant::getOnIsland($uid);
		$plants = $data['plants'];
		$praise = 0;
		$plantInfoList = Hapyfish2_Island_Cache_BasicInfo::getPlantList();
		foreach ($plants as $plant) {
			$praise += $plantInfoList[$plant['cid']]['add_praise'];
		}

		$buildings = Hapyfish2_Island_HFC_Building::getOnIsland($uid);
		$buildingInfoList = Hapyfish2_Island_Cache_BasicInfo::getBuildingList();
		foreach ($buildings as $building) {
			$praise += $buildingInfoList[$building['cid']]['add_praise'];
		}

		echo '<br/>cal: ' . $praise;
		$useIsland = Hapyfish2_Island_HFC_User::getUserIsland($uid);
		$curPraise = $useIsland['praise'];

		echo '<br/>current: ' . $curPraise;

		if ($curPraise != $praise) {
			$useIsland['praise'] = $praise;
			Hapyfish2_Island_HFC_User::updateUserIsland($uid, $useIsland, true);
			echo '<br/>save praise';
		}

		$achi = Hapyfish2_Island_HFC_Achievement::getUserAchievement($uid);
		echo '<br/>achi: ' . $achi['num_13'];
		if ($achi['num_13'] != $praise) {
			$achi['num_13'] = $praise;
			Hapyfish2_Island_HFC_Achievement::saveUserAchievement($uid, $achi);
		}

		echo '<br/>num_15: ' . $achi['num_15'];
		$user = Hapyfish2_Island_HFC_User::getUser($uid, array('exp' => 1, 'level' => 1));
		$islandLevelInfo = Hapyfish2_Island_Cache_BasicInfo::getIslandLevelInfo($user['island_level']);
		if ($achi['num_15'] != $islandLevelInfo['max_visitor']) {
			$achi['num_15'] = $islandLevelInfo['max_visitor'];
			Hapyfish2_Island_HFC_Achievement::saveUserAchievement($uid, $achi);
		}

		$realDockPositionCount = Hapyfish2_Island_Cache_Dock::getPositionCount($uid);
		echo '<br/>position_count: ' . $useIsland['position_count'];
		if ($realDockPositionCount && $useIsland['position_count'] != $realDockPositionCount) {
			$useIsland['position_count'] = $realDockPositionCount;
			Hapyfish2_Island_HFC_User::updateUserIsland($uid, $useIsland, true);
		}

		echo '<br/>num_11: ' . $achi['num_11'];

		$userUnlockShipCount = Hapyfish2_Island_Cache_Dock::getUnlockShipCount($uid);
		print_r($userUnlockShipCount);

		Hapyfish2_Island_Cache_Dock::reloadUnlockShipCount($uid);

		exit;
	}

	public function fix2Action()
	{
		$uid = $this->check();
		$buildings = Hapyfish2_Island_HFC_Building::getOnIsland($uid);
		$fixed = false;
		if ($buildings) {
			$builingInfoList = Hapyfish2_Island_Cache_BasicInfo::getBuildingList();
			foreach ($buildings as $building) {
				$item_type = $builingInfoList[$building['cid']]['item_type'];
				if ($item_type != $building['item_type']) {
					$fixed = true;
					$building['item_type'] = $item_type;
					$building['mirro'] = 0;
					Hapyfish2_Island_HFC_Building::updateOne($uid, $building['id'], $building, true);
				}
			}
		}

		echo $fixed ? 'true' : 'false';
		exit;
	}

	public function addgiftsendcountAction()
	{
		$uid = $this->check();
		$count = $this->_request->getParam('count');
		if (empty($count)) {
			echo 'count can not empty';
			exit;
		}

		if ($count <=0 || $count > 100) {
			echo 'count error, count > 0 and < 100';
			exit;
		}

		$giftSendCountInfo = Hapyfish2_Island_Cache_Counter::getSendGiftCount($uid);
		$giftSendCountInfo['count'] += $count;
		Hapyfish2_Island_Cache_Counter::updateSendGiftCount($uid, $giftSendCountInfo);
		echo 'OK';
		exit;
	}

	public function watchuserAction()
	{
		$uid = $this->check();
		$t = time();
		$sig = md5($uid . $t . APP_KEY);

		$this->_redirect('http://main.island.qzoneapp.com/watch?uid=' . $uid . '&t=' . $t . '&sig=' . $sig);
		exit;
	}

	public function userinfoAction()
	{
		$uid = $this->check();
		$platformUser = Hapyfish2_Platform_Bll_User::getUser($uid);
		$islandUser = Hapyfish2_Island_HFC_User::getUser($uid, array('exp', 'coin', 'level'));
		$data = array(
			'face' => $platformUser['figureurl'],
			'uid' => $uid,
			'nickname' => $platformUser['nickname'],
			'gender' => $platformUser['gender'],
			'level' => $islandUser['level'],
			'exp' => $islandUser['exp'],
			'coin' => $islandUser['coin']
		);

		echo json_encode($data);
		exit;
	}

	public function coinlogAction()
	{
		$uid = $this->check();
		$time = time();
		$year = $this->_request->getParam('year');
		if (!$year) {
			$year = date('Y');
		}
		$month = $this->_request->getParam('month');
		if (!$month) {
			$month = date('n');
		}
		$limit = $this->_request->getParam('limit');
		if (!$limit) {
			$limit = 100;
		}

		$logs = Hapyfish2_Island_Bll_ConsumeLog::getCoin($uid, $year, $month, $limit);
		if (!$logs) {
			$logs = array();
		}
		echo json_encode($logs);
		exit;
	}

	public function upgradecoordinateAction()
	{
		$uid = $this->check();
		//Hapyfish2_Island_HFC_Plant::upgradeCoordinate($uid);
		Hapyfish2_Island_HFC_Building::upgradeCoordinate($uid);
		echo 'ok';
		exit;
	}

	public function p2Action()
	{
		$uid = $this->check();
		$data = Hapyfish2_Island_Cache_Background::getAll($uid);
		foreach ($data as $item) {
			if ($item['id'] > 1000) {
				Hapyfish2_Island_Cache_Background::delBackground($uid, $item['id']);
			}
		}
		print_r($data);

		exit;
	}

	public function p3Action()
	{
		$uid = $this->check();
		$fieldInfo = array();

		//25411, 1, 23212, 2, 22213, 3, 25914, 4
            //island
		$fieldInfo['bg_island'] = 25411;
		$fieldInfo['bg_island_id'] = 1;

            //sky
		$fieldInfo['bg_sky'] = 23212;
		$fieldInfo['bg_sky_id'] = 2;

            //sea
		$fieldInfo['bg_sea'] = 22213;
		$fieldInfo['bg_sea_id'] = 3;

            //dock
		$fieldInfo['bg_dock'] = 25914;
		$fieldInfo['bg_dock_id'] = 4;

		$ok = Hapyfish2_Island_HFC_User::updateFieldUserIsland($uid, $fieldInfo);

		echo $ok ? 'OK' : 'Flase';
		$d = Hapyfish2_Island_HFC_User::getUserIsland($uid);
		print_r($d);
		exit;
	}

	public function clearremindAction()
	{
		$uid = $this->check();
		Hapyfish2_Island_Cache_Remind::flush($uid);
		echo 'OK';
		exit;
	}

	public function addinviteAction()
	{
		$uid = $this->check();
		$fid = $this->_request->getParam('fid');
		if (empty($fid)) {
			echo 'fid can not empty';
			exit;
		}

		$isAppUser = Hapyfish2_Island_Cache_User::isAppUser($fid);
		if (!$isAppUser) {
			echo 'fid error, not app user';
			exit;
		}
		Hapyfish2_Island_Bll_InviteLog::add($uid, $fid);
		echo 'OK';
		exit;
	}

	public function loginactiveAction()
	{
		$uid = $this->check();
		$starDays = (int)$this->_request->getParam('starDays', 1);
		$days = (int)$this->_request->getParam('days', 1);
		$loginCount = (int)$this->_request->getParam('loginCount', 1);
		$loginInfo = array(
			'last_login_time' => time() - 86400,
			'active_login_count' => $days,
			'max_active_login_count' => 5,
			'today_login_count' => 0,
			'all_login_count' => $loginCount,
			'star_login_count' => $starDays
		);
		Hapyfish2_Island_HFC_User::updateUserLoginInfo($uid, $loginInfo, true);

		$key = 'i:u:ezinecount:' . $uid;
        $cache = Hapyfish2_Cache_Factory::getMC($uid);
        $data = $cache->get($key);
        $data[2] = 0;
        $cache->set($key, $data, 864000);

		echo 'OK';
		exit;
	}

	public function clearezAction()
	{
		$uid = $this->check();
		$key = 'i:u:ezinecount:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->delete($key);
		echo 'OK';
		exit;
	}

	public function updatetaskAction()
	{

		$uid = $this->_request->getParam('uid');
		//get user achievement info
        $userAchievement = Hapyfish2_Island_HFC_Achievement::getUserAchievement($uid);
        echo json_encode($userAchievement);
		$taskType = $this->_request->getParam('taskType');
		$num = $this->_request->getParam('num');
		$taskType = 'num_' . $taskType;
		Hapyfish2_Island_HFC_Achievement::updateUserAchievementByFieldData($uid, $taskType, $num);

        $dalTask = Hapyfish2_Island_Dal_Task::getDefaultInstance();
        $dalTask->clear($uid);

	    $cache = Hapyfish2_Cache_Factory::getMC($uid);
	    $key = 'i:u:alltask:' . $uid;
		$cache->delete($key);

		$titleInfo = array('title' => 0, 'title_list' => '');
        Hapyfish2_Island_HFC_User::updateUserTitle($uid, $titleInfo);

        Hapyfish2_Island_Cache_Task::updateUserOpenTask(uid, array());
        $keyOpen = 'i:u:openTask2:' . $uid;
        $cache->delete($keyOpen);

		echo 'OK';
		exit;
	}

	public function testcardAction()
	{

		/*$result = Hapyfish2_Island_Bll_Card::useCard(1016, 1016, 26841, 1);

		try {
			Hapyfish2_Island_HFC_AchievementDaily::updateUserAchievementDailyByField(1016, 'num_2', 1);

			Hapyfish2_Island_HFC_Achievement::updateUserAchievementByField(1016, 'num_2', 1);
		} catch (Exception $e) {

		}
		//task id 3004,task type 2
		$checkTask = Hapyfish2_Island_Bll_Task::checkTask(1016, 3004);
		if ( $checkTask['status'] == 1 ) {
			$result['finishTaskId'] = $checkTask['finishTaskId'];
		}
		echo json_encode($result);*/
	}

	public function loginactivenewsAction()
	{
		$uid = $this->check();
		$starDays = (int)$this->_request->getParam('starDays', 1);
		$days = (int)$this->_request->getParam('days', 1);
		$loginCount = (int)$this->_request->getParam('loginCount', 1);
		$loginInfo = array(
			'last_login_time' => time() - 86400,
			'active_login_count' => $days,
			'max_active_login_count' => 5,
			'today_login_count' => 0,
			'all_login_count' => $loginCount,
			'star_login_count' => $starDays
		);
		Hapyfish2_Island_HFC_User::updateUserLoginInfo($uid, $loginInfo, true);
		echo 'OK';
		exit;
	}

	public function clearchangelistAction()
	{
		$key = 'event:pointchalist';
		$EventFeed = Hapyfish2_Cache_Factory::getEventFeed();
		$EventFeed->delete($key);
		echo 'OK';
		exit;
	}

	//发大转盘积分
	public function addpointAction()
	{
		$uid = $this->_request->getParam('uid');
		$point = $this->_request->getParam('point');

		$dalCasino = Hapyfish2_Island_Event_Dal_Casino::getDefaultInstance();
		$dalCasino->updateUserPoint($uid, $point);

		$data = $dalCasino->getUserPoint($uid);

		$key = 'i:u:casinop:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->set($key, $data);

		$feed = '补发积分：' . $point;

        $minifeed = array('uid' => $uid,
                          'template_id' => 0,
                          'actor' => $uid,
                          'target' => $uid,
                          'title' => array('title' => $feed),
                          'type' => 6,
                          'create_time' => time());
        Hapyfish2_Island_Bll_Feed::insertMiniFeed($minifeed);

		$total = $data;

		echo $uid . '  '. $total;
		exit;
	}

	//插入title
	public function gaintitleAction()
	{
		$uid = $this->_request->getParam('uid');
		$titleId = $this->_request->getParam('tid');

		try {
        	Hapyfish2_Island_HFC_User::gainTitle($uid, $titleId, true);
		} catch (Exception $e) {
			echo 'false';
			exit;
		}
		echo 'ok';
		exit;
	}

    public function loadshiplistAction()
    {
    	$list = Hapyfish2_Island_Cache_BasicInfo::loadShipList();
		$key = 'island:shiplist';
		$localcache = Hapyfish2_Cache_LocalCache::getInstance();
		$localcache->set($key, $list, false);

		echo 'OK';
		exit;
    }

	function clearnewislandAction()
    {
    	$uid = $this->_request->getParam('uid');
    	$islandInfo = Hapyfish2_Island_HFC_User::getUserIsland($uid);
    	$islandInfo['unlock_island'] = '1';
    	$islandInfo['current_island'] = 1;
    	Hapyfish2_Island_HFC_User::updateFieldUserIsland($uid, $islandInfo);

    	$userVo = Hapyfish2_Island_HFC_User::getUserVO($uid);
        $userLevelInfo = array('level' => $userVo['level'],
							   'island_level' => $userVo['island_level'],
							   'island_level_2' => 0,
							   'island_level_3' => 0,
							   'island_level_4' => 0);
        Hapyfish2_Island_HFC_User::updateUserLevel($uid, $userLevelInfo);

        //$dalBackground = Hapyfish2_Island_Dal_Background::getDefaultInstance();
        //$dalBackground->clear($uid);
        $dalBuilding = Hapyfish2_Island_Dal_Building::getDefaultInstance();
        $dalBuilding->clearNewIsland($uid);
        $dalPlant = Hapyfish2_Island_Dal_Plant::getDefaultInstance();
        $dalPlant->clearNewIsland($uid);

		$cache = Hapyfish2_Cache_Factory::getMC($uid);

        $key1 = 'island:allplantonisland:' . $uid . ':' . '2';
		$cache->delete($key1);
        $key2 = 'island:allplantonisland:' . $uid . ':' . '3';
		$cache->delete($key2);
        $key3 = 'island:allplantonisland:' . $uid . ':' . '4';
		$cache->delete($key3);

		$key4 = 'i:u:bldids:onisl:' . $uid . ':' . '2';
		$cache->delete($key4);
		$key5 = 'i:u:bldids:onisl:' . $uid . ':' . '3';
		$cache->delete($key5);
		$key6 = 'i:u:bldids:onisl:' . $uid . ':' . '4';
		$cache->delete($key6);

		$key7 = 'i:u:pltids:onisla:' . $uid . ':' . '2';
		$cache->delete($key7);
		$key8 = 'i:u:pltids:onisla:' . $uid . ':' . '3';
		$cache->delete($key8);
		$key9 = 'i:u:pltids:onisla:' . $uid . ':' . '4';
		$cache->delete($key9);

		$key10 = 'i:u:isfstin:' . $uid . ':' . '2';
		$cache->delete($key10);
		$key11 = 'i:u:isfstin:' . $uid . ':' . '3';
		$cache->delete($key11);
		$key12 = 'i:u:isfstin:' . $uid . ':' . '4';
		$cache->delete($key12);

		echo 'OK';
		exit;
    }

    function savediyAction()
    {
    	$dbId = $this->_request->getParam('dbid');
    	Hapyfish2_Island_Tool_Savediy::savedbAllUser($dbId);

		echo 'OK';
		exit;
    }

    //修复建筑信息(触发建设任务)
    function repairplantAction()
    {
    	$cid = $this->_request->getParam('cid');
    	$uid = $this->_request->getParam('uid', 1);
    	Hapyfish2_Island_Tool_Repair::repairUserPlant($cid, $uid);

		echo 'OK';
		exit;
    }

    //修复没有uid白屏
    function repairuserAction()
    {
    	$uid = $this->_request->getParam('uid');
    	Hapyfish2_Island_Tool_Repair::repairUserInfo($uid);

		echo 'OK';
		exit;
    }

    //清楚成就任务缓存
    function cleartitlecacheAction()
    {
    	$uid = $this->_request->getParam('uid');

    	$key = 'i:u:ach:' . $uid;
        $cache = Hapyfish2_Cache_Factory::getHFC($uid);
        $cache->delete($key);

        echo 'OK';
        exit;
    }

    function clearuserxmasAction()
    {
    	$uid = $this->_request->getParam('uid');

    	$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$mkeyUid = 'event_xmas_fair_daily_' . $uid;
		$cache->set($mkeyUid, false);

		echo 'OK';
		exit;
    }

    function clearxmasinfoAction()
    {
    	$mkey = 'event_xmas_fair';
		$cacheInfo = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cacheInfo->delete($mkey);

		echo 'OK';
		exit;
    }
	public function addboatAction()
	{
		$uid = $this->_request->getParam('uid');
		$positionId = $this->_request->getParam('pid');

		if ( !in_array($positionId, array(4,5,6,7,8)) ) {
			echo 'False';
			exit;
		}

		Hapyfish2_Island_HFC_Dock::expandPosition($uid, $positionId, 10);

		echo 'OK';
		exit;
	}

	public function updatetimegiftAction()
	{
		$uid = $this->_request->getParam('uid');
		$step = $this->_request->getParam('step');

		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$key = 'event_timegift_' . $uid;
		$val = $cache->get($key);
		$val['state'] = $step;
		$val['time_at'] = time();
		$cache->set($key, $val, 100000);

		echo 'OK';
		exit;
	}
	
	//扣卡片
	public function clearusercardAction()
	{
		$uid = $this->_request->getParam('uid');
		$cid = $this->_request->getParam('cid');
		$num = $this->_request->getParam('num');
		Hapyfish2_Island_HFC_Card::useUserCard($uid, $cid, $num);
		echo "OK";
		exit;
	}
	
	//清大转盘缓存
	public function clearcasinoawardAction()
	{
		$key = 'island:caisnoawardtype';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->delete($key);
		
		echo 'OK';
		exit;
	}
	
	//清除fans奖励
	public function clearfansAction()
	{
		$uid = $this->_request->getParam('uid');
		
		$key = 'permission:gift:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->set($key, false);
		
		$db = Hapyfish2_Island_Dal_Permissiongift::getDefaultInstance();
		$db->deleteHas($uid);
		
		echo $uid;
		exit;
	}
	
	//登陆翻牌缓存读取
	public function getusercacheAction()
	{
		$uid = $this->_request->getParam('uid');
		
		$mckey = Hapyfish2_Island_Bll_DailyAward::$_mcKeyPrex . $uid;
        $cache = Hapyfish2_Cache_Factory::getMC($uid);
        $dailyReward = $cache->get($mckey);
		
		print_r('<pre>');print_r($dailyReward);print_r('</pre>');
		
		echo 'OK';
		exit;
	}
	
	//登陆翻牌缓存清理
	public function cleardlyawardAction()
	{
		var_dump(1);
		$uid = $this->check();
		$mckey = Hapyfish2_Island_Bll_DailyAward::$_mcKeyPrex . $uid;
	    $cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->delete($mckey);
		echo 'OK';
		exit;
	}
	
	public function teambuyAction()
	{
		$uid = $this->_request->getParam('uid');
		
		$mkey = 'i:e:teambuy:buygood:' . $uid;
		$mcache = Hapyfish2_Cache_Factory::getMC($uid);
		$mcache->delete($mkey);
		
		echo 'OK';
		exit;
	}
	
	public function loadlotterylistAction()
	{
		Hapyfish2_Island_Cache_LotteryItemOdds::loadLotteryItemOddsList(1);
        echo 'ok';
        exit;
	}

	public function loadlocallotterylistAction()
	{
		$key = 'island:lotteryitemodds:1';
		$localcache = Hapyfish2_Cache_LocalCache::getInstance();
		$cache = Hapyfish2_Island_Cache_LotteryItemOdds::getBasicMC();
		$list = $cache->get($key);
		$localcache->set($key, $list);
        echo SERVER_ID . 'ok';
        exit;
	}

	public function getlocallotterylistAction()
	{
		$key = 'island:lotteryitemodds:1';
		$localcache = Hapyfish2_Cache_LocalCache::getInstance();
		$list = $localcache->get($key);
		print_r($list);
		exit;
	}
	
	public function cleanqixieventAction()
	{
		$tid = $this->_request->getParam('tid');
		
		$key = 'event_xmas_qixi_fair';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		
		if ($tid == 1) {
			$cache->delete($key);
		} else {
			$old = $cache->get($key);
			print_r('<pre>');print_r($old);print_r('</pre>'); echo'<br>';
		}		
		
		echo 'OK';
		exit;
	}
	
	//扣宝石
	public function decusergoldAction()
	{
		$uid = $this->_request->getParam('uid');
		$decGold = $this->_request->getParam('gold');
		
		$userGold = Hapyfish2_Island_HFC_User::getUserGold($uid);
		
		if ($decGold > $userGold) {
			$decGold = $userGold;
		}
		
		//获取用户等级
		$userLevelInfo = Hapyfish2_Island_HFC_User::getUserLevel($uid);
		$userLevel = $userLevelInfo['level'];
		
		//扣除宝石
		$goldInfo = array('uid' => $uid,
						'cost' => $decGold,
						'summary' => '',
						'user_level' => $userLevel,
						'create_time' => time(),
						'cid' => '',
						'num' => 0);

        $ok = Hapyfish2_Island_Bll_Gold::consume($uid, $goldInfo);
		
		info_log($uid . ' -> ' . $decGold . ' | ' . $userGold, 'DecGold');
		
		$result = $ok ? 'OK' : 'not';
		echo $result;
		exit;
	}
	
	//一元店充值信息
	public function testpayoneAction()
	{
		$uid = $this->_request->getParam('uid');
		
		Hapyfish2_Island_Event_Bll_OneGoldShop::setPayInfo($uid);
		
		echo 'OK';
		exit;
	}
	
	//连续登陆物品更换缓存
	public function clearconfigAction()
	{
		$key = 'i:award:config';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->delete($key);
		
		echo "OK";
		exit;
	}
    
	//捕鱼 清除鱼信息列表
	public function clearfishAction()
	{
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$key = 'i:e:l:p:flist:' . 1 ;
		$cache->delete($key);
		$key = 'i:e:l:p:flist:' . 2 ;
		$cache->delete($key);
		$key = 'i:e:l:p:flist:' . 3 ;
		$cache->delete($key);
		$key = 'i:e:l:p:flist:' . 4 ;
		$cache->delete($key);
		$key = 'i:e:l:p:flist:' . 5 ;
		$cache->delete($key);							
		echo 'ok';
		exit;		
	}
	
	public function clearfishallAction()
	{
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$key = 'i:e:flistall';
		$cache->delete($key);							
		echo 'ok';
		exit;		
	}	
	//捕鱼 清除鱼信息详细
	public function clearfishinfoAction()
	{
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		for($i=1;$i<=100;$i++) {
		$key = 'i:e:l:p:finfo:' . $i ;
		$cache->delete($key);	
		}					
		echo 'ok';
		exit;		
	}
	//捕鱼 清除商品信息
	public function clearproductAction()
	{
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$key = 'i:e:tb:pd';
		$cache->delete($key);						
		echo 'ok';
		exit;		
	}
	//捕鱼 清除领域信息
	public function cleardomainAction()
	{
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$key = 'i:e:l:p:fdomain';
		$cache->delete($key);						
		echo 'ok';
		exit;		
	}
	public function clearproductproAction()
	{
		$productid = $this->_request->getParam('pid');
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		for($i=1;$i<=5;$i++) {
			$key = 'i:e:tb:pd:prob:l:pid:' . $i . ':' . $productid;
			$cache->delete($key);
		}
		echo 'ok';
		exit;	
	}
	/*
	public function clearfishuserinfoAction()
	{
		$uid = $this->_request->getParam('uid');
        $key = 'i:e:u:initfish:' . $uid;
        $cache = Hapyfish2_Cache_Factory::getHFC($uid);
        $cache->delete($key);
		echo 'ok';
		exit;	
	}
	
	//捕鱼达人称号测试
	public function updateusertitleAction()
	{
		$flag = $this->_request->getParam('flag');
		$uids = array(1012);
		$titleId = 100;
		
		$nowTime = time();
		if($flag==1) {
			$feed = '恭喜你获得称号<font color="#FF0000"> 捕鱼达人</font>';
		}elseif($flag==2) {
			$feed = '取消称号<font color="#FF0000"> 捕鱼达人</font>';
		}
		foreach ($uids as $uid) {
			if($flag==1) {
				Hapyfish2_Island_HFC_User::gainTitle($uid, $titleId, true);
			}elseif($flag==2) {
				Hapyfish2_Island_HFC_User::delTitle($uid, $titleId, true);
			}
        	$minifeed = array(
						'uid' => $uid,
						'template_id' => 0,
						'actor' => $uid,
						'target' => $uid,
						'title' => array('title' => $feed),
						'type' => 3,
						'create_time' => $nowTime
					);

			Hapyfish2_Island_Bll_Feed::insertMiniFeed($minifeed);
		}
		
		echo 'OK';
		exit;
	}
	*/	
	
	//清空feed
	public function cleafeedAction()
	{
		$uid = $this->_request->getParam('uid');
		
		$key = 'i:u:feed:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getFeed($uid);
		$cache->delete($key);
				
		echo 'OK';
		exit;
	}
	
	//发物品
	public function addgiftAction()
	{
		$uid = $this->_request->getParam('uid');
		$item_id = $this->_request->getParam('cid');
		$item_num = $this->_request->getParam('num');
		
		$ok = Hapyfish2_Island_Bll_GiftPackage::addGift($uid, $item_id, $item_num);
		
		echo $ok ? 'OK' : 'Err';
		exit;
	}

    //所有用户缓存落地
    public function saveusercacheAction()
    {
        Hapyfish2_Island_Tool_Savecache::saveAllUserCacheByDB($dbId, $tableId);
        
        echo 'OK';
        exit;
    }
    
	//補發捕鱼达人稱號
	public function sendusertitleAction()
	{
		$flag = $this->_request->getParam('flag');
		$uid = $this->_request->getParam('uid');
		if(!$uid) {
			echo 'Check Uid!';
			exit;
		}
		$titleId = 100;
		
		$nowTime = time();
		if($flag==1) {
			$feed = '補發稱號<font color="#FF0000"> 捕魚達人</font>';
		}
		Hapyfish2_Island_HFC_User::gainTitle($uid, $titleId, true);
        $minifeed = array(
					'uid' => $uid,
					'template_id' => 0,
					'actor' => $uid,
					'target' => $uid,
					'title' => array('title' => $feed),
					'type' => 3,
					'create_time' => $nowTime
				);
				
    	$db = Hapyfish2_Db_Factory::getEventDB('db_0');
    	$rdb = $db['r'];
    	$sqlCheck = 'SELECT date FROM catchfish_rank ORDER BY date DESC LIMIT 1';
    	$date = $rdb->fetchOne($sqlCheck);
    	
		Hapyfish2_Island_Bll_Feed::insertMiniFeed($minifeed);
		$dalFish = Hapyfish2_Island_Event_Dal_GetFishRank::getDefaultInstance();
		$info = array();
		$info['uid'] = $uid;
		$info['rank'] = 0;
		$info['date'] = $date;
		$info['num'] = 0;
		$dalFish->FishRank($info);		
		echo 'OK';
		exit;
	} 
	public function getlastdateuserAction() 
	{
		$dalFish = Hapyfish2_Island_Event_Dal_GetFishRank::getDefaultInstance();
		$lastUids = $dalFish->getLastDateUser();
    	print_r($lastUids);
    	echo 'OK';
    	exit;		
	} 
	
	public function clearpayoncedataAction()
	{
		$dateFor = Hapyfish2_Island_Event_Bll_EventPay::getPayFor();
		
		$key = 'ev:eventpay:gift:' . $dateFor['dateFor'];
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->delete($key);

		echo 'OK';
		exit;
	}
	
	public function clearpayflagboxAction()
	{
		$uid = $this->_request->getParam('uid');
		
		$db = Hapyfish2_Island_Event_Dal_EventPay::getDefaultInstance();
		$db->deletePayFlag($uid);
		
		$key = 'ev:event:first:0301:flag:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->delete($key);
		
		echo 'OK';
		exit;
	}
	
	public function clearfishtaskstaticAction()
	{
		$key = 'ev:fish:task:static';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->delete($key);
		
		echo 'OK';
		exit;
	}
	
	public function testfishtaskAction()
	{
		$uid = $this->_request->getParam('uid');
		$id = $this->_request->getParam('id');
		$num = $this->_request->getParam('num');
		
		
		//每日任务
		$catchFishTaskInitVo = Hapyfish2_Island_Cache_Fish::getCatchFishTaskInitVo($uid);
		
		foreach ($catchFishTaskInitVo as $taskKey => $catchFishTask) {
			if ($id == $catchFishTask['id']) {
				$catchFishTaskInitVo[$taskKey]['yetCatchNum'] += $num;
				break;
			}
		}
		
		Hapyfish2_Island_Cache_Fish::renewCatchFishTaskInitVo($uid, $catchFishTaskInitVo);
		
		echo 'OK';
		exit;
	}

	public function clearfishtaskdataAction()
	{
		$uid = $this->_request->getParam('uid');
		
		$key = 'i:u:fish:task:new:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->delete($key);
		
		echo 'OK';
		exit;
	}
	
	public function clearfishstaticdataAction()
	{
		$key = 'i:fish:map';
		$key1 = 'i:fish:island';
		$key2 = 'i:fish:fsall';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->delete($key);
		$cache->delete($key1);
		$cache->delete($key2);
		
		echo 'OK';
		exit;
	}
	
	public function clearfishislandlocksAction()
	{
		$uid = $this->_request->getParam('uid');
		
		$key = 'i:u:fish:uinfo' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->delete($key);
		
		echo 'OK';
		exit;
	}
	

	public static function loadmatchfishAction()
	{
		Hapyfish2_Island_Cache_FishCompound::loadBasic();

		Hapyfish2_Island_Cache_FishCompound::loadSkill();

		Hapyfish2_Island_Cache_FishCompound::loadTrack();

		Hapyfish2_Island_Cache_FishCompound::loadObstacle();
		$list = Hapyfish2_Island_Cache_FishCompound::loadAward();
		Hapyfish2_Island_Cache_FishCompound::loadGuide();
		Hapyfish2_Island_Cache_Vip::loadvip();
		print_r($list);
		$data = array('result' => 'OK');
		echo "ok";
		exit;
	}

	public function loadlocalmatchfishAction()
	{
		$cache = Hapyfish2_Island_Cache_FishCompound::getBasicMC();
		$localcache = Hapyfish2_Cache_LocalCache::getInstance();
		$key = 'i:fish:comp';
		$list = $cache->get($key);
		$localcache->set($key, $list, false);

		$key = 'i:f:skill';
		$list = $cache->get($key);
		$localcache->set($key, $list, false);

		$key = 'i:f:track';
		$list = $cache->get($key);
		$localcache->set($key, $list, false);

		$key = 'i:f:obstacle';
		$list = $cache->get($key);
		$localcache->set($key, $list, false);
		$key = 'i:f:m:guide';
		$list = $cache->get($key);
		$localcache->set($key, $list, false);
		$key = 'i:f:m:award';
		$list = $cache->get($key);
		$localcache->set($key, $list, false);
		$key = 'i:fish:vip';
		$list = $cache->get($key);
		$localcache->set($key, $list, false);
		$data = array('result' => SERVER_ID.' OK');
		echo "ok";
		exit;
	}
	public function getachievementAction()
	{
		$uid = $this->_request->getParam('uid');
		
		$userAchievement = Hapyfish2_Island_HFC_Achievement::getUserAchievement($uid);
		
		print_r('<pre>');print_r($userAchievement);print_r('</pre>');
		exit;
	}
	
	public function adduserfishAction()
	{
		$uid = $this->_request->getParam('uid');
		$fid = $this->_request->getParam('fid');
		$num = $this->_request->getParam('num');
		for($i=0;$i<=$num;$i++){
			Hapyfish2_Island_Cache_Fish::setUserFish($uid, $fid);
		}
		echo "ok";
		exit;
	}
	
	public function adduserskillAction()
	{
		$uid = $this->_request->getParam('uid');
		$id = $this->_request->getParam('id');
		$num = $this->_request->getParam('num');
		Hapyfish2_Island_Cache_FishCompound::addUserSkill($uid,$id,$num);
		echo "ok";
		exit;
	}
	public function clearusergameAction()
	{
		$uid = $this->_request->getParam('uid');
		$key = 'i:u:f:m:game:'.$uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->delete($key);
		echo "ok";
		exit;
	}
	
	public function clearfishguideAction()
	{
		$uid = $this->_request->getParam('uid');
		$key = 'i:u:f:m:guide:'.$uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->set($key,0);
		$key = 'i:u:m:f:a'.$uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->set($key,array());
		$key = 'i:u:f:m:game:'.$uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->delete($key);
		echo "ok";
		exit;
	}
	
	public function cleartracklimitAction()
	{
		$uid = $this->_request->getParam('uid');
		$id = $this->_request->getParam('id');
		$key = 'i:u:f:m:limit:'.$uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);
		$data['list'][$id] = 0;
		$cache->set($key,$data);
		echo "ok";
		exit;
	}
	
	public function insertusercomfishAction()
	{
		$uid = $this->_request->getParam('uid');
		$cid = $this->_request->getParam('cid');
		Hapyfish2_Island_Bll_FishCompound::insertUserFish($uid,$cid);
		echo "ok";
		exit;
	}
	
	public function clearmidyearAction()
	{
		$key = 'ev:midyear:items';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->delete($key);

		echo 'OK';
		exit;
	}

	public function decusercardAction()
	{
		$uid = $this->_request->getParam('uid');
		$cid = $this->_request->getParam('cid');
		$num = $this->_request->getParam('num');
		
		$userCard = Hapyfish2_Island_HFC_Card::getUserCard($uid);
		
		if ($userCard[$cid] > 0) {
			$lastCount = $userCard[$cid]['count'] - $num;
			
			if ($lastCount < 0) {
				$lastCount = 0;
			}
			
			$userCard[$cid] = array('count' => $lastCount, 'update' => 0);
		}
		
        Hapyfish2_Island_HFC_Card::updateUserCard($uid, $userCard, true);
		
		echo "ok";
		exit;
	}

	public function getuserckillAction()
	{
		$uid = $this->_request->getParam('uid');
		
		$list = Hapyfish2_Island_Cache_FishCompound::getUserSkill($uid);
		
		print_r('<pre>');print_r($list);print_r('</pre>');
		echo 'OK';
		exit;
		
	}
	public function adduserfishnewAction()
	{
		$uid = $this->_request->getParam('uid');
		$fid = $this->_request->getParam('fid');
		$num = $this->_request->getParam('num');

		for ($i = 1; $i <= $num; $i++) {
			Hapyfish2_Island_Cache_Fish::setUserFish($uid, $fid);
		}
			
		echo "ok";
		exit;
	}
	
	public function clearfishpropAction()
	{
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		for($i=1;$i<=25;$i++) {
			for($j=1;$j<=2;$j++) {
				$key = 'i:u:fish:ctfhs:'.$i.':'.$j;
				$cache->delete($key);
			}				
		}
		echo 'OK';
		exit;
	}
	
	public function clearfishinfonewAction()
	{
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		for ($fishId = 1; $fishId <= 100; $fishId++ ) {
			$key = 'i:u:fish:finfo:' . $fishId;
			$cache->delete($key);
		}
		
		echo 'OK';
		exit;
	}
	
	public function getawardAction()
	{
		$uid = $this->_request->getParam('uid');
		Hapyfish2_Island_Bll_FishCompound::getAward($uid);
		echo "ok";
		exit;
	}
	
	public function addaltarnumAction()
	{
		$num = $this->_request->getParam('num');
		
		$key = 'ev:Altar:num';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->set($key, $num);
		
		echo 'OK';
		exit;
	}
	
	public function adduserreAction()
	{
		$uid = $this->_request->getParam('uid');
		$userNum = $this->_request->getParam('num');
		Hapyfish2_Island_Cache_FishCompound::updateUserPrestige($uid, $userNum);
		echo "ok";
		exit;
	}
	
	public function addvipAction()
	{
		$uid = $this->_request->getParam('uid');
		$num = $this->_request->getParam('num');
		Hapyfish2_Island_Bll_Vip::insertGem($uid, $num);
		echo 'OK';
		exit;
	}
	
	public function clearvipAction()
	{
		$uid = $this->_request->getParam('uid');
		Hapyfish2_Island_Cache_Vip::updateGem($uid, 0);
		echo 'OK';
		exit;
	}
	
	public function clearprestigeAction()
	{
		$key = 'i:f:m:t:p:ex';
		$cache = Hapyfish2_Island_Cache_FishCompound::getBasicMC();
		$cache->delete($key);
		echo "ok";
		exit;
	}
	
	public function senduserskillAction()
	{
		$data = array(2136656,15077,1706982,2080037,263601,1723582,207407,1049344,1768521,1461445,1596270,977506,1044422,1448004,1987162,2001680,647427,1329127,187248,1598699,1756787,1403932,168260,647408,117034,994168,1508710,2057825,624728,1477214,1980212,1274455,868495,1898066,1687606,389786,1702614,529783,1749182,103758,1761371,1113040,668100,1533089,983824,254865,1404225,1163807,1704241,1907000,570286,2087125,788507,300128,1618444,758188,704449,
			1098009,2125007,1047228,1367200,1246915,1003209,940765,1638899,911031,98555,201618,664024,453782,1585951,1358605,1258753,1093311,241535,1766547,887721,151740,639107,262095,2053098,1504145,522886,1311750,1051277,1772623,1358701,1268219,2052860,725090,909362,1856056,1991727,119777,
			863223,1614835,170707,275359,1262812,54684,1313478,2076047,169933,57037,444366,873533,342295,416572,973414,416054,19854,1741242,779886,533252,893929,49873,617836,330037,931474,2067135,882152,1816076,355540,1272649,1986741,38308,1153328,1030093,1199688,2034195,
			2077149,216985,883754,2071796,1499322,106197,1680511,1368117,649757,148575,208919,2110712,1527072,1802224,978365,141425,591539,837303,1741826,131297,1529162,305210,1892422,875661,1771887,1716104,606415,1641880,1752456,967403,461592,1340340,784041,370876,1095983,792735,173679,2023286,1886490,349373,255785,446715,2057825,880502,1059698,1730565,1991912,411855,735444,632176,1970743,1936885,865993,947538,888045,856601,725797,2061268,
			138412,2139655,1643554,230752,1658769,2046007,2011717,2048860,731895,1832553,20356,256548,1241540,310142,1758812,681814,115567,319738,811756,1538683,2036661,1598743,1079809,1059034,1782176,661350,869927,1686655,888199,149055,1160008,93221,1257065,322712,418426,1527072,1382724,1573931,1944881,1813164,1134216,1055089,976648,756485,838889,2008354,2117477,1990897,1680364,335678,266744,1523303,1978262,1074415,2090441,518512,629099,1292455,166356,2052171,2075728,1839275,1832553,2068046,1857301,2008354,2082206,967117,1839275,1727625,2057595,
			2053909,1456519,1676516,611268,1619843,64347,138721,1893245,137508,1262812,941464,1330036,297488,1641220,875364,1350583,141352,1624503,899700,885489,1009456,884533,1236307,886222,1235237,868208,86530,963568,83499,84125,766810,440886,1807283,895877,1763790,1323470,1105665,202671,1785935,1330655,766810,1701970,1990990,1527072,725339,2089700,1814546,367119,902050,870021,570480,62857,1321147,648476,1523269,1647821,1644959,1684697,866149,757061,36977,232028,1685284,834674,1569025,3654,899783,902939,2153268,1046063,345455,192167,146031,
			1597992,73046,886060,863386,1009106,203431,99092,322712,1584457,85388,1704667,909484,1600278,1967093,2045737,927486,1944881,1696325,890570,2030242,2083250,615643,1200803,2045020,213624,78623,2058053,2083250,880502,112765,1830806,138721,1523303,1049997,2061106,178860,1457981,2010584,408580,838889,73046,1658769,1357748,127570,404854,256548,623548,1852078,85388,319738,623548,1852078,623548,920565,1785935,1548730,1990990,1389946,636188,1321147,1818490,700824,1852102,1822206,322712,517387);
		foreach($data as $uid){
			Hapyfish2_Island_Cache_FishCompound::addUserSkill($uid, 1, 5);
			Hapyfish2_Island_Cache_FishCompound::addUserSkill($uid, 16, 5);
		}
		echo "ok";
		exit;
	}
	
	
public function getplantnumAction()
	{
		$num = 0;
		$start = $this->_request->getParam('start');
		$end = $this->_request->getParam('end');
		$cid = $this->_request->getParam('cid');
		for($i=$start;$i<$end;$i++){
			for($j=0;$j<=49;$j++){
				$db[$i][]= DATABASE_NODE_NUM*$j + $i;
			}
		}
		$dal = Hapyfish2_Island_Event_Dal_Peidui::getDefaultInstance();
		foreach($db as $k => $v){
			foreach($v as $k1 => $v1){
				$count = $dal->getUid($v1, $cid);
				if($count) {
					$num += $count;
				}
			}
		}
		
		echo $num;
		exit;
	}
	
	public function testpayAction()
	{
		$uid = $this->_request->getParam('uid');
		$amount = $this->_request->getParam('amount');
		
		$ok = Hapyfish2_Island_Bll_Payment::sendAdditionItem($amount, $uid);
		Hapyfish2_Island_Cache_Fish::updateUnlock5($uid);
		echo $ok ? 'OK' : 'NOT';
		exit;
	}
	
	public function unlockfishAction()
	{
		$uid = $this->_request->getParam('uid');
		$id = $this->_request->getParam('id');
		Hapyfish2_Island_Cache_FishCompound::updateUserLock($uid, $id);
		echo "ok";
		exit;
	}
	
	public function clearskillAction()
	{
		$uid = $this->_request->getParam('uid');
		$key = 'i:u:f:m:skill:'.$uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->delete($key);
		echo "ok";
		exit;
	}
}