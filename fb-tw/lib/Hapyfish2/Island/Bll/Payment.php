<?php
require_once(CONFIG_DIR . '/language.php');

class Hapyfish2_Island_Bll_Payment
{

    /**
     * pay flow
     *
     * @param string $transId
     * @param integer $amount
     * @param integer $gold
     * @param integer $uid
     * @return integer [0-儲值成功 1-儲值失敗 2-該訂單已經儲值過]
     */
    public static function pay($transId, $amount, $gold, $uid)
    {

		$ok = false;
    	try {
	    	$dalPay = Hapyfish2_Island_Dal_PayOrder::getDefaultInstance();
			$rowPay = $dalPay->getOrder($uid, $transId);
			if ($rowPay && $rowPay['status'] == 1) {
				return 2;
			}
    	} catch (Exception $e) {
			info_log($e->getMessage(), 'Island_Bll_Payment_Err');
			return 2;
		}

		try {
            //transaction pay insert
			$time = time();
			$payinfo = array();
			$payinfo['orderid'] = $transId;
			$payinfo['amount'] = $amount;
			$payinfo['gold'] = $gold;
			$payinfo['actual_gold'] = self::_getActualGold($uid, $gold);
			$payinfo['order_time'] = $time;
			$payinfo['status'] = 1;
			$payinfo['complete_time'] = $time;
			$payinfo['uid'] = $uid;
			$levInfo = Hapyfish2_Island_HFC_User::getUserLevel($uid);
			$payinfo['user_level'] = 0;
			if ($levInfo) {
				$payinfo['user_level'] = $levInfo['level'];
			}
    		$dalPay->regOrder($uid, $payinfo);

    		$userGoldBefore = Hapyfish2_Island_HFC_User::getUserGold($uid);
    		//更新充值记录
    		$loginfo = array(
				'uid' => $uid, 'orderid' => $transId, 'pid' => $transId,
				'amount' => $amount, 'gold' => $payinfo['actual_gold'],
				'create_time' => $time, 'user_level' => $payinfo['user_level'],
				'pay_before_gold' => $userGoldBefore,
				'summary' => $amount.LANG_PLATFORM_BASE_TXT_10.$payinfo['actual_gold'].LANG_PLATFORM_BASE_TXT_02
			);
			$dalPaymentLog = Hapyfish2_Island_Dal_PaymentLog::getDefaultInstance();
			$dalPaymentLog->insert($uid, $loginfo);
			$ok = true;
		} catch (Exception $e) {
		    info_log('[' . $uid . ':' . $transId . ']' . $e->getMessage(), 'payment.err.confirm.1');
		    return 1;
		}

		if ($ok) {
			//发宝石
    		try {
    			$dalUser = Hapyfish2_Island_Dal_User::getDefaultInstance();
    			$dalUser->incGold($uid, $payinfo['actual_gold']);
    			Hapyfish2_Island_HFC_User::reloadUserGold($uid);
    			Hapyfish2_Island_Bll_Vip::insertGem($uid, $gold);
				//update by hdf add send gold log start
				$logger = Hapyfish2_Util_Log::getInstance();
				$logger->report('801', array($uid, $gold, 1));
				//end	
			    			
    		} catch (Exception $e) {
    			info_log('[' . $uid . ':' . $transId . ']' . $e->getMessage(), 'payment.err.confirm.2');
    			return 1;
    		}
    		
    		if ($gold > 10) {
    			//充值送礼物
    			self::sendAdditionItem($gold, $uid);
    		}

			$nowTime = time();
			$changeStarTime = strtotime('2012-03-28 00:00:01');
			$changeEndTime = strtotime('2012-04-03 23:59:59');
			
			if (($nowTime >= $changeStarTime) && ($nowTime <= $changeEndTime)) {
				$flag = Hapyfish2_Island_Event_Cache_EventPay::getPayFlag($uid);
				
				if (!$flag) {
			    	$robot = new Hapyfish2_Island_Bll_Compensation();
    				$robot->setUid($uid);
					
					$robot->setItem(74841, 3);
					$robot->setItem(100832, 1);
					
					$ok = $robot->send(LANG_PLATFORM_EVENT_TXT_14 . '充值首送禮包：');
					
					if ($ok) {
						Hapyfish2_Island_Event_Cache_EventPay::addPayFlag($uid);
						
						info_log($uid, 'payGift0328');
					}
				}
			}
    		Hapyfish2_Island_Cache_Fish::updateUnlock5($uid);
    		return 0;
		}

		return 1;
    }

