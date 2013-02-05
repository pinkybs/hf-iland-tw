<?php

/**
 * Event EventPay
 *
 * @package    Island/Event/Dal
 * @copyright  Copyright (c) 2011 Happyfish Inc.
 * @create     2011/12/19    zhangli
*/
class Hapyfish2_Island_Event_Dal_EventPay
{
    protected static $_instance;
	
	protected $table_event_pay = 'island_event_pay';
	protected $table_event_item = 'island_event_item';
	protected $table_event_payflag_newyear = 'island_event_payflag_newyear';
	protected $table_event_pay_for = 'island_event_pay_for';
	protected $table_event_payflag_addpay = 'island_event_payflag_addpay';
	protected $table_event_payflag_0301 = 'island_event_payflag_0301';
    
    /**
     * Single Instance
     *
     * @return Hapyfish2_Island_Dal_Task
     */
    public static function getDefaultInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function getData($uid, $dateFor)
    {
		$sql = "SELECT data_str FROM $this->table_event_pay WHERE uid=:uid AND idx=:idx";
		
		$db = Hapyfish2_Db_Factory::getEventDB('db_0');
        $rdb = $db['r'];

        return $rdb->fetchOne($sql, array('uid' => $uid, 'idx' => $dateFor));
    }
    
    public function insertData($uid, $data_str, $dateFor)
    {
		$sql = "INSERT INTO $this->table_event_pay (uid, data_str, idx) VALUES (:uid, :data_str, :idx)";
		
		$db = Hapyfish2_Db_Factory::getEventDB('db_0');
        $wdb = $db['w'];

        $wdb->query($sql, array('uid' => $uid, 'data_str' => $data_str, 'idx' => $dateFor));
    }
    
    public function updateStatus($uid, $data_str, $dateFor)
    {
		$sql = "UPDATE $this->table_event_pay SET data_str=:data_str WHERE uid=:uid AND idx=:idx";
		
		$db = Hapyfish2_Db_Factory::getEventDB('db_0');
        $wdb = $db['w'];

        $wdb->query($sql, array('uid' => $uid, 'data_str' => $data_str, 'idx' => $dateFor));
    }
    
    public function getItemList($dateFor)
    {
		$sql = "SELECT pid,coin,item_str FROM $this->table_event_item WHERE idx=:idx";
		
		$db = Hapyfish2_Db_Factory::getEventDB('db_0');
        $rdb = $db['r'];

        return $rdb->fetchAll($sql, array('idx' => $dateFor));
    }
    
    public function getPayFlag($uid)
    {
    	$sql = "SELECT uid FROM $this->table_event_payflag_0328 WHERE uid=:uid";
    	
    	$db = Hapyfish2_Db_Factory::getEventDB('db_0');
    	$rdb = $db['r'];
    	
    	return $rdb->fetchOne($sql, array('uid' => $uid));
    }
    
    public function addPayFlag($uid)
    {
    	$sql = "INSERT INTO $this->table_event_payflag_0328 (uid) VALUES (:uid)";
    	
		$db = Hapyfish2_Db_Factory::getEventDB('db_0');
        $wdb = $db['w'];
        
        $wdb->query($sql, array('uid' => $uid));
    }
    
    public function deletePayFlag($uid)
    {
		$sql = "DELETE FROM $this->table_event_payflag_0328 WHERE uid=:uid";
    	
		$db = Hapyfish2_Db_Factory::getEventDB('db_0');
        $wdb = $db['w'];
        
        $wdb->query($sql, array('uid' => $uid));
    }
    
    public function getPayDateFor($dateFor)
    {
		$sql = "SELECT pay_for FROM $this->table_event_pay_for WHERE idx=:idx";
    	
    	$db = Hapyfish2_Db_Factory::getEventDB('db_0');
    	$rdb = $db['r'];
    	
    	return $rdb->fetchOne($sql, array('idx' => $dateFor));
    }
    
    public function getPids($dateFor)
    {
		$sql = "SELECT pid FROM $this->table_event_item WHERE idx=:idx";
		
		$db = Hapyfish2_Db_Factory::getEventDB('db_0');
        $rdb = $db['r'];

        return $rdb->fetchCol($sql, array('idx' => $dateFor));
    }
    
}