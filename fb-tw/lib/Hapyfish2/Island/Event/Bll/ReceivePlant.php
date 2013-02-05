<?php

/**
 * Event ReceivePlant
 *
 * @package    Island/Event/Bll
 * @copyright  Copyright (c) 2012 Happyfish Inc.
 * @create     2012/01/11    zhangli
*/
class Hapyfish2_Island_Event_Bll_ReceivePlant
{
	const TXT001 = '不能重复领取';
	const TXT002 = '星级不够，不能领取';
	const TXT003 = '恭喜你获得：';
	const TXT004 = '所需建筑不足,不能领取';
	const TXT005 = '升級所需人數不足，升級失敗';
	
	/**
	 * @兑换初始化
	 * @param int $uid
	 * @return Array
	 */
	public static function ReceivePlantInit($uid)
	{
		//获取图鉴数据
		$atlasBookDataVo = Hapyfish2_Island_Event_Bll_AtlasBook::atlasBookInit($uid);
		
		$index = 1;
		
		//自己的星级
		$userStar = 0;
		foreach ($atlasBookDataVo['medalList'] as $key => $values) {
			if ($key == $index) {
				$userStar = $values['currentStar'];
			}
		}
		
		//建筑领取状态
		$exchangeAble = Hapyfish2_Island_Event_Cache_ReceivePlant::getExchangeAble($uid);
		
		$resultVo = array('magicAcademyVo' => array('num' => $userStar, 'lock' => (int)$exchangeAble));
		return $resultVo;
	}
	
