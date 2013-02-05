<?php

/**
 * Event eventPay
 *
 * @package    Island/Event/Bll
 * @copyright  Copyright (c) 2011 Happyfish Inc.
 * @create     2011/12/19    zhangli
*/
class Hapyfish2_Island_Event_Bll_EventPay
{
	public static function getPayFor()
	{
		$dateFor = 8;
		$payStartTime = strtotime('2012-03-01 00:00:01');
		$payFalseTime = strtotime('2012-03-07 23:59:59');
		
		$data = array('dateFor' => $dateFor, 'startTime' => $payStartTime, 'falseTime' => $payFalseTime);
		
		return $data;
	}
	
	/**
	 * @充值初始化
	 * @param int $uid
	 * @return Array
	 */
	public static function getEventPayInit($uid)
	{
		$result = array('status' => -1);
		
		$dateForData = self::getPayFor();
		
		$dateFor = $dateForData['dateFor'];
		$statTime = $dateForData['startTime'];
		$endTime = $dateForData['falseTime'];
		
		//用户储值的数量
		$dalPay = Hapyfish2_Island_Dal_PayOrder::getDefaultInstance();
		$payNum = $dalPay->getPayNum($uid, $statTime, $endTime);

		//各额度礼包领取状态
		$dataVo = Hapyfish2_Island_Event_Cache_EventPay::getStatus($uid, $dateFor);
		
		foreach ($dataVo as $val) {
			$start[] = $val[1];
		}
		
		$nowTime = time();
		$time = $endTime - $nowTime;
		
		$result['status'] = 1;
		$resultVo = array('result' => $result, 'time' => $time, 'svalue' => (int)$payNum, 'states' => $start);
		return $resultVo;
	}

	/**
	 * @领取礼包
	 * @param int $uid
	 * @return Array
	 */
	public static function getEventPayGift($uid, $pid)
	{
		$result = array('status' => -1);
	
		//礼包ID只能是数组中的
		if (!in_array($pid, array(1, 2, 3, 4))) {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		$dateForData = self::getPayFor();
		
		$dateFor = $dateForData['dateFor'];
		$statTime = $dateForData['startTime'];
		$endTime = $dateForData['falseTime'];
		
		//用户储值的数量
		$dalPay = Hapyfish2_Island_Dal_PayOrder::getDefaultInstance();
		$payNum = $dalPay->getPayNum($uid, $statTime, $endTime);

		//各额度礼包领取状态
		$dataVo = Hapyfish2_Island_Event_Cache_EventPay::getStatus($uid, $dateFor);

		//pid对应的礼包
		$pidArr = Hapyfish2_Island_Event_Cache_EventPay::getPids($dateFor);
	
		$tid = 0;
		foreach ($pidArr as $pk => $pv) {
			if ($pk == $pid) {
				$tid = $pv;
				break;
			}
		}
		
		if (!$tid) {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		foreach ($dataVo as $data) {
			if ($data[0] == $tid) {
				//重复领取
				if ($data[1] == 1) {
					$result['content'] = '不能重复领取!';
					$resultVo = array('result' => $result);
					return $resultVo;
				}
				
				//次数不够
				if ($payNum < $data[0]) {
					$result['content'] = '充值数量不足,不能领取!';
					$resultVo = array('result' => $result);
					return $resultVo;
				}
				
				break;
			}
		}

		//奖励物品列表
		$items = Hapyfish2_Island_Event_Cache_EventPay::getItemList($tid, $dateFor);

		$com = new Hapyfish2_Island_Bll_Compensation();

		$com->setCoin($items['coin']);
		foreach ($items['item_str'] as $key => $val) {
			$com->setItem($val[0], $val[1]);
		}
		
		$ok = $com->sendOne($uid, '');
		
		if ($ok) {
			//标记状态
			Hapyfish2_Island_Event_Cache_EventPay::addStatus($uid, $tid, $dateFor);
			
			info_log($uid . ',' . $tid, 'EventPayGift-' . $dateFor);
		} else {
			$result['content'] = 'serverWord_101';
			$resultVo = array('result' => $result);
			return $resultVo;
		}
		
		$result['status'] = 1;
		$result['coinChange'] = $items['coin'];
		$result['itemBoxChange'] = true;
		$resultVo = array('result' => $result);
		return $resultVo;
	}
	
}