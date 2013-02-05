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
				/*// 大转盘
				$casino = array ('actName' => 'zhuanpan',
								'btn' => 'zhuanpanActBtn',
								'module' => 'swf/turntable.swf?v=2011071401',
								'mClassName' => 'TurntableMain',
								'module2' => '',
								'mClassName2' => '',
								'index' => 1,
								'state' => 0 );
				$actState = array ('zhuanpan' => $casino );*/

				//团购活动
				$icon = Hapyfish2_Island_Event_Bll_TeamBuy::checkIcon($uid);
				$teamBuy = array('actName' => 'teamBuy',
								'module' => 'swf/teamBuy.swf?v=2011071401',
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

				//好友搜索
				$friendserach = array('actName' => 'friendserach',
		        			   		'module2' => 'swf/friendSearch.swf',
		        			   		'state' => 0);
		    	$actState['friendserach'] = $friendserach;

				//star info,累计登录送星座
				$starList = array(
					'actName' => 'dailyGetConstellation',
					'btn' => 'dailyGetConstellationActBtn',
					'module' => 'swf/dailyGetConstellation.swf',
				);
				$actState['dailyGetConstellation'] = $starList;

				//收集任务
				$timekey = 'time';
			    $time =  Hapyfish2_Island_Event_Bll_Hash::getval ($timekey);
				$time = unserialize ($time);
				$switch = Hapyfish2_Island_Event_Bll_Hash::getswitch($uid);

				if($switch) {
					if( time() < $time['end'] && time() >$time['start']) {
						$collectkey = 'collectgift_haveget_' . $uid;
						$collectval = Hapyfish2_Island_Event_Bll_Hash::getval($collectkey);

						if(empty($collectval) ) {
							$state = 0;
						} else {
							$state = 1;
						}

						$collectionTask = array ('actName' => "collectionTask",
										    	'btn' => "collectionTaskActBtn",
										    	'module' => "swf/collectionTask.swf?v=2011071401",
										    	'state' => $state);
					    $actState['collectionTask'] = $collectionTask;
					}
				}

				//邀请好友送宝石
				$inviteFlowStep = Hapyfish2_Island_Event_Bll_InviteFlow::getInviteStep($uid);
				if ($inviteFlowStep >= 0 && $inviteFlowStep < 4) {
					$yaoQingHaoYou = array(
						'actName' => 'yaoQingHaoYou',
						'btn' => 'yaoQingHaoYouActBtn',
						'index' => 2,
						'module' => 'swf/yaoQingHaoYou.swf?v=2011080201',
						'state' => 0
					);
					$actState['yaoQingHaoYou'] = $yaoQingHaoYou;
				}
				
				//上线领礼包,结束时间8-31
				$LUpendtime	  = mktime(23, 59, 0, 8, 31, 2011);
				if( time() < $LUpendtime ) {
					$luptf = Hapyfish2_Island_Event_Bll_UpgradeGift::getTF($uid);
					$luptf = $luptf ? 1 : 0;
					$LUpAward = array('actName'=>'LUpAward',
									'module'=>'swf/versionLevelUpAward.swf',
									'btn'=>'LUpAwardBoxBtn',
									'state'=>$luptf);
					$actState['LUpAward'] = $LUpAward;
				}
			}

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
						'module2' => 'swf/rankingList.swf?v=2011071401',
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

		}

		return $actState;
	}

}