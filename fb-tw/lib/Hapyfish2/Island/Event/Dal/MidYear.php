<?php

/**
 * Event MidYear
 *
 * @package    Island/Event/Dal
 * @copyright  Copyright (c) 2011 Happyfish Inc.
 * @create     2011/12/23    zhangli
*/
class Hapyfish2_Island_Event_Dal_MidYear
{
    protected static $_instance;

    protected $table_event_midyear_items = 'island_event_midyear_items';
    protected $table_event_midyear_eids = 'island_event_midyear_eids';

    /**
     * Single Instance
     *
     * @return Hapyfish2_Island_Dal_NewDays
     */
    public static function getDefaultInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
	
    //获取3种锤子砸卡片的信息
    public function getListArr()
    {
    	$sql = "SELECT eid,item_odds FROM $this->table_event_midyear_items";
    	
		$db = Hapyfish2_Db_Factory::getEventDB('db_0');
        $rdb = $db['r'];
        
        return $rdb->fetchAll($sql);
    }
    
    public function getEids($uid)
    {
		$sql = "SELECT 0,1,2 FROM $this->table_event_midyear_eids WHERE uid=:uid";
    	
		$db = Hapyfish2_Db_Factory::getEventDB('db_0');
        $rdb = $db['r'];
        
        return $rdb->fetchRow($sql, array('uid' => $uid));
    }
    
    public function addEids($uid, $eid, $num)
    {
    	$sql = "UPDATE $this->table_event_midyear_eids SET $eid=:num WHERE uid=:uid";
    	
		$db = Hapyfish2_Db_Factory::getEventDB('db_0');
        $wdb = $db['w'];
        
        $wdb->query($sql, array('uid' => $uid, 'num' => $num));
    }
}