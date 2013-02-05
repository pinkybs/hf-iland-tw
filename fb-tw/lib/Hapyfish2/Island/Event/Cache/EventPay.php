<?php

/**
 * Event EventPay
 *
 * @package    Island/Event/Bll
 * @copyright  Copyright (c) 2011 Happyfish Inc.
 * @create     2011/12/19    zhangli
*/
class Hapyfish2_Island_Event_Cache_EventPay
{
	/**
	 * @是否是首次充值的标记
	 * @param int $uid
	 * @return boolean
	 */
	public static function getPayFlag($uid)
	{
		$key = 'ev:event:first:0328:flag:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);

		if ($data === false) {
			try {
				$db = Hapyfish2_Island_Event_Dal_EventPay::getDefaultInstance();
				$flag = $db->getPayFlag($uid);
			} catch (Exception $e) {}
		
			if ($flag) {
				$data = 1;
				$cache->set($key, $data);
			}
		}
		
		return $data;
	}
	
	/**
	 * @增加首次充值的标记
	 * @param int $uid
	 */
	public static function addPayFlag($uid)
	{
		try {
			$db = Hapyfish2_Island_Event_Dal_EventPay::getDefaultInstance();
			$db->addPayFlag($uid);
		} catch (Exception $e) {}
		
		$key = 'ev:event:first:0328:flag:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->set($key, 1);
	}
	
	/**
	 * @礼包领取状态
	 * @param int $uid
	 * @return Array
	 */
	public static function getStatus($uid, $dateFor)
	{
		$key = 'ev:eventpay:' . $dateFor . ':pay:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);
		
		if ($data === false) {
			try {
				$db = Hapyfish2_Island_Event_Dal_EventPay::getDefaultInstance();
				$dataStr = $db->getData($uid, $dateFor);
			} catch (Exception $e) {}
		
			if ($dataStr) {
				$data = json_decode($dataStr);
				$cache->set($key, $data);
			} else {
				try {
					$dataPay = $db->getPayDateFor($dateFor);
				}  catch (Exception $e) {}
				
				try {
					$db->insertData($uid, $dataPay, $dateFor);
				}  catch (Exception $e) {}
				
				try {
					$dataStr = $db->getData($uid, $dateFor);
				}  catch (Exception $e) {}
				
				$data = json_decode($dataStr);
			}
		}
		
		return $data;
	}
	
	/**
	 * @改变礼包领取状态
	 * @param int $uid
	 * @param int $pid
	 */
	public static function addStatus($uid, $pid, $dateFor)
	{
		$dataVo = self::getStatus($uid, $dateFor);
	
		foreach ($dataVo as $dataKey => $dataVal) {
			if ($dataVal[0] == $pid) {
				$dataVo[$dataKey][1] = 1;
				break;
			}
		}
		
		$dataStr = json_encode($dataVo);
		
		try {
			$db = Hapyfish2_Island_Event_Dal_EventPay::getDefaultInstance();
			$db->updateStatus($uid, $dataStr, $dateFor);			
		} catch (Exception $e) {}
		
		$key = 'ev:eventpay:' . $dateFor . ':pay:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->set($key, $dataVo);
	}
	
	/**
	 * @奖励物品列表
	 * @param int $pid
	 * @return Array
	 */
	public static function getItemList($pid, $dateFor)
	{
		$key = 'ev:eventpay:gift:' . $dateFor;
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$dataArr = $cache->get($key);
		
		if ($dataArr === false) {
			$db = Hapyfish2_Island_Event_Dal_EventPay::getDefaultInstance();
			$dataArr = $db->getItemList($dateFor);
			
			foreach ($dataArr as $arrKy => $dataList) {
				$dataArr[$arrKy]['item_str'] = json_decode($dataList['item_str']);	
			}
			
			$cache->set($key, $dataArr);
		}
	
		foreach ($dataArr as $dataStr) {
			if ($dataStr['pid'] == $pid) {
				$data = $dataStr;
				break;
			}
		}
		
		return $data;
	}
	
	public static function getPids($dateFor)
	{
		$db = Hapyfish2_Island_Event_Dal_EventPay::getDefaultInstance();
		$dataArr = $db->getPids($dateFor);
		
		$pidArr = array();
		foreach ($dataArr as $key => $pid) {
			$pidArr[$key + 1] = $pid;
		}
		
		return $pidArr;
	}
	
}