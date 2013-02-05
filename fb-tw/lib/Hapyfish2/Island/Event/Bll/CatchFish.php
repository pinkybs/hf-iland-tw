<?php

class Hapyfish2_Island_Event_Bll_CatchFish
{
	public static $_fishNumArr = array(
			1 => 0,
			2 => 0,
			3 => 1000,
			4 => 2000,
			5 => 3000,
			6 => 1
		);
	public static function initFishUserCache($uid)
	{
		$time = strtotime('Sunday');
		$time = strtotime(date('Y-m-d',$time).' 23:59:59');		
		$key = 'i:e:u:initfish:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		
		$data = $cache->get($key);
		if ($data === false) {
			$data = array();
			$data['uid'] = $uid;
			$data['route'] = 0;
			$data['level'] = 1;
			$data['dayFishNum'] = 0;
			$data['weekFishNum'] = 0;
			$data['time'] = date('Ymd');
			$cache->add($key, $data, $time);			
		}
		if(!isset($data['time'])) {
			$data['dayFishNum'] = 0;
			$data['weekFishNum'] = 0;
			$data['time'] = date('Ymd');			
		}
		return $data;
	}
	
	public static function setFishUserCache($uid, $route, $nextLevel, $dayFishNum, $weekFishNum)
	{
		$time = strtotime('Sunday');
		$time = strtotime(date('Y-m-d',$time).' 23:59:59');		
		$key = 'i:e:u:initfish:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = array();
		$data['uid'] = $uid;
		$data['route'] = $route;
		$data['level'] = $nextLevel;
		$data['dayFishNum'] = $dayFishNum;
		$data['weekFishNum'] = $weekFishNum;
		$data['time'] = date('Ymd');		
		$cache->set($key, $data, $time);		
	}
	public static function getFishUserStartPlay($uid)
	{
		$key = 'i:e:u:startplay:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);
		if($data === false) {
			$cache->add($key, 0);
			return 1;
		}else {
			return 0;
		}
	}	
	public static function setHelpFlag($uid, $flag)
	{
		$key = 'i:e:u:helpflag:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = array(
			'time' => date('Ymd'),
			'isHideHelpView' =>	$flag
		);
		$cache->set($key, $data);
	}	
	public static function getHelpFlag($uid)
	{
		$key = 'i:e:u:helpflag:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);

		if(!$data) {
			return 1;
		}else {
			if($data['time'] != date('Ymd')) {
				return 1;
			}else {
				return $data['isHideHelpView'];
			}
		}
	}
	public static function clearUserPlantDiscount($uid)
	{
		$key = 'i:e:u:plantdiscount:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->delete($key);
	}	
	public static function getUserPlantDiscount($uid)
	{
		$key = 'i:e:u:plantdiscount:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);
		return $data;
	}	
	public static function setUserPlantDiscount($uid, $info)
	{
		$key = 'i:e:u:plantdiscount:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = array(
			'cid' => $info['cid'],
			'discount' =>$info['discount'],
			'pid' => $info['pid']
		);
		$cache->set($key, $data);
		return $data;
	}	
	public static function domainCache()
	{
		$key = 'i:e:l:p:fdomain';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($key);
		if ($data === false) {
			try {
	        	$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
				$data = $dalFish->getFishDomain();		
	            $cache->add($key, $data);
			} catch (Exception $e) {
				return array();
			}			
		}
		return $data;
	}	
	public static function fishListCache($level)
	{
		$key = 'i:e:l:p:flist:' . $level;
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($key);
		if ($data === false) {
			try {
	        	$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
				$data = $dalFish->getFishList($level);		
	            $cache->add($key, $data);
			} catch (Exception $e) {
				return array();
			}			
		}
		return $data;
	}
	public static function fishListAllCache()
	{
		$key = 'i:e:flistall';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($key);
		if ($data === false) {
			try {
	        	$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
				$data = $dalFish->getFishListAll();		
	            $cache->set($key, $data);
			} catch (Exception $e) {
				return array();
			}			
		}
		return $data;		
	}
	public static function fishInfoCache($id)
	{
		$key = 'i:e:l:p:finfo:' . $id;
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($key);
		if ($data === false) {
			try {
	        	$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
				$data = $dalFish->getFishInfo($id);		
	            $cache->add($key, $data);
			} catch (Exception $e) {
				return array();
			}			
		}
		return $data;
	}	
	//更新排行榜
	public static function inFishRank($uid, $weekFishNum)
	{
		$mkey = 'i:e:fishnumrank';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($mkey);	
		$info = array();
		$info['uid'] = $uid;
		$info['fishnum'] = $weekFishNum;
		$flag=1;
		if($data) {
			foreach($data as $k=>$v) {
				if($v['uid']==$uid) {
					if($v['fishnum']<$weekFishNum) {
						unset($data[$k]);
					}else {
						$flag=0;
					}
				} 
			}
		}
		if($flag==1) {
			$userinfo = Hapyfish2_Island_Bll_User::getUserInit($uid);
			$info['name'] = $userinfo['name'];
			$info['time'] = time();
			$data[] = $info;
		}

		foreach ($data as $key => $row) {
			$voyage[$key]  = $row['fishnum'];
			$time[$key]  = $row['time'];
		}
		array_multisort($voyage, SORT_DESC, $time, SORT_ASC, $data);
		if(count($data)>100) {
			array_pop($data);
		}
		$cache->set($mkey, $data);
		return;
	}
	
	//获取排行榜
	public static function getFishRank()
	{
		$mkey = 'i:e:fishnumrank';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($mkey);	
		if($data) {
			foreach($data as $k=>$v) {
				$data[$k]['ranking']=$k+1;
			}
		}
		return $data;	
	}
	
	//获取加速捕鱼卡数
	public static function getDopNums($uid)
	{
		$cid = 111441;
		$userCard = Hapyfish2_Island_HFC_Card::getUserCard($uid);
		if (!isset($userCard[$cid]) || $userCard[$cid]['count'] < 1) {
			$data = 0;
		}else {
			$data = $userCard[$cid]['count'];
		}
		return $data;
	}
	
	//获取疲劳时间
	public static function getTiredTime($uid)
	{
		$key = 'i:e:u:tiredtime:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);
		if ($data === false) {
			$data = 0;
			$cache->add($key, $data);
		}
		return $data;
	}
	
	//设置疲劳时间
	public static function setTiredTime($uid, $time)
	{
		$key = 'i:e:u:tiredtime:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->set($key, $time);
	}
			
	//获取最后一次捕捞时间
	public static function getLastCatchTime($uid)
	{
		$key = 'i:e:u:lastcttime:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);
		if ($data === false) {
			$data = 0;
			$cache->add($key, $data);
		}
		return $data;
	}
	//更新最后一次捕捞时间
	public static function setLastCatchTime($uid)
	{
		$time = time();
		$key = 'i:e:u:lastcttime:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->set($key, $time);
	}
				
	//初始化面板
	public static function initFish($uid)
	{
		$catchFishViewVo =array();
		
		//淘宝商品信息
		$product = self::productCache();
		if($product) {
			foreach($product as $k=>$v) {
				$catchFishViewVo[$k]['id'] = (int)$v['pid'];
				$catchFishViewVo[$k]['name'] = $v['name'];
				$catchFishViewVo[$k]['cid'] = $v['picpath'];
				//$catchFishViewVo[$k]['className'] = $v['picpath'];
				//$catchFishViewVo[$k]['shopAddress'] = $v['url'];
				$catchFishViewVo[$k]['isGem'] = (int)$v['flag'];
				$catchFishViewVo[$k]['content'] = $v['content'];
				/*
				//判断用户是否可以选择该商品，如果已领取该商品的折扣券，则无法再选择
				$catchFishViewVo[$k]['isCatch'] = self::checkUserDiscount($uid, $v['pid']);
				*/
			}
		}
		$catchFishDomainVo = array();
		$domain = self::domainCache();
		if($domain) {
			$domainVo = array();
			foreach($domain as $k=>$v) {
				$domainVo[$k]['catchFishbtnX'] = (int)$v['sitex'];
				$domainVo[$k]['catchFishbtnY'] = (int)$v['sitey'];
				$domainVo[$k]['catchFishbtnMoveX'] = (int)$v['mcx'];
				$domainVo[$k]['catchFishbtnMoveY'] = (int)$v['mcy'];
				$domainVo[$k]['id'] = (int)$v['level'];
				$domainVo[$k]['name'] = $v['class_name'];
				$domainVo[$k]['domainName'] = $v['name'];
			}
		}
		$catchFishShowFishVo = self::getFishAll();
		
		$fishNumArr = self::$_fishNumArr;
		$catchFishChargeVo = array();
		foreach($fishNumArr as $k=>$v) {
			$chargeType = 1;
			if($k>5) {
				$chargeType = 2;
			}
			$catchFishChargeVo[] = array('frequency'=>$k-1, 'chargeNum'=>$v, 'chargeType'=>$chargeType);
		}
		return array('catchFishViewVo'=>$catchFishViewVo, 'catchFishDomainVo'=>$domainVo, 'catchFishShowFishVo'=>$catchFishShowFishVo, 'catchFishChargeVo'=>$catchFishChargeVo);
	}
	public static function getFishAll()
	{
		$resultVo = array();
		$fishListAll = self::fishListAllCache();
		if($fishListAll) {
			foreach($fishListAll as $k=>$v) {
				$resultVo[$k]['name'] = $v['name'];
				$resultVo[$k]['className'] = $v['class_name'];
				$gifts = @explode("*", $v['gifts']);
				$giftType = $gifts[0];
				if($giftType == 'coin') {
					$awardType = 1;
					$resultVo[$k]['awardNum'] = $gifts[1];
					$resultVo[$k]['awardCid']='';
				}elseif($giftType == 'gold') {
					$awardType = 2;
					$resultVo[$k]['awardNum'] = $gifts[1];
					$resultVo[$k]['awardCid']='';					
				}elseif($giftType == 'cid') {
					$cid = substr($gifts[1], -2);
					if($cid == '31' || $cid == '32') {
						$awardType = 3;
						$resultVo[$k]['awardNum'] = $gifts[2];
						$resultVo[$k]['awardCid'] = $gifts[1];					
					}elseif($cid == '41') {
						$awardType = 4;
						$resultVo[$k]['awardNum'] = $gifts[2];
						$resultVo[$k]['awardCid'] = $gifts[1];						
					}
				}
				$resultVo[$k]['awardType'] = $awardType;
				$resultVo[$k]['difficulty'] = $v['difficulty'];
			}
		}
		return $resultVo;
	}
	public static function fishUser($uid)
	{
		$catchFishVo=array();
		$now = time();
		$coinChange = 0;
		$goldChange = 0;
		/*
		//初始化疲劳时间
		$oldTiredTime = self::getTiredTime($uid);
		$lastCacheTime = self::getLastCatchTime($uid);
		$timeDiff = $now - $lastCacheTime;

		if(($oldTiredTime-$timeDiff) <= 0) {
			$tiredTime = 0;
		}else {
			$tiredTime = $oldTiredTime-$timeDiff;
		}		
		
		$catchFishVo['fatigueTime'] = $tiredTime;
		*/
		//非首次捕鱼-获取用户的捕鱼信息
		$fishUser = self::initFishUserCache($uid);
		//print_r($fishUser);
		$catchFishVo['id'] = $fishUser['level'];
		/*
		$catchFishVo['maxVoyage'] = $fishUser['route'];
		
		$dopNums = self::getDopNums($uid);
		$catchFishVo['cordialNum'] = $dopNums;
		*/
		$startplay = self::getFishUserStartPlay($uid);
		$catchFishVo['startplay'] = $startplay;
		$catchFishVo['fishnum'] = $fishUser['dayFishNum'];
		if($fishUser['time'] != date('Ymd',$now)) {
			$catchFishVo['fishnum']	= 0;
		}
		$catchFishVo['maxFishNum']	= $fishUser['weekFishNum'];
		
		$catchFishVo['isHideHelpView'] = self::getHelpFlag($uid);
		return array('catchFishVo'=>$catchFishVo);
	}
	
	//捕鱼动作
	public static function catchFish($uid, $productid, $helpFlag)
	{
		$fishNumArr = self::$_fishNumArr;
		$catchFishVo = array();
		$resultVo = array();
		$result = array('status'=>1, 'coinChange'=>0, 'goldChange'=>0);
		$now = time();
		$coinChange = 0;
		$sendFlag = 0;		
		//加速捕鱼卡数目
		$dopNums = self::getDopNums($uid);

		//用户金币数,宝石数
		$userCoin = Hapyfish2_Island_HFC_User::getUserCoin($uid);
		//$userGold = Hapyfish2_Island_HFC_User::getUserGold($uid);
		
		//当前航路位置
		$level = 1;
		$fishUser = self::initFishUserCache($uid);
		//周捕鱼次数
		$weekFishNum = $fishUser['weekFishNum']+1;
		//当天捕鱼次数
		if($fishUser['time'] != date('Ymd',$now)) {
			$dayFishNum = 1;
		}else {
			$dayFishNum = $fishUser['dayFishNum']+1;
		}
		
		if($dayFishNum <= 6) {
			$fishNum = $dayFishNum;
		}else {
			$fishNum = 6;
		}
		
		//判断是否可以捕鱼
		if($dayFishNum >= 3 && $dayFishNum <= 5) {
			if($userCoin < $fishNumArr[$fishNum]) {
				$result['status'] = -1;
				return array('result'=>$result);
			}
		}elseif($dayFishNum > 5) {
			if( $dopNums < $fishNumArr[$fishNum]) {
				$result['status'] = -1;
				return array('result'=>$result);
			}			
		}
		
		$level = $fishUser['level'];
		
		//判断是否随机到获取折扣券
		$isTaobao = 0;
		//淘宝专有，随机获取淘宝折扣券
		$isTaobaoInfo = self::checkIsTaoBao($productid, $level);
		if($isTaobaoInfo['status'] == 1) {
			$isTaobao = 1;
		}else {
			$isTaobao = 0;
		}
		/*
		if($isTaobao == 1) {
			$flag = self::checkUserDiscount($uid, $productid);	
			if($flag==1) {
				$isTaobao = 0;
			}	
		}	
		*/
		if($isTaobao == 1) {
			$discountInfo = self::getTaobaoDiscount($level,$isTaobaoInfo['productid']);
			if($discountInfo['isTaoBao'] == 0) {
				$isTaobao = 0;	//随机不到折扣券
			}else {
				//给用户添加折扣券
				/*
				$discountNumber = self::addTaoBaoDiscount($uid, $discountInfo['productid'], $discountInfo['discount'], $level);
				$resultVo['discountNumber'] = $discountNumber;
				*/
				//添加用户建筑折扣缓存
				$info = array(
					'cid' => $isTaobaoInfo['cid'],
					'discount' => $discountInfo['discount'],
					'pid' => $isTaobaoInfo['productid']
				);
				self::setUserPlantDiscount($uid, $info);	
				$resultVo['discountNumber'] = $isTaobaoInfo['cid'];
				$resultVo['discountNumberNum'] = $discountInfo['discount'];
				$resultVo['name'] = '折扣魚';
				$resultVo['className'] = 'CatchFish_zhekouyu';
			}
		}
		if($isTaobao == 0) {
			//按几率随机获取捕到鱼的信息
			$fishList = self::fishListCache($level);
			$randArr = array();
			$id = 1;
			$allnum=0;
			$a=1;
			if($fishList) {
				for($i=0;$i<count($fishList);$i++) {
					$allnum+=$fishList[$i]['probability'];
					$randArr[$fishList[$i]['id']] = array($a,$a+$fishList[$i]['probability']-1);
					$a+=$fishList[$i]['probability'];
				}
				$num = rand(1,$allnum);
				foreach($randArr as $k=>$v) {
					if($num>=$v[0] && $num<=$v[1]) {
						$id = $k;
						break;
					}
				}
			}
			$fishInfo = self::fishInfoCache($id);
			$resultVo['name'] = $fishInfo['name'];
			$resultVo['className'] = $fishInfo['class_name'];
			$resultVo['merryChristmas'] = 0;
			if($fishInfo['class_name'] == 'CatchFish_shengdanyuhong' || $fishInfo['class_name'] == 'CatchFish_shengdanyulv') {
				$resultVo['merryChristmas'] = 1;
			}
			//重组鱼奖品信息
	    	$gifts = $fishInfo['gifts'];
	    	$fishData = array();
	    	$fishInfo['awards'] = array();
	    	if($gifts) {
		    	$giftsArr = explode(",",$gifts);
		    	for($i=0;$i<count($giftsArr);$i++) {
		    		$tmp = array();
		    		$tmp = explode("*",$giftsArr[$i]);
		    		if($tmp[0] == 'coin') {
		    			$fishData['coin'] = (int)$tmp[1];
		    		}elseif($tmp[0] == 'cid') {
		    			$fishData['cid'] = array((int)$tmp[1],(int)$tmp[2]);
		    		}elseif($tmp[0] == 'gold') {
		    			$fishData['gold'] = (int)$tmp[1];
		    		}
		    	}
		    	$fishInfo['awards'] = $fishData;
	    	}
		}
		
		try {
		
		//扣除金币或捕鱼加速卡	
		if($dayFishNum >= 3 && $dayFishNum <= 5) {
			$coinChange = $fishNumArr[$fishNum];
			Hapyfish2_Island_HFC_User::decUserCoin($uid, $fishNumArr[$fishNum], 1);
		}elseif($dayFishNum > 5) {		
			Hapyfish2_Island_HFC_Card::useUserCard($uid, 111441, $fishNumArr[$fishNum]);

		}
		//按几率随机判断是否可以进入下一个航路,更新行驶航线路程，更新缓存，更新数据库
		$levelArr = array(
						1	=>	5,
						2	=>	4,
						3	=>	3,
						4	=>	2
		);
		$routeArr = array(
						1	=>	array(1,40000),
						2	=>	array(40001,200000),
						3	=>	array(200001,300000),
						4	=>	array(300001,350000),
						5	=>	array(350001,400000)
		);
		$routeNew = 1;
		$route = rand($routeArr[$level][0],$routeArr[$level][1]);
		$route = round($route/100,2);
		if($fishUser['route'] >= $route) {
			$route = $fishUser['route'];
			$routeNew = 0;
		}
		$nextLevel = $level;
		if(rand(1,10) <= $levelArr[$level]) {
			$nextLevel = $level+1;
			$catchFishVo['isSucceed'] = 1;
		}else {
			$nextLevel = 1;
			$catchFishVo['isSucceed'] = 0;
		}
		$catchFishVo['id'] = $nextLevel;
		self::setFishUserCache($uid, $route, $nextLevel, $dayFishNum, $weekFishNum);
		
		//更新排行数据
		self::inFishRank($uid, $weekFishNum);
		$itemName = '';
		$bllCompensation = new Hapyfish2_Island_Bll_Compensation();
		if($isTaobao == 0) {
			//给用户添加鱼掉落的物品
			if( isset($fishInfo['awards']['coin']) && $fishInfo['awards']['coin'] >0 ) {
				$coin = (int)$fishInfo['awards']['coin'];
				$result['coinChange'] = $coin;
				$bllCompensation->setCoin($coin);
				$sendFlag = 1;
				$itemName=$coin.'金幣';
			}
			if( isset($fishInfo['awards']['cid']) && $fishInfo['awards']['cid'] >0 ) {
				$awardCid = $fishInfo['awards']['cid'][0];
				$awardNum = $fishInfo['awards']['cid'][1];
				$resultVo['awards'] = array((int)$awardCid, (int)$awardNum);
				$bllCompensation->setItem($awardCid, $awardNum);	
				$sendFlag = 1;
				if(substr($awardCid, -2, 2)=='21') {
					$buildingInfo = Hapyfish2_Island_Cache_BasicInfo::getBuildingInfo($awardCid);
					$itemName = $buildingInfo['name'];					
					self::setRank($uid, $itemName);
				}elseif(substr($awardCid, -2, 2)=='41') {
					$cardInfo = Hapyfish2_Island_Cache_BasicInfo::getCardInfo($awardCid);
					$itemName = $cardInfo['name'];
				}elseif(substr($awardCid, -2, 2)=='32' || substr($awardCid, -2, 2)=='31') {
					$plantInfo = Hapyfish2_Island_Cache_BasicInfo::getPlantInfo($awardCid);
					$itemName = $plantInfo['name'];
				}
			}
			if( isset($fishInfo['awards']['gold']) && $fishInfo['awards']['gold'] > 0 ) {
				$goldNum = (int)$fishInfo['awards']['gold'];
				$bllCompensation->setGold($goldNum);	
				$result['goldChange'] = $goldNum;
				$sendFlag = 1;
				$itemName = $goldNum.'寶石';
			}					
			if($sendFlag == 1) {
				$bllCompensation->sendOne($uid, '捕魚獲得獎勵:');
			}
		}
		$logger = Hapyfish2_Util_Log::getInstance();
		
		//update by hdf add send gold log start
		if(isset($goldNum) && $goldNum > 0) {	
			$logger->report('801', array($uid, $goldNum, 12));						
		}
		//end
						
		if($isTaobao == 0) {
			//report log
			//$logger = Hapyfish2_Util_Log::getInstance();
			$logger->report('601', array($uid, $fishInfo['id'], $level));
		}else {
			//$logger = Hapyfish2_Util_Log::getInstance();
			$logger->report('602', array($uid, $discountInfo['productid'], $discountInfo['discount'], $level));	
			$productInfo = self::getProductById($discountInfo['productid']);
			if($discountInfo['discount']<=1) {	
				self::setRank($uid, $productInfo['name'].$discountInfo['discount'].'折');
			}
			$itemName = $productInfo['name'].$discountInfo['discount'].'折';
			/*
			//发送Feed
			$feed = '恭喜你获得'.$productInfo['name'].'，请在活动面板“查看折扣码”中使用';
        	$minifeed = array(
							'uid' => $uid,
							'template_id' => 0,
							'actor' => $uid,
							'target' => $uid,
							'title' => array('title' => $feed),
							'type' => 3,
							'create_time' => time()
						);
			Hapyfish2_Island_Bll_Feed::insertMiniFeed($minifeed);	
			*/					
			
		}
		//捕鱼消耗金币或宝石发Feed
		if($dayFishNum >= 3) {
			if($dayFishNum >= 3 && $dayFishNum <=5) {
				$feedTitle = $fishNumArr[$fishNum].'金幣';
			}elseif($dayFishNum > 5) {
				$feedTitle = $fishNumArr[$fishNum].'張加速捕魚卡   ';
			}
			$feed = '捕魚消耗 ' . $feedTitle;
	        $minifeed = array(
							'uid' => $uid,
							'template_id' => 0,
							'actor' => $uid,
							'target' => $uid,
							'title' => array('title' => $feed),
							'type' => 4,
							'create_time' => time()
						);
			Hapyfish2_Island_Bll_Feed::insertMiniFeed($minifeed);			
		}
		if($itemName != '') {
			self::setGiftRank($uid, $itemName);
		}
		//统计玩家人数
		$logger->report('603', array($uid));
		
		//统计消耗金币或捕鱼卡记录
		if($dayFishNum >= 3 && $dayFishNum <=5) {
			$logger->report('604', array($uid, $coinChange, 1));
		}elseif($dayFishNum > 5){
			$logger->report('604', array($uid, $fishNumArr[$fishNum], 2));
		}
		
		/*
		$catchFishVo['isDiscountNumber'] = $isTaobao;
		
		$startplay = self::getFishUserStartPlay($uid);
		$catchFishVo['startplay'] = $startplay;
		*/
		$catchFishVo['fishnum'] = $dayFishNum;
		
		
		self::setHelpFlag($uid, $helpFlag);
		$catchFishVo['isHideHelpView'] = $helpFlag;
		
		$result['coinChange']=$result['coinChange']-$coinChange;
		
		$catchFishVo['maxFishNum']	= $weekFishNum;
		return array('catchFishVo'=>$catchFishVo,'catchFishAchievementVo'=>$resultVo, 'result'=>$result);
		
		} catch (Exception $e) {
			info_log($e->getMessage(), 'Event_catchFish_Err');
		}
	}
	
	//获取捕鱼行里数榜、奖品排行榜
	public static function catchFishRank()
	{
		$rankList = self::getFishRank();
		$rankList2 = self::getGiftRank();
		return array('catchFishChartsVoyageVo'=>$rankList, 'catchFishChartsCatchVo'=>$rankList2);
	}
	//动态排行
	public static function catchFishRollRank()
	{
		$rankList = self::getRank();
		return array('catchFishChartTrendsRollVo'=>$rankList);
	}	
	public static function showTiredDop($uid)
	{
		$result = array();
		$result['status'] = 1;
		$now = time();
		$dopNum = self::getDopNums($uid);
		$oldTiredTime = self::getTiredTime($uid);
		$lastCacheTime = self::getLastCatchTime($uid);
		$timeDiff = $now - $lastCacheTime;
		if(($oldTiredTime-$timeDiff) <= 0) {
			$tiredTime = 0;
		}else {
			$tiredTime = $oldTiredTime-$timeDiff;
		}
		$result['fatigueTime'] = $tiredTime;
		$result['cordialNum'] = $dopNum;
		return array('result'=>$result);
	}
	//捕鱼加速卡减少疲劳时间
	public static function rdTiredDop($uid, $num)
	{
		$resultVo = array();
		$result['status'] = 1;
		$dopNum = self::getDopNums($uid);
		if($dopNum < $num) {
			$result['status'] = -1;
			return array('result'=>$result);
		}
		if($num == 1) {
			$tiredTime = self::getTiredTime($uid);
			$newTiredTime = $tiredTime-600;
			if($newTiredTime <= 0) {
				$newTiredTime = 0;
			}
		}else {
			$newTiredTime = 0;
		}
		self::setTiredTime($uid, $newTiredTime);
		$cid = 111441;
		Hapyfish2_Island_HFC_Card::useUserCard($uid, $cid, $num);
		
		$resultVo = self::fishUser($uid);
		return array('result'=>$result, 'catchFishVo'=>$resultVo['catchFishVo']);
	}
	
	
	//随机获取商品折扣数
	public static function getTaobaoDiscount($level, $productid)
	{
		$discountInfo = array();
		$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
		$discountInfo['isTaoBao'] = 1;
		//随机获取各个折扣的折扣券
		$tmp = self::getProductProbability($level, $productid);
		if(!$tmp) {
			$discountInfo['isTaoBao'] = 0;
		}else {
			$allnum=0;
			$a=1;
			for($i=0;$i<count($tmp);$i++) {
				$tmp[$i]['probability'] = intval($tmp[$i]['probability']);
				$allnum+=$tmp[$i]['probability'];
				$randArr[$tmp[$i]['discount']] = array($a,$a+$tmp[$i]['probability']-1);
				$numArr[$tmp[$i]['discount']] = intval($tmp[$i]['num']);
				$tmpArr[$tmp[$i]['discount']] =	array($tmp[$i]['id'], $tmp[$i]['urla'], $tmp[$i]['urlb']); 
				$a+=$tmp[$i]['probability'];
			}
			$num = rand(1,$allnum);
			$discountFlag = 0;
			foreach($randArr as $k=>$v) {
				if($num>=$v[0] && $num<=$v[1] && $v[1]>0) {
					if($numArr[$k] > 0) {
						$discount = $k;
						$discountInfo['discount'] = $discount;
						$discountInfo['id'] = $tmpArr[$k][0];
						$discountInfo['urla'] = $tmpArr[$k][1];
						$discountInfo['urlb'] = $tmpArr[$k][2];
						$discountFlag = 1;				
						break;
					}
				}
			}
			if($discountFlag==0) {
				$discount = rand(6,8);
				if($numArr[$discount]<=0) {
					$discountInfo['isTaoBao'] = 0;
				}else {
					$discountInfo['discount'] = $discount;
					$discountInfo['id'] = $tmpArr[$discount][0];
					$discountInfo['urla'] = $tmpArr[$discount][1];
					$discountInfo['urlb'] = $tmpArr[$discount][2];							
				}				
			}
			$discountInfo['productid'] = $productid;						
		}
		return $discountInfo;
	}
	
	/*
	 * $level	航路位置ID
	 * 通过概率来判断是否进入随机淘宝商品折扣券
	 * */
	public static function checkIsTaoBao($productid, $level) 
	{
		$result = array('status'=>0);
		$randNum = rand(1,100);
		if(!$productid) {
			return $result;
		}
		$productInfo = self::getProductById($productid);
		$probability = $productInfo['probability'];
		
		if($probability) {
			$probability = str_replace("，",",",$probability);
			$probabilityArr = explode(",",$probability);
			$proby = 0;
			foreach($probabilityArr as $k=>$v) {
				$tmpArr = array();
				$tmpArr = explode("*",$v);
				if($level == $tmpArr[0]) {
					$proby = $tmpArr[1];
				}				
			}
			//随机是否几率选商品折扣券
			if($proby && $randNum<=$proby) {
				$result = array('status'=>1, 'productid'=>$productid, 'cid'=>$productInfo['picpath']);
			}
		}
		return $result;	
	}
	/*
	 * 面板显示商品信息
	 * */
	public static function productCache()
	{
		$date = date('Ymd');
		$key = 'i:e:tb:pd';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($key);

		if($data && $data[0]['date']!=$date) {
			try {
	        	$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
				$data = $dalFish->getProduct();		
	            $cache->set($key, $data);
			} catch (Exception $e) {
				return array();
			}
		}else if (!$data) {
			try {
	        	$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
				$data = $dalFish->getProduct();		
	            $cache->add($key, $data);
			} catch (Exception $e) {
				return array();
			}			
		}
		return $data;		
	}

	public static function getProductProbability($level, $productid) 
	{
		$key = 'i:e:tb:pd:prob:l:pid:' . $level . ':' . $productid;
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($key);
		if ($data === false) {
			try {
	        	$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
				$data = $dalFish->getProductProbability($level, $productid);		
	            $cache->add($key, $data);
			} catch (Exception $e) {
				return array();
			}			
		}
		return $data;		
	}
	public static function clearProductProbability($productid, $discount) 
	{
		$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();

		$dalFish->updateDiscountNum($productid, $discount);
		for($i=1;$i<=5;$i++) {
			$data = array();
			$key = 'i:e:tb:pd:prob:l:pid:' . $i . ':' . $productid;
			$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');	
			$data = $cache->get($key);
			if($data) {
				foreach($data as $k=>$v) {
					if($v['discount'] == $discount) {
						$data[$k]['num'] = $v['num']-1;
					}
				}
				$cache->set($key, $data);	
			}
		}		
		
	}
	//给用户添加淘宝折扣券
	public static function addTaoBaoDiscount($uid, $productid, $discount, $level)
	{
		$time = time();
		$randNum = rand(1,100);
		$uidLen = strlen($uid);
		$lastLen=15-$uidLen;
		$number = $uid.'t'.substr(md5($uid.$productid.$discount.$time.$randNum), 0, $lastLen);
		try {
	        $dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
			$ok = $dalFish->addTaoBaoDiscount($uid, $number, $productid, $discount, $level);
			//更新用户已有折扣券缓存
			self::updateUserDiscountCache($uid);
			//扣除折扣券数量并更新缓存
			self::clearProductProbability($productid, $discount);
			return $number;
		} catch (Exception $e) {
			return 0;
		}	
	}

	public static function getUserDiscount($uid)
	{
		$resultVo = array();
		$data = self::getUserDiscountCache($uid);
		if($data) {
			$allTime = 24*3600;
			foreach($data as $k=>$v) {
				$resultVo[$k]['time'] = $v['gettime'];
				$resultVo[$k]['discountNumberNum'] = $v['discount'];
				$resultVo[$k]['awardShopItemName'] = $v['name'];
				$resultVo[$k]['state'] = $v['status'];
				$resultVo[$k]['discountNumber'] = $v['number'];
				$resultVo[$k]['shopAddress'] = trim($v['urla'])?trim($v['urla']):trim($v['urlb']);
				$timeDiff = $allTime - (time()-$v['gettime']);
				$resultVo[$k]['effectiveTime'] = $timeDiff<=0?0:$timeDiff;
				if($timeDiff<=0) {
					$resultVo[$k]['state'] = 3;
				}
			}
		}
		return array('catchFishDiscountNumberVo'=>$resultVo);
	}
	public static function getUserDiscountCache($uid)
	{					
		$key = 'i:e:u:disinfo:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);
		if ($data === false) {
			try {
	        	$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
				$data = $dalFish->getUserDiscount($uid);		
				if (!$data) {
					$data = array();
				}else {
	                $cache->add($key, $data);
	            }
			} catch (Exception $e) {
				return array();
			}
		}
		return $data;		
	}
	public static function updateUserDiscountCache($uid)
	{					
		$key = 'i:e:u:disinfo:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);

	    $dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
		$data = $dalFish->getUserDiscount($uid);
		$cache->set($key, $data);
		return $data;		
	}	
	//判断用户当天是否已经抽中该商品的折扣券
	public static function checkUserDiscount($uid, $productid)
	{
		$flag = 0;
		$key = 'i:e:u:disinfo:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);	
		if(!$data) {
			return $flag;
		}	

		$now = date('Ymd');
		foreach($data as $k=>$v) {
			$getTime = date('Ymd',$v['gettime']);
			if($v['pid']==$productid && $v['status']!=0 && $getTime==$now) {
				$flag = 1;
			}
		}
		return $flag;	
	} 
	
	/**
	 * 生成滚动捕获榜
	 */
	public static function setRank($uid, $con)
	{
		$mkey = 'i:e:fh:ranktb';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($mkey);
		$now = time();
		$info = array();
		$info['uid'] = $uid;
		$info['time'] = $now;
		$info['itemName'] = $con;		
		$userinfo = Hapyfish2_Island_Bll_User::getUserInit($uid);
		$info['name'] = $userinfo['name'];
		$data[] = $info;
		
		foreach ($data as $key => $row) {
			$voyage[$key]  = $row['time'];
		}
		array_multisort($voyage, SORT_DESC, $data);
		if(count($data)>100) {
			array_pop($data);
		}
		$cache->set($mkey, $data);
				
		return $data;	
	}
	public static function getRank()
	{
		$output = array();
		$newData = array();
		$now = date('Ymd',time());
		$mkey = 'i:e:fh:ranktb';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($mkey);
		if($data) {
			foreach($data as $k=>$v) {
				if(date('Ymd',$v['time']) != $now) {
					continue;
				}
				$newData[]=$v;
			}
			shuffle($newData);
			$output = array_slice($newData, 0, 30);
		}
		return $output;		
	}
	public static function setGiftRank($uid, $itemName)
	{
		$key = 'i:e:fh:rankgift';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($key);
		$now = time();
		$info = array();
		$info['uid'] = $uid;
		$info['time'] = $now;
		$info['catchItemName'] = $itemName;
		$userinfo = Hapyfish2_Island_Bll_User::getUserInit($uid);
		$info['name'] = $userinfo['name'];
		$data[] = $info;
		foreach ($data as $k => $row) {
			$voyage[$k]  = $row['time'];
		}
		array_multisort($voyage, SORT_DESC, $data);
		if(count($data)>100) {
			array_pop($data);
		}
		$cache->set($key, $data);				
		return $data;		
	}
	public static function getGiftRank()
	{
		$key = 'i:e:fh:rankgift';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($key);
		return $data;		
	}	
	public static function cancelTaoBaoDiscount($uid, $pid, $number)
	{
		$result = array();
		$result['status']=-1;
		$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
		$data = $dalFish->cancelTaoBaoDiscount($uid, $pid, $number);
		if($data) {
			self::updateUserDiscountCache($uid);	
			$result['status']=1;
		}
		return array('result'=>$result);
	}
	public static function getProductById($pid)
	{
		$key = 'i:e:u:fishpinfo' .$pid;
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($key);
		if($data===false) {
			$dalFish = Hapyfish2_Island_Event_Dal_CatchFish::getDefaultInstance();
			$data =$dalFish->getProductById($pid);
			$cache->add($key, $data);
		}	
		return $data;	
	}

	public static function buyPlant($uid, $cid)
	{
		$result = array('status'=>1);
		$discount = 1;
		if(!$cid) {	//折扣购买
			$info = self::getUserPlantDiscount($uid);

			if($info) {
				$itemId = $info['cid'];
				$discount = $info['discount']/10;
				$productid = $info['pid'];
			}else {
				$result = array('status'=>-1);
				return array('result'=>$result);
			}
		}else {		//原价购买
			$itemId = $cid;
		}
		$plantInfo = self::getPlantInfo($itemId);
		if(!$plantInfo) {
			$result = array('status'=>-1);
			return array('result'=>$result);
		}else {
			$price = $plantInfo['price'];	
			$needPrice = (int)($price * $discount);
			if($plantInfo['price_type'] == 1) {	//金币购买
				$userCoin = Hapyfish2_Island_HFC_User::getUserCoin($uid);
				if($userCoin < $needPrice) {
					$result = array('status'=>-1);
					return array('result'=>$result);
				}else {
					Hapyfish2_Island_HFC_User::decUserCoin($uid, $needPrice, 1);
					$bllCompensation = new Hapyfish2_Island_Bll_Compensation();
					$bllCompensation->setItem($itemId, 1);
					$bllCompensation->sendOne($uid, '購買了:');
					$result['coinChange'] = -(int)$needPrice;
				}
			}else {
				$userGold = Hapyfish2_Island_HFC_User::getUserGold($uid);
				if($userGold < $needPrice) {
					$result = array('status'=>-1);
					return array('result'=>$result);					
				}else {
		        	$goldInfo = array(
		        		'uid' => $uid,
		        		'cost' => $needPrice,
		        		'summary' => '捕魚購買' . $plantInfo['name'],
		        		'cid' => $itemId,
		        		'num' => 1
		        	);
		        	$ok = Hapyfish2_Island_Bll_Gold::consume($uid, $goldInfo);
		        	if($ok) {
		        		$bllCompensation = new Hapyfish2_Island_Bll_Compensation();
		        		$bllCompensation->setItem($itemId, 1);
		        		$bllCompensation->sendOne($uid, '購買了:');
		        		$result['goldChange'] = -(int)$needPrice;
		        	}				
				}
			}	
			if($discount != '1') {
				self::clearProductProbability($productid, $info['discount']);
			}
			//report log
			$logger = Hapyfish2_Util_Log::getInstance();
			$logger->report('605', array($uid, $itemId, $discount));
			
			self::clearUserPlantDiscount($uid);
			
			return array('result'=>$result);
		}
	}
	public static function getPlantInfo($cid)
	{
		if(substr($cid, -2, 2)=='21') {
			$data = Hapyfish2_Island_Cache_BasicInfo::getBuildingInfo($cid);				
		}elseif(substr($cid, -2, 2)=='41') {
			$data = Hapyfish2_Island_Cache_BasicInfo::getCardInfo($cid);
		}elseif(substr($cid, -2, 2)=='32' || substr($cid, -2, 2)=='31') {
			$data = Hapyfish2_Island_Cache_BasicInfo::getPlantInfo($cid);
		}
		return $data;		
	}
}