	/**
	 * @兑换建筑
	 * @param int $uid
	 * @param int $index
	 * @return Array
	 */
	public static function toReceivePlant($uid)
	{
		$result = array('status' => 1);
		
		//建筑领取状态
		$exchangeAble = Hapyfish2_Island_Event_Cache_ReceivePlant::getExchangeAble($uid);
		
		//不能重复领取
		if ($exchangeAble == 1) {
			$result['content'] = self::TXT001;
			$resultVo = array('result' => $result);
			
			return $resultVo;
		}
		
		//获取图鉴数据
		$atlasBookDataVo = Hapyfish2_Island_Event_Bll_AtlasBook::atlasBookInit($uid);
		
		$id = 1;
		
		//自己的星级
		$userStar = 0;
		foreach ($atlasBookDataVo['medalList'] as $key => $values) {
			if ($key == $id) {
				$userStar = $values['currentStar'];
			}
		}
		
		//需要星级
		$needStar = 45;
		
		//星级不够
		if ($userStar < $needStar) {
			$result['content'] = self::TXT002;
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
				
		//奖励建筑cid
		$cid = 173632;
		
		//发放奖励
		$compensation = new Hapyfish2_Island_Bll_Compensation();
	
		$compensation->setItem($cid, 1);
		$ok = $compensation->sendOne($uid, self::TXT003);
		
		if ($ok) {
			//统计兑换人数
			info_log($uid, 'receivePlant_' . $cid);
			
			//更新领取状态
			Hapyfish2_Island_Event_Cache_ReceivePlant::renewExchangeAble($uid);
		}
		
		$result['status'] = 1;
		$result['itemBoxChange'] = true;
		$resultVo = array('result' => $result);
		
		return $resultVo;
	}
	
	/**
	 * 
	 * get Altar has num
	 * @param int $uid
	 * 
	 * @return array
	 */
	public static function getAltarInfo($uid)
	{
        //获得当前拥有的人数
        $hasAltarNum = self::getAltarNum();
        
        return array('peopleNum' => (int)$hasAltarNum);
        
	}
	
	/**
	 * 
	 * upgrade Altar
	 * @param int $uid
	 * @param int $itemId
	 * 
	 * @return array
	 */
	public static function upgradeAltar($uid, $itemId)
	{
		$result = array('status' => -1);

        $itemType = substr($itemId, -2, 1);
        $itemId = substr($itemId, 0, -2);
        if ($itemType != 3) {
            $result['content'] = 'serverWord_115';
            $resultVo = array('result' => $result);
            
            return $resultVo;
        }
    
		$userVO = Hapyfish2_Island_HFC_User::getUserVO($uid);
        $ownerCurrentIsland = $userVO['current_island'];
        $userPlant = Hapyfish2_Island_HFC_Plant::getOne($uid, $itemId, 1, $ownerCurrentIsland);
        if (!$userPlant) {
            $result['content'] = 'serverWord_115';
            $resultVo = array('result' => $result);
            return $resultVo;
        }

        //如果不是水晶祭坛不能用此接口升级
		if (!in_array($userPlant['cid'], array(178032, 178132, 178232, 178332)))  {
			$result['content'] = 'serverWord_101';
            $resultVo = array('result' => $result);
            return $resultVo;
        }
        
        $plantInfo = Hapyfish2_Island_Cache_BasicInfo::getPlantInfo($userPlant['cid']);
        if (!$plantInfo || !$plantInfo['next_level_cid']) {
        	return array('result' => $result);
        }
        
        $nextLevelPlantInfo = Hapyfish2_Island_Cache_BasicInfo::getPlantInfo($plantInfo['next_level_cid']);
        if (!$nextLevelPlantInfo) {
        	return array('result' => $result);
        }

        $praiseChange = $nextLevelPlantInfo['add_praise'] - $plantInfo['add_praise'];
        
        $userInfo = Hapyfish2_Island_HFC_User::getUser($uid, array('coin' => 1, 'level' => 1));
        if ($userInfo === null) {
        	return array('result' => $result);
        }
        
        //获得当前购买人数和升级需要数据
        $hasAltarNum = self::getAltarNum();
        
        //判断升级人数是否足够
        switch ($userPlant['cid']) {
        	case 178032:
        		$upNeeds = 2000;
        	break;
        	case 178132:
        		$upNeeds = 4000;
        	break;
        	case 178232:
        		$upNeeds = 6000;
        	break;
        	case 178332:
				$upNeeds = 8000;
        	break;
        }
        
        //人数不足
		if ($hasAltarNum < $upNeeds) {
			$result['content'] = self::TXT005;
			$resultVo = array('result' => $result);
			return $resultVo;
		}
        
        $userIslandInfo = Hapyfish2_Island_HFC_User::getUserIsland($uid);
    
        $now = time();
        
        $addExp = 5;
		
		$userPlant['level'] += 1;
		$userPlant['cid'] = $nextLevelPlantInfo['cid'];
		$userPlant['pay_time'] = $nextLevelPlantInfo['pay_time'];
		$userPlant['ticket'] = $nextLevelPlantInfo['ticket'];
		
		$res = Hapyfish2_Island_HFC_Plant::updateOne($uid, $itemId, $userPlant, true);
		
		$aryParam = array();
		$aryParam['name'] = $plantInfo['name'];
		$aryParam['num'] = $userPlant['level'];
		//add log
		foreach ($aryParam as $k => $v) {
            $parakeys[] = '{*' . $k . '*}';
            $paravalues[] = $v;
        }
		if ($res) {
			Hapyfish2_Island_Cache_Plant::reloadAllByItemKind($uid);
			$userIslandInfo['praise'] += $praiseChange;
			Hapyfish2_Island_HFC_User::updateUserIsland($uid, $userIslandInfo);
			
			//check double exp
			$userCardStatus = Hapyfish2_Island_HFC_User::getCardStatus($uid);
			$doubleexpCardTime = $userCardStatus['doubleexp'];
			if ($doubleexpCardTime - $now > 0) {
				$addExp = $addExp * 2;
				$result['expDouble'] = 2;
			}
			Hapyfish2_Island_HFC_User::incUserExp($uid, $addExp);

			$result['status'] = 1;
			$result['expChange'] = $addExp;
			$result['praiseChange'] = $praiseChange;
		}

    	try {
			//check user level up
        	$levelUp = Hapyfish2_Island_Bll_User::checkLevelUp($uid);
            $result['levelUp'] = $levelUp['levelUp'];
            $result['islandLevelUp'] = $levelUp['islandLevelUp'];
			if ($levelUp['feed']) {
            	$result['feed'] = $levelUp['feed'];
            } 
		} catch (Exception $e) {
		}
        
        $buildingVo = Hapyfish2_Island_Bll_Plant::handlerPlant($userPlant, $now);
        
        $resultVo = array('result' => $result, 'buildingVo' => $buildingVo);

        return $resultVo;
	}
	
	/**
	 * 
	 * get has Altar num
	 * @return int
	 */
	public static function getAltarNum()
	{
		$key = 'ev:Altar:num';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$data = $cache->get($key);
		
		return $data;
	}
	
}