	private static function _getActualGold($uid, $gold)
	{
		$rtnGold = $gold;

		$nowTime = time();
		
		//加码
		$changeStarTime = strtotime('2012-03-01 00:00:01');
		$changeEndTime = strtotime('2012-03-07 23:59:59');
		
		if (($nowTime >= $changeStarTime) && ($nowTime <= $changeEndTime)) {
			$changestatus = 1;
		} else {
			$changestatus = 2;
		}
		
		if (1 == $changestatus) {			
			//判断是否是首次充值
			$flag = Hapyfish2_Island_Event_Cache_EventPay::getPayFlag($uid);
			
			if (!$flag) {
				//计算加送宝石数
				if ($gold >= 183) {
					$rtnGold += 140;
				} else if($gold >= 54) {
					$rtnGold += 40;
				} else if($gold >= 27) {
					$rtnGold += 18;
				} else if($gold >= 13) {
					$rtnGold += 8;
				}
				
				Hapyfish2_Island_Event_Cache_EventPay::addPayFlag($uid);
				
		    	$robot = new Hapyfish2_Island_Bll_Compensation();
    			$robot->setUid($uid);
    	
				$robot->setCoin(50000);
				$robot->setItem(67441, 3);
				$robot->setItem(74841, 3);
				$robot->setItem(86241, 3);
				$robot->setItem(119932, 1);
	
				//$sendOK = $robot->send(LANG_PLATFORM_INDEX_TXT_23);
				$sendOK = $robot->send('充值送:');
				
				if ($sendOK) {
					info_log($uid, 'paymentOK0301');
				}
			} else {
				//计算加送宝石数
				if ($gold >= 183) {
					$rtnGold += 90;
				} else if($gold >= 54) {
					$rtnGold += 25;
				} else if($gold >= 27) {
					$rtnGold += 10;
				} else if($gold >= 13) {
					$rtnGold += 4;
				}
			}
		} else {
			//计算加送宝石数
			if ($gold >= 183) {
				$rtnGold += 90;
			} else if($gold >= 54) {
				$rtnGold += 25;
			} else if($gold >= 27) {
				$rtnGold += 10;
			} else if($gold >= 13) {
				$rtnGold += 4;
			}
		}

		return $rtnGold;
	}

    public static function sendAdditionItem($gold, $uid)
    {
    	$robot = new Hapyfish2_Island_Bll_Compensation();
    	$robot->setUid($uid);
    	
    	if ($gold >= 183) {
			$robot->setItem(177941, 15);
			$robot->setItem(179241, 75);
			$robot->setItem(181632, 1);
			$robot->setItem(181532, 1);
			//Hapyfish2_Island_Cache_FishCompound::addUserSkill($uid, 20, 5);
		} else if ($gold >= 54) {
			$robot->setItem(177941, 7);
			$robot->setItem(179241, 35);
			$robot->setItem(181432, 1);
			//Hapyfish2_Island_Cache_FishCompound::addUserSkill($uid, 16, 5);
		} else if ($gold >= 27) {
			$robot->setItem(177941, 3);
			$robot->setItem(179241, 15);
			//Hapyfish2_Island_Cache_FishCompound::addUserSkill($uid, 5, 5);
			$robot->setItem(181332, 1);
		} else if ($gold >= 13) {
			
			$robot->setItem(177941, 1);
			$robot->setItem(179241, 6);
			//Hapyfish2_Island_Cache_FishCompound::addUserSkill($uid, 1, 5);
			$robot->setItem(181232, 1);
		}

		$robot->send(LANG_PLATFORM_INDEX_TXT_23);
		
		return true;
    }

}