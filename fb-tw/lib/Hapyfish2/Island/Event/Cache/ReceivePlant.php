<?php

/**
 * Event ReceivePlant
 *
 * @package    Island/Event/Bll
 * @copyright  Copyright (c) 2012 Happyfish Inc.
 * @create     2012/01/11    zhangli
*/
class Hapyfish2_Island_Event_Cache_ReceivePlant
{
	const dateFor = 0328;
	
	/**
	 * @获取用户建筑领取状态
	 * @param int $uid
	 * @return Array
	 */
	public static function getExchangeAble($uid)
	{
		$dateFor = self::dateFor;
		
		$key = 'ev:exchange:' . $dateFor . ':able:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$list = $cache->get($key);
		
		if ($list == false) {
 			try {
				$db = Hapyfish2_Island_Event_Dal_ReceivePlant::getDefaultInstance();
				$list = $db->getExchangeAble($uid, $dateFor);
			} catch (Exception $e) {}
			
			if ($list) {
				$cache->set($key, $list);
			}
		}
		
		return $list;
	}
	
	/**
	 * @更新领取状态
	 * @param int $uid
	 * @param Array $list
	 */
	public static function renewExchangeAble($uid)
	{
		$dateFor = self::dateFor;
		
		try {
			$db = Hapyfish2_Island_Event_Dal_ReceivePlant::getDefaultInstance();
			$db->incExchangeAble($uid, 1, $dateFor);
		} catch (Exception $e) {}
		
		$key = 'ev:exchange:' . $dateFor . ':able:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->set($key, 1);
	}
}