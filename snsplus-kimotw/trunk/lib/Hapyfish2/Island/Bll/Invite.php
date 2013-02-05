<?php

class Hapyfish2_Island_Bll_Invite
{

	public static function add($inviteUid, $newUid, $time = null)
	{
		if (!$time) {
			$time = time();
		}

		Hapyfish2_Island_Bll_InviteLog::add($inviteUid, $newUid, $time);

		//add 1000 coin
		Hapyfish2_Island_HFC_User::incUserCoin($inviteUid, 1000);

		//add card
		//$ok = Hapyfish2_Island_HFC_Card::addUserCard($inviteUid, 26341, 1);
		//$cardInfo = Hapyfish2_Island_Cache_BasicInfo::getCardInfo(26341);
		//add 3 starfish
		$starNum = 3;
		$ok = Hapyfish2_Island_Bll_StarFish::add($inviteUid, $starNum, '');
		$targetuser = Hapyfish2_Platform_Bll_User::getUser($newUid);

		$feed = str_replace('{*nickname*}', $targetuser['name'], LANG_PLATFORM_INDEX_TXT_22);

		if ($ok) {
			$feed = array(
				'uid' => $inviteUid,
				'actor' => $inviteUid,
				'target' => $newUid,
				'template_id' => 0,
				//'title' => array('cardName' => $cardInfo['name']),
				'title' => array('title' => $feed),
				'type' => 3,
				'create_time' => $time
			);
			Hapyfish2_Island_Bll_Feed::insertMiniFeed($feed);
		} else {
			info_log('[' . $inviteUid . ':' . $newUid, 'invite_failure');
		}
	}

	public static function refresh($uid, $list)
	{
		if (empty($list)) {
			return;
		}

		$num1 = count($list);
		$log = Hapyfish2_Island_Bll_InviteLog::getAll($uid);
		$all = true;
		if ($log) {
			$num2 = count($log);
			if ($num1 == $num2) {
				return;
			}
			$all = false;
			$tmp = array();
			foreach ($log as $f) {
				$tmp[$f['fid']] = $f['time'];
			}
		}

		$data = array();
		foreach ($list as $v) {
			$puid = $v['uid'];
			$time = $v['mtime'];
			$user = Hapyfish2_Platform_Cache_UidMap::getUser($puid);
			if ($user) {
				$fid = $user['uid'];
				if ($all) {
					$data[$fid] = array('fid' => $fid, 'time' => strtotime($time));
				} else {
					if (!isset($tmp[$fid])) {
						$data[$fid] = array('fid' => $fid, 'time' => strtotime($time));
					}
				}
			}
		}

		if (!empty($data)) {
			foreach ($data as $user) {
				self::add($uid, $user['fid'], $user['time']);
			}
		}

	}

	public static function inviteDone($uid, $invitorUid)
	{

		$rst = Hapyfish2_Island_Cache_User::isAppUser($invitorUid);
		if ($rst) {
		    Hapyfish2_Island_Bll_Invite::add($invitorUid, $uid);
		    $rst = true;
		    info_log($invitorUid . ' invite->' . $uid . 'DONE!', 'invite_done');
		}

		return $rst;
	}
}