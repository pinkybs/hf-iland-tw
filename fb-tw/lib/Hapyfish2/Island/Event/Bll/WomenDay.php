<?php

/**
 * Event women Day
 *
 * @package    Island/Event/Bll
 * @copyright  Copyright (c) 2012 Happyfish Inc.
 * @create     2012/04/06    swh
*/
class Hapyfish2_Island_Event_Bll_WomenDay
{
	const TXT001 = '寶石不足！';
	const TXT002 = '恭喜你獲得：';
	
	public static function buy($uid, $id)
	{
		$result = array('status' => -1);
		$userGold = Hapyfish2_Island_HFC_User::getUserGold($uid);
		if($id <1 || $id > 4){
			return array('result'=>$result);
		}
		$list = array(
			'1' => array('list'=>array(87032,87332,87432,87532,87832,88232,88332,88432),'price'=>88),
			'2' => array('list'=>array(110132,110432,110732,110832,110932,111032,111332),'price'=>118),
			'3' => array('list'=>array(112732,112832,112932,113032,113132,113232,113332,113432,113532),'price'=>198),
			'4' => array('list'=>array(114832,115132,115232,115332,115432,115532,115621),'price'=>168)
		);
		if($userGold < $list[$id]['price']){
			$result['content'] = self::TXT001;
			return array('result'=>$result);
		}
		$compensation = new Hapyfish2_Island_Bll_Compensation();
		foreach($list[$id]['list'] as $cid){
			$compensation->setItem($cid, 1);
		}
		$compensation->setItem(67441, 10);
		$compensation->setItem(74841, 10);
		$compensation->setItem(134141, 10);
		$ok = $compensation->sendOne($uid, self::TXT002);
		if($ok){
			$userLevelInfo = Hapyfish2_Island_HFC_User::getUserLevel($uid);
			$userLevel = $userLevelInfo['level'];
				//扣除宝石
			$goldInfo = array('uid' => $uid,
							'cost' => $list[$id]['price'],
							'summary' => '三八节特卖礼包',
							'user_level' => $userLevel,
							'create_time' => time(),
							'cid' => '',
							'num' => '');
	
	        $ok2 = Hapyfish2_Island_Bll_Gold::consume($uid, $goldInfo);
	        if($ok2){
	        	info_Log($uid.'---'.$id,'WomenDay');
	        	$result['goldChange'] = -$list[$id]['price'];
	        	$result['status'] = 1;
	        }
		}
		return array('result'=>$result);
	}
}