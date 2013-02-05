<?php

class Hapyfish2_Island_Bll_Act
{
	public static function get($uid = 0)
	{
		$now = time();
		$actState = array();

		//check user help complete
		$helpCompleted = 0;
		$userHelp = Hapyfish2_Island_Cache_UserHelp::getHelpInfo($uid);
		if ( $userHelp['completeCount'] == 8 ) {
			$helpCompleted = 1;
		}

		if ($uid > 0) {
			if ( $helpCompleted == 1 ) {
					// 大转盘
				$casino = array ('actName' => 'zhuanpan',
								'btn' => 'zhuanpanActBtn',
								'module' => 'swf/turntable.swf?v=2011071401',
								'mClassName' => 'TurntableMain',
								'module2' => '',
								'mClassName2' => '',
								'index' => 2,
								'state' => 0 );
				$actState = array ('zhuanpan' => $casino );
				
				//团购活动
				$icon = Hapyfish2_Island_Event_Bll_TeamBuy::checkIcon($uid);
				$teamBuy = array('actName' => 'teamBuy',
								'module' => 'swf/v9/teamBuy.swf?v=2011071401',
								'btn' => 'teamBuyActBtn',
								'state' => $icon);
				$actState['teamBuy'] = $teamBuy;

				//天气feed
				$flashStrom = array('actName' => 'feedflashstorm',
								'module2' => 'swf/feedflashstorm.swf?v=2011071401',
								'state' => 0);
				$actState['feedflashstorm'] = $flashStrom;

				//积分兑换
				$jifen = array ('actName' => 'jifen',
								'index' => 4,
								'btn' => 'jifenActBtn',
								'link' => HOST . '/casinochange/index',
								'state' => '0' );
				$actState ['jifen'] = $jifen;

//		    	//停机补偿,结束时间7-31
//				$LUpendtime = mktime(23, 59, 0, 7, 31, 2011);
//				if ($now < $LUpendtime) {
//					$luptf = Hapyfish2_Island_Event_Bll_UpgradeGift::getTF($uid);
//					$luptf = $luptf ? 1 : 0;
//					$LUpAward = array('actName' => 'LUpAward',
//									'module' => 'swf/v2011110301/versionLevelUpAward.swf?v=2011071401',
//									'btn' => 'LUpAwardBoxBtn',
//									'state' => $luptf);
//					$actState['LUpAward'] = $LUpAward;
//				}

//				//补偿礼包
//				$startTime = strtotime('2011-11-03 00:00:01');
//				$endTime = strtotime('2011-11-13 23:59:59');
//				if (($now >= $startTime) && ($now <= $endTime)) {
//					$luptf = Hapyfish2_Island_Event_Bll_UpgradeGift::getTF($uid);
//					$luptf = $luptf ? 1 : 0;
//					$testGift = array('actName' => 'testGift',
//									'module' => 'swf/v2011110301/testGift.swf?v=2011110301',
//									'btn' => 'TestGiftActButton',
//									'state' => $luptf);
//					$actState['testGift'] = $testGift;
//				}
				
				//好友搜索
				$friendserach = array('actName' => 'friendserach',
		        			   		'module2' => 'swf/friendSearch.swf',
		        			   		'state' => 0);
		    	$actState['friendserach'] = $friendserach;

				//star info,累计登录送星座
				$starList = array(
					'actName' => 'dailyGetConstellation',
					'btn' => 'dailyGetConstellationActBtn',
					'module' => 'swf/v2012013101/dailyGetConstellation.swf',
					'index' => 3,
				);
				$actState['dailyGetConstellation'] = $starList;

				//收集任务
				$timekey = 'time';
			    $time =  Hapyfish2_Island_Event_Bll_Hash::getval ($timekey);
				$time = unserialize ($time);
				$switch = Hapyfish2_Island_Event_Bll_Hash::getswitch($uid);

				if ($switch) {
					if ($now < $time['end'] && $now >$time['start']) {
						$collectkey = 'collectgift_haveget_' . $uid;
						$collectval = Hapyfish2_Island_Event_Bll_Hash::getval($collectkey);

						if (empty($collectval) ) {
							$state = 0;
						} else {
							$state = 1;
						}

						$collectionTask = array ('actName' => "collectionTask",
										    	'btn' => "collectionTaskActBtn",
										    	'module' => "swf/v2011110301/collectionTask.swf?v=2011110301",
										    	'state' => $state);
					    $actState['collectionTask'] = $collectionTask;
					}
				}
				
				//邀请好友送宝石
//				$inviteFlowStep = Hapyfish2_Island_Event_Bll_InviteFlow::getInviteStep($uid);
//				if ($inviteFlowStep >= 0 && $inviteFlowStep < 4) {
//					$yaoQingHaoYou = array(
//						'actName' => 'yaoQingHaoYou',
//						'btn' => 'yaoQingHaoYouActBtn',
//						'index' => 2,
//						'module' => 'swf/yaoQingHaoYou.swf?v=2011071401',
//						'state' => 0
//					);
//					$actState['yaoQingHaoYou'] = $yaoQingHaoYou;
//				}
			}
//
//		    //元旦活动
//		    $newDaysTime = strtotime('2012-04-17 23:59:59');
//		    if ($now <= $newDaysTime) {
//				$newDays = array ('actName' => "HappyNewYear",
//								'module' => "swf/v2012040901/HappyNewYear.swf?v=2011123001",
//								'btn' => 'com.hapyfish.hny.HnyActBtn',
//								'index' => 1,
//								'state' => 0);
//		    	$actState['newDays'] = $newDays;
//		    }
//			
//		    //春节活动
//		    $SFTime = strtotime('2012-01-31 23:59:59');
//		    if ($now <= $SFTime) {
//				$springFestival = array ('actName' => "newYear",
//									'module' => "swf/v2012011701/newYearJiaozi.swf?v=2012017001",
//									'btn' => 'newYearJiaoziBtn',
//									'state' => 0);
//		    	$actState['newYear'] = $springFestival;
//		    }
//			
//		    //元宵节活动
//		    $LFEndTime = strtotime('2012-02-08 23:59:59');
//		    if ($now <= $LFEndTime) {
//				$lanternFestival = array ('actName' => "YuanXiaoMeiShi",
//									'module' => "swf/v2012020201/YuanXiaoMeiShi.swf?v=2012020201",
//									'btn' => 'YuanXiaoMeiShiActBtn',
//									'index' => 2,
//									'state' => 0);
//		    	$actState['YuanXiaoMeiShi'] = $lanternFestival;
//		    }
//		    
//			//情人节活动
//		    $valEndTime = strtotime('2012-02-19 23:59:59');
//		    if ($now <= $valEndTime) {
//		    	Hapyfish2_Island_Event_Cache_ValentineDay::firstQuest($uid);
//				$valentineDay = array ('actName' => "ValentineExchange",
//									'module' => "swf/v2012020901/ValentineExchange.swf?v=2012020701",
//									'btn' => 'ValentineExchangeBtn',
//									'index' => 2,
//									'state' => 0);
//		    	$actState['ValentineExchange'] = $valentineDay;
//
//				$valentineDayPlant = array ('actName' => "ValentinePlant",
//									'module' => "swf/v2012021301/ValentinePlant.swf?v=v2012021301",
//									'index' => 2,
//									'state' => 0);
//		    	$actState['ValentinePlant'] = $valentineDayPlant;
//		    }
			
			//充值活动
			$payFalse = Hapyfish2_Island_Event_Bll_EventPay::getPayFor();
			if ($now <= $payFalse['falseTime']) {
				$SVGifts = array(
							'actName' => 'SVGifts',
							'btn' => 'com.hapyfish.svg.ActIconButton',
	        		   		'module' => 'swf/v2012022801/SVGifts.swf?v=2011122203',
	        		   		'state' => 0);
				$actState['SVGifts'] = $SVGifts;
			}
			
			//自动升级水晶祭坛
			$altarEnd = strtotime('2012-05-09 23:59:59');
			if ($now < $altarEnd) {
				$Altar = array ('actName' => "CrystalSacrificialAltar",
								'module' => "swf/v2012050201/CrystalSacrificialAltar.swf?v=v2012021301",
								'btn' => 'CrystalSacrificialAltarBtn',
								'index' => 2,
								'state' => 0);
		    	$actState['CrystalSacrificialAltar'] = $Altar;
			}
			
			//繁中活动DM
//			$newsIconTw = array(
//						'actName' => 'platformDM',
//        		   		'module2' => 'swf/v2011122901/platformDM.swf?v=2012010601',
//        		   		'state' => 0);
//			$actState['newsIconTW'] = $newsIconTw;
			
		    //图鉴
			$atlasBook = array ('actName' => "medalBook",
							'module' => "swf/v2012030601/MedalBook.swf?v=2012010601",
							'btn' => 'medalBookActBtn',
							'index' => 1,
							'state' => 0);
	    	$actState['medalBook'] = $atlasBook;
			
			//建筑兑换
			$magicEndTime = strtotime('2012-04-03 23:59:59');
			if($now <= $magicEndTime){
				$magicAcademy = array ('actName' => "MagicAcademy",
								'module' => "swf/v2012032601/MagicAcademy.swf?v=2012010601",
								'btn' => 'MagicAcademyBtn',
								'index' => 1,
								'state' => 0);
		    	$actState['MagicAcademy'] = $magicAcademy;
			}
	    	
    		//一元店
//			$oneGoldEndTime = strtotime('2011-12-31 14:00:00');
//			if ($now <= $oneGoldEndTime) {
//				$onegold = array('actName' => 'oneyuanshop',
//								'module2' => 'swf/v20/Oneyuanshop.swf?v=2011082202',
//								'btn'	=>	'oneyuanBtn',
//								'state' => 0);
//				$actState['Oneyuanshop'] = $onegold;
//			}

			//圣诞节活动
//			$chrismasEndTime = strtotime('2011-12-28 23:59:59');
//			if ($now <= $chrismasEndTime) {
//				$christmas = array('actName' => 'MerryChristmas',
//								'module' => 'swf/v2011120101/MerryChristmasDM.swf?v=2011120101',
//								'module2' => 'swf/v2011122001/MerryChristmas.swf?v=2011122201',
//								'btn' => 'MerryChristmasbtn',
//								'index' => 0,
//								'state' => 0);
//				$actState['christmas'] = $christmas;
//			}

			//感恩节活动
//			$endTime = strtotime('2011-11-29 23:59:59');
//			if ($now <= $endTime) {
//				$Thanksgiving = array('actName' => 'Thanksgiving',
//								'module' => 'swf/v2011112801/Thanksgiving.swf?v=2011112204',
//								'module2' => 'swf/v2011112801/Thanksgiving.swf?v=2011112204',
//								'btn' => 'ThanksgivingActBtn',
//								'state' => 0);
//				$actState['Thanksgiving'] = $Thanksgiving;
//			}
			
//			//万圣节,10月26-11月09日
//			//$startTime = strtotime('2011-10-24 14:00:00');
//			$endTime = strtotime('2011-11-09 23:59:59');
//			//if (($now >= $startTime) && ($now <= $endTime)) {
//			if ($now <= $endTime) {
//				$halloween = array('actName' => 'halloween',
//								'btn' => 'com.hapyfish.hw.ui.HalloweenIconButton',
//								'module' => 'swf/v20111026001/halloween.swf?v=2011102504',
//	        		   			'module2' => 'swf/v20111026001/halloween.swf?v=2011102504',
//	        		   			'index' => 1,
//	        		   			'state' => 0);
//				$actState['halloween'] = $halloween;
//			}
			
//			//单身节活动
//			$endTime = strtotime('2011-11-16 23:59:59');
//			if ($now <= $endTime) {
//				$blackDay = array('actName' => 'SingleDay',
//								'module' => 'swf/v2011110801/SingleDay.swf?v=2011110803',
//								'module2' => 'swf/v2011110801/SingleDay.swf?v=2011110803',
//								'state' => 0);
//				$actState['blackDay'] = $blackDay;
//			}
			
    		//捕鱼
			$catchFish = array('actName' => 'CatchFish',
								'module2' => 'swf/v2012052401/CatchFish.swf?v=2012052401',
								'module' => 'swf/v2012041701/CatchFishDM.swf?v=2012040602',
								'btn' => 'Moudle1CatchFishBtn',
								'index' => 12,
								'state' => 0);
			$actState['CatchFish'] = $catchFish;
			$catchFish1 = array('actName' => 'CatchFishGameFish',
								'module' => 'swf/v2012050401/CatchFishGameFish.swf?v=2012050401',
								'btn' => 'CatchFishGameFishBtn',
								'index' => 13,
								'state' => 0);
			$actState['CatchFish1'] = $catchFish1;
			$vipLook = array(	'actName' => 'CatchFishVipLook',
									'btn' => 'CatchFishVipLookbtn',
									'module' => 'swf/v2012050401/CatchFishVipLook.swf?v=2012050401',
									);
			$actState['CatchFishVipLook'] = $vipLook;
			
//			$cardChange = array('actName' => 'CatchFishCardEX',
//								'module' => 'swf/v2012030101/CatchFishCardEx.swf?v=20120223',
//								'btn' => 'CatchFishCardEXBtn',
//								'state' => 0);
//			$actState['cardChange'] = $cardChange;
			
			//特卖海星
			$starfishAndExternalMall = array(
						'actName' => 'starfishAndExternalMall',
						'btn' => '',
						'index' => 2,
						'module2' => 'swf/starfishAndExternalMall.swf?v=2011071401',
						'state' => 0);
			$actState['starfishAndExternalMall'] = $starfishAndExternalMall;

			//news，海岛新闻
			$newsIcon = array(
						'actName' => 'newsIcon',
        		   		'module2' => 'swf/newsIcon.swf?v=2011071401',
        		   		'state' => 0);
			$actState['newsIcon'] = $newsIcon;

			//岛屿扩建图标
			$islandGuide = array(
							'actName' => 'upgradeIslandGuide',
							'btn' => '',
							'module2' => 'swf/upgradeIslandGuide.swf',
							'state' => 0);
			$actState['upgradeIslandGuide'] = $islandGuide;

			//排行榜
			/*$rankList = array(
						'actName' => 'rankList',
						'btn' => '',
						'index' => 2,
						'module2' => 'swf/v16/rankingList.swf?v=2011071401',
						'state' => 0,
					);
			$actState['rankList'] = $rankList;*/

			// 时间性礼物
			$cache = Hapyfish2_Cache_Factory::getMC($uid);
			$key = 'event_timegift_' . $uid;
			$val = $cache->get($key);

			if( $val && $val['state'] < 6 ) {
				$sixTimesGift = array(	'actName' => 'sixTimesGift',
										'module2' => 'swf/SixTimesGiftMain.swf?v=2011071401',
										'state' => (int)$val['state'] );
				$actState['sixTimesGift'] = $sixTimesGift;
			}

			//七夕活动
			/*if($now <= 1313768399){
				$valentine = array(
					'actName' => 'tanabata',
					'btn' => 'tanabataActBtn',
					'index' => 0,
					'module' => 'swf/tanabata.swf?v=2011080402',
					'state' => 0
					);
				$actState['valentineRose'] = $valentine;
				$status = Hapyfish2_Island_Event_Bll_Qixi::getswitch($uid);
				if($status){
					$statue = 1;
				}else{
					$statue = 0;
				}
				$valentine2 = array(
					'actName' => 'tanabata2',
					'btn' => 'tanabata2ActBtn',
					'index' => 0,
					'module' => 'swf/tanabata2.swf?v=2011080202',
					'state' => $statue
					);
				$actState['tanabata2'] = $valentine2;
			}

			if($now <= 1316102399){
				$checktoday = Hapyfish2_Island_Event_Bll_Qixi::checkToday($uid);
				if($checktoday){
					$statue = 0;
				}else{
					$statue = 1;
				}
				$qixiGetgift = array(	'actName' => 'tanabataGift',
								'module' => 'swf/tanabataGift.swf?v=2011080202',
								'index' => 0,
								'state' => $statue
							);
				$actState['tanabataGift'] = $qixiGetgift;
			}

			if($now <= 1318348799){
				$guoqing = array(
					'actName' => 'guoqing',
					'btn' => 'ChronoCrossActBtn',
					'module2' => 'swf/v2011092701/ChronoCross.swf?v=2011080202',
					'module' => 'swf/v2011092701/ChronoCross.swf?v=2011080202',
					'state' => 0

					);
				$actState['guoqing'] = $guoqing;
			}

			//梦想花园
	    	$ret = Hapyfish2_Island_Event_Bll_DreamGardenUserAward::check($uid);
			$dreamgarden = array(
				'actName' => 'dreamGardenUserAward',
				'btn' => 'dreamGardenUserAwardActBtn',
				'index' => 2,
				'module' => 'swf/dreamGardenUserAward.swf?v=2011071401',
				'state' => $ret ? 1 : 0,
			);
			$actState['dreamGardenUserAward'] = $dreamgarden;*/
		}
		
		$TEEndTime = strtotime('2012-03-21 23:59:59');
		if($now <= $TEEndTime){
			$womenDay = array('actName' => 'threeEightDay',
					'module' => 'swf/20120307/threeEightDay.swf?v=2011071401',
					'btn' => 'threeEightDayBtn',
					'state' => 0);
			$actState['womenDay'] = $womenDay;
		}
		
		return $actState;
	}

}