<?php


class Hapyfish2_Island_Stat_Dal_Catchfish
{
    protected static $_instance;
    
    private $_tb = 'stat_catchfish';

    /**
     * Single Instance
     *
     * @return Hapyfish2_Island_Stat_Dal_Openisland
     */
    public static function getDefaultInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function insert($info)
    {
        $tbname = $this->_tb;

        $db = Hapyfish2_Db_FactoryStat::getStatLogDB();
        $wdb = $db['w'];

    	return $wdb->insert($tbname, $info);
    }
    public function update($day,$count)
    {
        $tbname = $this->_tb;

        $db = Hapyfish2_Db_FactoryStat::getStatLogDB();
        $wdb = $db['w'];
		$sql = 'UPDATE '.$tbname.' SET count=:count WHERE create_time=:date AND count=0';
    	return $wdb->query($sql, array('count'=>$count, 'date'=>$day));  
    }
    public function updateUserNum($day,$usernums)
    {
        $tbname = $this->_tb;

        $db = Hapyfish2_Db_FactoryStat::getStatLogDB();
        $wdb = $db['w'];
		$sql = 'UPDATE '.$tbname.' SET usernums=:usernums WHERE create_time=:date AND usernums=0';
    	return $wdb->query($sql, array('usernums'=>$usernums, 'date'=>$day));  
    }  
    public function updateCoin($day,$coin)
    {
        $tbname = $this->_tb;

        $db = Hapyfish2_Db_FactoryStat::getStatLogDB();
        $wdb = $db['w'];
		$sql = 'UPDATE '.$tbname.' SET coin=:coin WHERE create_time=:date AND coin=0';
    	return $wdb->query($sql, array('coin'=>$coin, 'date'=>$day));  
    }   
    public function updateIsland($day, $open_island1, $open_island2, $open_island3, $open_island4, $open_island5, $open_island6, $open_island7, $open_island8, $open_island9, $open_island10, $open_island11, $open_island12, $open_island13, $open_island14)
    {
        $tbname = $this->_tb;

        $db = Hapyfish2_Db_FactoryStat::getStatLogDB();
        $wdb = $db['w'];
		$sql = 'UPDATE '.$tbname.' SET open_island1=:open_island1,open_island2=:open_island2,open_island3=:open_island3,open_island4=:open_island4,open_island5=:open_island5,open_island6=:open_island6,open_island7=:open_island7,open_island8=:open_island8,open_island9=:open_island9,open_island10=:open_island10,open_island11=:open_island11,open_island12=:open_island12,open_island13=:open_island13,open_island14=:open_island14 WHERE create_time=:date';
    	return $wdb->query($sql, array('open_island1'=>$open_island1, 'open_island2'=>$open_island2, 'open_island3'=>$open_island3, 'open_island4'=>$open_island4, 'open_island5'=>$open_island5, 'open_island6'=>$open_island6, 'open_island7'=>$open_island7, 'open_island8'=>$open_island8, 'open_island9'=>$open_island9, 'open_island10'=>$open_island10, 'open_island11'=>$open_island11, 'open_island12'=>$open_island12, 'open_island13'=>$open_island13, 'open_island14'=>$open_island14, 'date'=>$day));
    } 
    public function updateCannon($day, $cannon1, $cannon2)
    {
        $tbname = $this->_tb;

        $db = Hapyfish2_Db_FactoryStat::getStatLogDB();
        $wdb = $db['w'];
		$sql = 'UPDATE '.$tbname.' SET cannon1=:cannon1,cannon2=:cannon2 WHERE create_time=:date';
    	return $wdb->query($sql, array('cannon1'=>$cannon1, 'cannon2'=>$cannon2, 'date'=>$day));  
    }  
    public function updateCard($day, $card)
    {
        $tbname = $this->_tb;

        $db = Hapyfish2_Db_FactoryStat::getStatLogDB();
        $wdb = $db['w'];
		$sql = 'UPDATE '.$tbname.' SET card=:card WHERE create_time=:date';
    	return $wdb->query($sql, array('card'=>$card, 'date'=>$day));  
    }

    public function insertMatchFish($info)
    {
    	$db = Hapyfish2_Db_FactoryStat::getStatLogDB();
    	$tbname = 'stat_matchfish';
        $wdb = $db['w'];
    	return $wdb->insert($tbname, $info); 
    }
    
    public function insertPve($info)
    {
    	$db = Hapyfish2_Db_FactoryStat::getStatLogDB();
    	$tbname = 'stat_matchfish';
        $wdb = $db['w'];
    	return $wdb->insert($tbname, $info);
    }
    
	public function incBrushCard($day, $num)
    {
		$tbname = $this->_tb;

        $db = Hapyfish2_Db_FactoryStat::getStatLogDB();
        $wdb = $db['w'];
		$sql = 'UPDATE '.$tbname.' SET brush_card=:brush_card WHERE create_time=:date';
    	$wdb->query($sql, array('brush_card' => $num, 'date' => $day));  
    } 
	
    public function incBrushNum($day, $num)
    {
		$tbname = $this->_tb;

        $db = Hapyfish2_Db_FactoryStat::getStatLogDB();
        $wdb = $db['w'];
		$sql = 'UPDATE '.$tbname.' SET brush_num=:brush_num WHERE create_time=:date';
    	$wdb->query($sql, array('brush_num' => $num, 'date' => $day));  
    }
    
    public function updateBrushIsland($day, $brush_island1, $brush_island2, $brush_island3, $brush_island4, $brush_island5, $brush_island6, $brush_island7, $brush_island8, $brush_island9, $brush_island10, $brush_island11, $brush_island12, $brush_island13, $brush_island14, $brush_island15)
    {
		$tbname = $this->_tb;

        $db = Hapyfish2_Db_FactoryStat::getStatLogDB();
        $wdb = $db['w'];
		$sql = 'UPDATE '.$tbname.' SET brush_island1=:brush_island1,brush_island2=:brush_island2,brush_island3=:brush_island3,brush_island4=:brush_island4,brush_island5=:brush_island5,brush_island6=:brush_island6,brush_island7=:brush_island7,brush_island8=:brush_island8,brush_island9=:brush_island9,brush_island10=:brush_island10,brush_island11=:brush_island11,brush_island12=:brush_island12,brush_island13=:brush_island13,brush_island14=:brush_island14,brush_island15=:brush_island15 WHERE create_time=:date';
    	$wdb->query($sql, array('brush_island1'=>$brush_island1, 'brush_island2'=>$brush_island2, 'brush_island3'=>$brush_island3, 'brush_island4'=>$brush_island4, 'brush_island5'=>$brush_island5, 'brush_island6'=>$brush_island6, 'brush_island7'=>$brush_island7, 'brush_island8'=>$brush_island8, 'brush_island9'=>$brush_island9, 'brush_island10'=>$brush_island10, 'brush_island11'=>$brush_island11, 'brush_island12'=>$brush_island12, 'brush_island13'=>$brush_island13, 'brush_island14'=>$open_island14, 'brush_island15'=>$open_island15, 'date'=>$day));
    }
    
}