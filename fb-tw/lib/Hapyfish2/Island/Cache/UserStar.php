<?php

class Hapyfish2_Island_Cache_UserStar
{
	public static function getStarInfo($uid)
    {
        $key = 'i:u:star:' . $uid;
        $cache = Hapyfish2_Cache_Factory::getMC($uid);
        $data = $cache->get($key);

        if ($data === false) {
        	try {
	            $dalUserHelp = Hapyfish2_Island_Dal_UserStar::getDefaultInstance();
	            $data = $dalUserHelp->get($uid);
	            if ($data !== false) {
	            	$cache->add($key, $data);
	            } else {
	            	return null;
	            }
        	} catch (Exception $e) {
        		err_log($e->getMessage());
        		return null;
        	}
        }
      
        $starDb = $data['star_list'];
        //0:未开通, 1:可领取, 2:已领取
        $starList = array(1 => 1, 2 => 1, 3 => 1, 4 => 1, 5 => 1, 6 => 1, 7 => 1, 8 => 1, 9 => 1, 10 => 1, 11 => 1, 12 => 1);
        $starDb = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);
        if ( $data['star_list'] != '' ) {
			$tmp = split(',', $data['star_list']);
			foreach ($tmp as $id) {
				$starList[$id] = 2;
				$starDb[$id] = 1;
			}
		}
    	//update bu hdf 2011-12-20
		$dalPlant = Hapyfish2_Island_Dal_Plant::getDefaultInstance();
		$starPlant = array('1' => 74632, '2' => 74732, '3' => 75532,'4' => 80432, '5' => 85132, '6' => 85232, '7' => 85332, '8' => 85432, '9' => 85532,'10' => 85632, '11' => 85732, '12' => 85832);	
		foreach($starList as $k=>$v) {
			if($v == 1) {
				$plant = $dalPlant->getOneNum($uid, $starPlant[$k]);
				if($plant) {
					$starList[$k] = 3;
				}
			}
		}
        return array('starList' => $starList, 'starDb' => $starDb);
    }
    
    public static function updateStar($uid, $starDb)
    {
		$tmp = array();
		foreach ($starDb as $k => $v) {
			if ( $v == 1 ) {
				$tmp[] = $k;
			}
		}
		
		$info = array();
		if ( !empty($tmp) ) {
			$data = join(',', $tmp);
			$info['star_list'] = $data;
		}
		
    	try {
            $dalUserHelp = Hapyfish2_Island_Dal_UserStar::getDefaultInstance();
            $dalUserHelp->update($uid, $info);
            
        	$key = 'i:u:star:' . $uid;
        	$cache = Hapyfish2_Cache_Factory::getMC($uid);
        	$cache->set($key, $info);
        	
        	return true;
		}catch (Exception $e) {
			return false;
		}
    }
    
    public static function clearStar($uid)
    {
        try {
        	$data = '';
        	$info = array('star_list' => $data);
            $dalUserHelp = Hapyfish2_Island_Dal_UserStar::getDefaultInstance();
            $dalUserHelp->update($uid, $info);
        	$key = 'i:u:star:' . $uid;
        	$cache = Hapyfish2_Cache_Factory::getMC($uid);
        	$cache->set($key, $data);
		}catch (Exception $e) {
			
		}
    }
    /**
     * update by hdf 2011-12-20
     * @param $uid
     */
	public static function getUserStar($uid)
	{
		$userStarKey = 'i:u:star:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$userStars = $cache->get($userStarKey);
		if($userStars === false) {
			return array();
		}
		return $userStars;
	}
	
	public static function getAthenaStar($uid)
	{
		$athenaKey = 'i:u:star:athena:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($athenaKey);
		if($data === false) {
			return 0;
		}
		return $data;
	}
	public static function updateAthenaStar($uid)
	{
		$athenaKey = 'i:u:star:athena:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->set($athenaKey, 1);
	}	
}