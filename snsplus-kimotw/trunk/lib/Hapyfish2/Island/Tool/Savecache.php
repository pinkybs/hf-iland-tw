<?php

class Hapyfish2_Island_Tool_Savecache
{
	public static function saveAllUserCacheByDB($dbId)
	{
		info_log('# savedbAllUser - start - #', 'savedbAllUser_'.$dbId);
		//2012-04-01 00:00:00
		$startTime = 1333209600;
		
		$db = Hapyfish2_Island_Dal_Savediy::getDefaultInstance();
		
		//for($i=0;$i<4;$i++) {
			for($j=0;$j<10;$j++) {
				$count = 0;
				info_log('savedbAllUser:tableId-'.$j, 'savedbAllUser_'.$dbId);
				$uidList = $db->getUidListByPage($dbId, $j, $startTime);
				$kCount = count($uidList);
				for ( $k=0;$k<$kCount;$k++) {
					Hapyfish2_Island_Tool_SaveOldUserCache::saveOne($uidList[$k]['uid']);
					$count++;
					info_log('savedbAllUser:'.$uidList[$k]['uid'].'--count:'.$count, 'savedbAllUser_'.$dbId);
				}
			}
		//}
		info_log('# savedbAllUser - end - #', 'savedbAllUser_'.$dbId);
	}
	
    public static function getUidListVoDada($pageIndex, $dbId, $tableId)
    {
        $uidListVo = self::restore($pageIndex, $dbId, $tableId);
        return Zend_Json::decode($uidListVo);
    }
    
    public static function restore($pageIndex, $dbId, $tableId)
    {
        $file = '/data/temp/uid/'.$dbId.'/'.$tableId.'/uid.' . $pageIndex . '.cache';
        if (is_file($file)) {
            return file_get_contents($file);
        } else {
            return self::dump($pageIndex, $dbId, $tableId);
        }
    }
    
    public static function dump($pageIndex, $dbId, $tableId)
    {
        $resultUidList = self::getUidListVo($pageIndex, $dbId, $tableId);
        $file = '/data/temp/uid/'.$dbId.'/'.$tableId.'/uid.' . $pageIndex . '.cache';
        $data = json_encode($resultUidList);
        file_put_contents($file, $data);
        return $data;
    }
    
    public static function getUidListVo($pageIndex, $dbId, $tableId)
    {
        $resultUidList = array();
        
        $dalClearcache = Hapyfish2_Island_Dal_Clearcache::getDefaultInstance();
        $resultUidList = $dalClearcache->getUidListByPage($pageIndex, 1000, $dbId, $tableId);
        return $resultUidList;
    }
    
	
}