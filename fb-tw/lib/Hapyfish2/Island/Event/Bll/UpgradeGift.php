<?php
class Hapyfish2_Island_Event_Bll_UpgradeGift
{

	public static function getTF($uid)
	{
		$key = 'i:u:upgradegift:ft:' . $uid;

		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);
		return ($data ? true : false);
	}

	public static function setTF($uid)
	{
		$key = 'i:u:upgradegift:ft:' . $uid;

		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		return $cache->add($key, 1, Hapyfish2_Cache_Memcached::LIFE_TIME_ONE_MONTH);
	}

	public static function clearTF($uid)
	{
		$key = 'i:u:upgradegift:ft:' . $uid;

		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		return $cache->delete($key);
	}

	public static function gifttouser($uid)
	{
		if ($uid) {
			//$gold = 10;
			$coin = 50000;
			/*
			金币50000
			宝箱钥匙 3张(86241)
			抽奖卷   3张 (55141)
			4星建设卡 1张(56841)
			一键收取卡  5张(67441)
			双倍经验卡 10张(74841)
			船只加速卡III 10张(26441) 
			*/

			$items[] = array('86241', 3);
			$items[] = array('55141', 3);
			$items[] = array('56841', 1);
			$items[] = array('67441', 5);
			$items[] = array('74841', 10);
			$items[] = array('26441', 10);

			$com = new Hapyfish2_Island_Bll_Compensation();
			$com->setCoin($coin);
			//$com->setGold($gold, 0);
			foreach ($items as $key => $val) {
				$com->setItem($val[0], $val[1]);
			}
			
			$com->sendOne($uid, '獲得:');

			//send feed
			$type = 'THANKSGIVING';
			$feed = Hapyfish2_Island_Bll_Activity::send($type, $uid);
			
			return array('status' => 1, 'feed' => $feed);
		} else {
			return array('status' => -1, 'feed' => '');
		}
	}


}