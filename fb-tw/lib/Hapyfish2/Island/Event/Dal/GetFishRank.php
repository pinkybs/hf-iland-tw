<?php
class Hapyfish2_Island_Event_Dal_GetFishRank
{
    protected static $_instance;

    /**
     * Single Instance
     *
     * @return Hapyfish2_Island_Event_Dal_GetFishRank
     */
    public static function getDefaultInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public static function FishRank($rows)
    {
    	$db = Hapyfish2_Db_Factory::getEventDB('db_0');
        $wdb = $db['w'];
        $tableName = "catchfish_rank";
	    return $wdb->insert($tableName, $rows);    	
    }
    //获取上一期用户的UID
    public static function getLastDateUser()
    {
    	$db = Hapyfish2_Db_Factory::getEventDB('db_0');
    	$rdb = $db['r'];
    	$sqlCheck = 'SELECT date FROM catchfish_rank ORDER BY date DESC LIMIT 1';
    	$date = $rdb->fetchOne($sqlCheck);
    	$sql = "SELECT uid FROM catchfish_rank WHERE date=:date ORDER BY rank ASC";
    	$data = $rdb->fetchAll($sql, array('date'=>$date));
    	return $data;
    }
}