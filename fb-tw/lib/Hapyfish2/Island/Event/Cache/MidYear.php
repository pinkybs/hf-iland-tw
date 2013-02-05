<?php

/**
 * Event MidYear
 *
 * @package    Island/Event/Bll
 * @copyright  Copyright (c) 2011 Happyfish Inc.
 * @create     2011/12/23    zhangli
*/
class Hapyfish2_Island_Event_Cache_MidYear
{
	/**
	 * @获取锤子砸中物品概率
	 * @param int $eid
	 * @return Array
	 */
	public static function getEggData($eid)
	{
		//0->复,1->活,2->节,3->疯,4->狂,5->砸,6->彩,7->蛋,
		//8->船只加速卡I,9->双倍经验卡,10->船只加速卡II,11->宝箱钥匙,12->大鱼炮,13->一键收钱卡,14->3星建设卡,15->船只加速卡III
		$key = 'ev:midyear:items';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$list = $cache->get($key);

		if ($list === false) {
			try {
				$db = Hapyfish2_Island_Event_Dal_MidYear::getDefaultInstance();
				$list = $db->getListArr();
			} catch (Exception $e) {}

			if ($list) {
				$cache->set($key, $list, 3600 * 24 * 15);
			}
		}

		foreach ($list as $ls) {
			if ($ls['eid'] == $eid) {
				$dataCo = $ls;
				break;
			}
		}
		
		return $dataCo;
	}
	
	/**
	 * @根据ID获取物品CID
	 * @param int $gainID
	 * @return Array
	 */
	public static function getCardID($gainID)
	{
		//0->复,1->活,2->节,3->疯,4->狂,5->砸,6->彩,7->蛋,
		//8->船只加速卡I,9->双倍经验卡,10->船只加速卡II,11->宝箱钥匙,12->大鱼炮,13->一键收钱卡,14->3星建设卡,15->船只加速卡III
		$cids = array('0' => '173841', '1' => '173941', '2' => '174041', '3' => '174141', '4' => '174241', '5' => '174341', '6' => '174441', '7' => '174541',
					'8' => '26241', '9' => '74841', '10' => '26341', '11' => '86241', '12' => '134141', '13' => '67441', '14' => '56741', '15' => '26441');
		
		foreach ($cids as $key => $cid) {
			if ($gainID == $key) {
				return $cid;
			}
		}
		
		return 0;
	}
	
	/**
	 * @获取当日金币锤子的次数
	 * @param int $uid
	 * @return int
	 */
	public static function getWoodenHammerNum($uid)
	{
		$key = 'ev:midyear:woodenhammer:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);

		return $data;
	}

	/**
	 * @增加当日使用金币锤子的次数
	 * @param unknown_type $uid
	 */
	public static function addWoodenHammerNum($uid)
	{
		$key = 'ev:midyear:woodenhammer:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);
	
		$data += 1;

		$logDate = date('Y-m-d');
		$dtDate = $logDate . ' 23:59:59';
		$endTime = strtotime($dtDate);
		
		$cache->set($key, $data, $endTime);
	}
	
	/**
	 * @获取当前兑换礼包的信息
	 * @param int $pid
	 * @return Array
	 */
	public static function getData($pid)
	{
		//item:兑换需求,list:奖励物品
		$dataVo = array(array('pid' => 1, 'item' => array('173841' => 1, '173941' => 1, '174041' => 1), 'list' => array('67441' => 3, '74841' => 5)),
						array('pid' => 2, 'item' => array('173841' => 1, '173941' => 1, '174041' => 1, '174341' => 1, '174441' => 1, '174541' => 1), 'list' => array('74841' => 10, '134141' => 10, '67441' => 10, '174632' => 1)),
						array('pid' => 3, 'item' => array('173841' => 1, '173941' => 1, '174041' => 1, '174141' => 1, '174241' => 1, '174341' => 1, '174441' => 1, '174541' => 1), 'list' => array('134141' => 20, '67441' => 20, '174732' => 1)));
		
		foreach ($dataVo as $itemVo) {
			if ($itemVo['pid'] == $pid) {
				$data = $itemVo;
				break;
			}
		}
						
		return $data;
	}
	
	/**
	 * 
	 * @记录使用锤子次数
	 * @param int $uid
	 * @param int $eid
	 */
	public static function addEidCount($uid, $eid)
	{
		$key = 'ev:midyear:eids:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);

		if ($data === false) {
			try {
				$db = Hapyfish2_Island_Event_Dal_MidYear::getDefaultInstance();
				$data = $db->getEids($uid);
			} catch (Exception $e) {}

			if ($data) {
				$cache->set($key, $data, 3600 * 24 * 15);
			}
		}
		
		if ($data) {
			$eid -= 1;
			
			foreach ($data as $dataKey => $dataValues) {
				if ($dataKey == $eid) {
					$data[$dataKey] += 1;
					$num = $data[$dataKey];
					break;
				}
			}
		}

		try {
			$db = Hapyfish2_Island_Event_Dal_MidYear::getDefaultInstance();
			$db->addEids($uid, $eid, $num);
		} catch (Exception $e) {}
		
		$cache->set($key, $data, 3600 * 24 * 15);

	}
	
}