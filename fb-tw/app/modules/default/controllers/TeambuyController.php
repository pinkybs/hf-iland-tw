<?php

define('ADMIN_USERNAME','admin'); 					// Admin Username
define('ADMIN_PASSWORD','yewushuang_920');  	// Admin Password

class TeambuyController extends Zend_Controller_Action
{

	protected $_btl_key = 'bottle:list';

	public function init()
	{
		// http 401 验证
		if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
           $_SERVER['PHP_AUTH_USER'] != ADMIN_USERNAME ||$_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD) {
			Header("WWW-Authenticate: Basic realm=\"Who is god of wealth, Login\"");
			Header("HTTP/1.0 401 Unauthorized");

			echo <<<EOB
				<html><body>
				<h1>Rejected!</h1>
				<big>Wrong Username or Password!</big>
				</body></html>
EOB;
			exit;
		}

		$this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->staticUrl = STATIC_HOST;
        $this->view->hostUrl = HOST;
        $this->view->appId = APP_ID;
        $this->view->appKey = APP_KEY;
	}

	public function teambuyinfoAction()
	{
		$dalTeambuy = Hapyfish2_Island_Event_Dal_TeamBuy::getDefaultInstance();
		$info = $dalTeambuy->getTeamBuyMessage();

		$sexTin = explode('*', $info['gid']);
		$sex['cid'] = $sexTin[0];
		$sex['num'] = $sexTin[1];

		if($info['start_time']) {
			$start_time = date('Y-m-d H:i:s', $info['start_time']);
		} else {
			$start_time = '';
		}

		$join_time = $info['ok_time'];
		$buy_time = $info['buy_time'];

		$min_price_info = explode('*', $info['min_price']);
		if($min_price_info[1] == 1) {
			$min_price = $min_price_info[0] . '*金币';
		} else if($min_price_info[1] == 2) {
			$min_price = $min_price_info[0] . '*宝石';
		}

		$max_price_info = explode('*', $info['max_price']);
		if($max_price_info[1] == 1) {
			$max_price = $max_price_info[0] . '*金币';
		} else if($max_price_info[1] == 2) {
			$max_price = $max_price_info[0] . '*宝石';
		}

		$this->view->sex = $sex;
		$this->view->start_time = $start_time;
		$this->view->join_time = $join_time;
		$this->view->buy_time = $buy_time;
		$this->view->min_price = $min_price;
		$this->view->max_price = $max_price;
		$this->view->info = $info;
	}

	public function teambuyupdateAction()
	{
		$teambuy = $this->_request->getParams('teambuyinfo');

		$sex = $teambuy['teambuyinfo']['gid'] . '*' . $teambuy['teambuyinfo']['num'];
		$start_time = strtotime($teambuy['teambuyinfo']['start_time']);

		$max_price_info = explode('*', $teambuy['teambuyinfo']['max_price']);
		if($max_price_info[1] == '宝石') {
			$max_price_info[1] = 2;
		} else {
			$max_price_info[1] = 1;
		}
		$max_price = $max_price_info[0] . '*' . $max_price_info[1];

		$min_price_info = explode('*', $teambuy['teambuyinfo']['min_price']);
		if($min_price_info[1] == '宝石') {
			$min_price_info[1] = 2;
		} else {
			$min_price_info[1] = 1;
		}
		$min_price = $min_price_info[0] . '*' . $min_price_info[1];

		$info = array('gid' => $sex,
						'name' => $teambuy['teambuyinfo']['name'],
						'start_time' => $start_time,
						'ok_time' => $teambuy['teambuyinfo']['ok_time'],
						'buy_time' => $teambuy['teambuyinfo']['buy_time'],
						'max_price' => $max_price,
						'min_price' => $min_price,
						'min_num' => $teambuy['teambuyinfo']['min_num'],
						'max_num' => $teambuy['teambuyinfo']['max_num'],
						'start_num' => $teambuy['teambuyinfo']['start_num'],
						'bec_num' => $teambuy['teambuyinfo']['bec_num'],
						'bec_price' => $teambuy['teambuyinfo']['bec_price'],
						'scale_gold' => $teambuy['teambuyinfo']['scale_gold'],
						'scale_coin' => $teambuy['teambuyinfo']['scale_coin']);

		$dalTeamBuy = Hapyfish2_Island_Event_Dal_TeamBuy::getDefaultInstance();
		$dalTeamBuy->updateTeamBuyInfo($info);

		$key = 'i:e:teambuy:info';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->delete($key);

		$this->_redirect("teambuy/teambuyinfo");
	}

	public function clearteambuycacheAction()
	{
		$dalTeamBuy = Hapyfish2_Island_Event_Dal_TeamBuy::getDefaultInstance();
    	$users = $dalTeamBuy->getHasJoinTeamBuyUser();

    	if($users) {
	    	foreach ($users as $uid) {
		    	$key = 'i:e:teambuy:buygood:' . $uid;
				$cache = Hapyfish2_Cache_Factory::getMC($uid);
				$cache->delete($key);

				$dalTeamBuy->clearOneUser($uid);
	    	}
    	}

		$this->_redirect("teambuy/teambuyinfo");
	}

	public function teambuyswitchAction()
	{
		$teambuyMessage = $this->_request->getParams('teambuyswitch');

		$dalTeambuy = Hapyfish2_Island_Event_Dal_TeamBuy::getDefaultInstance();
		$dalTeambuy->switchTeamBuy($teambuyMessage['teambuyswitch']);

		$key = 'i:e:teambuy:info';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->delete($key);

		$this->_redirect("teambuy/teambuyinfo");
	}

	public function teambuyswitchoneAction()
	{
		$message = $this->_request->getParams('uids');

		$tids = array(1, 2);

		if(!in_array($message['teambuyswitchone']['tid'], $tids)) {
			return false;
		}

		if($message['teambuyswitchone']['tid'] == 1) {
			if($message['teambuyswitchone']['uids']) {
				$uids = explode(',', $message['teambuyswitchone']['uids']);

				Hapyfish2_Island_Event_Bll_TeamBuy::setOpenUID($uids);
			}
		} else {
			Hapyfish2_Island_Event_Bll_TeamBuy::deleteOpenUID();
		}

		$this->_redirect("teambuy/teambuyinfo");
	}

	/**********万圣节活动接口************/
	//清理卡牌信息
	public function clear1Action()
	{
		$key = 'ev:hall:card';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->delete($key);

		echo 'OK';
		exit;
	}

	//清理兑换物品列表
	public function clear2Action()
	{
		$key = 'ev:hall:gift';
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->delete($key);

		echo 'OK';
		exit;
	}

	//清理用户卡牌信息缓存
	public function clear3Action()
	{
		$uid = $this->_request->getParam('uid');

		$key = 'ev:hall:card:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->delete($key);

		echo 'OK';
		exit;
	}

	//清理用户倒计时
	public function clear4Action()
	{
		$uid = $this->_request->getParam('uid');

		$key = 'ev:hall:time:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$cache->delete($key);

		echo 'OK';
		exit;
	}

	//给用户增加卡片
	public function clear5Action()
	{
		$uid = $this->_request->getParam('uid');
		$cid = $this->_request->getParam('cid');
		$num = $this->_request->getParam('num');

		$key = 'ev:hall:card:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$card = $cache->get($key);

		foreach ($card as $cdkey => $cdva) {
			if ($cid == $cdkey) {
				$card[$cdkey] = $num;
				break;
			}
		}

		$cache->set($key, $card, 3600 * 24 * 15);

		foreach ($card as $cardkey => $cardva) {
			$data[] = $cardkey . '*' . $cardva;
		}

		$list = implode(',', $data);

		try {
			$db = Hapyfish2_Island_Event_Dal_HallWitches::getDefaultInstance();
			$db->incCard($uid, $list);
		} catch (Exception $e) {}

		echo 'OK';
		exit;
	}
	/**********万圣节活动接口************/

	/***************宝箱后台***************/
	public function indexAction()
	{
		$list = array();
		$list = Hapyfish2_Island_Cache_Hash::get($this->_btl_key);
		$list = unserialize($list);
		$list = is_array($list) ? $list : array(); 

		$this->view->list = $list;
	}
	
	// 增加一个寻宝季
	public function addbottleoneAction()
	{
		$list = array();
		$list = Hapyfish2_Island_Cache_Hash::get($this->_btl_key);
		$list = unserialize($list);
		$list = is_array($list) ? $list : array(); 
		$count = count($list);
		
		$list[$count] = array('name'=>"寻宝第1季", 'tips'=>"寻宝第1季", 'online'=>false, 'qid'=>'1'); 
		$list = Hapyfish2_Island_Cache_Hash::set($this->_btl_key, serialize($list));
		
		Hapyfish2_Island_Cache_Bottle::initRows($count, 20);
		
		echo $count;
		exit();
	}
	
	public function editbottleAction()
	{
		$id = $this->_request->getParam('id');
		$erron=-1;
		
		if (empty($id) && $id !== '0') {
			$erron = 1;
		}
		
		if ($this->_request->isPost()) {
			if ($erron == -1) {
				$online = $this->_request->getParam('online');
				$online = empty($online) ? false : true;
				$name = $this->_request->getParam('name');
				$tips = $this->_request->getParam('tips');
				$qid = $this->_request->getParam('qid');
				
				$btl_ids = $this->_request->getParam('btl_ids');
				$btl_name = $this->_request->getParam('btl_name');
				$btl_tips = $this->_request->getParam('btl_tips');
				$btl_type = $this->_request->getParam('btl_type');
				$btl_itemids = $this->_request->getParam('btl_itemids');
				$btl_num = $this->_request->getParam('btl_num');
				$btl_odds = $this->_request->getParam('btl_odds');
				$btl_coin = $this->_request->getParam('btl_coin');
				$btl_gold = $this->_request->getParam('btl_gold');
				$btl_starfish = $this->_request->getParam('btl_starfish');
				
				$list = Hapyfish2_Island_Cache_Hash::get($this->_btl_key);
				$list = unserialize($list);
				$list[$id]['online'] = $online;
				$list[$id]['name'] = $name;
				$list[$id]['tips'] = $tips;
				$list[$id]['qid'] = $qid;
				$list = serialize($list);
				
				Hapyfish2_Island_Cache_Hash::set($this->_btl_key, $list);
				
				$a = $b = 0;
				
				foreach ($btl_ids as $key => $val) {
					$info = array('btl_name'=>$btl_name[$key], 'btl_tips'=>$btl_tips[$key],
					'type'=>$btl_type[$key], 'coin'=>$btl_coin[$key], 'gold'=>$btl_gold[$key],
					'item_id'=>$btl_itemids[$key], 'odds'=>$btl_odds[$key], 'num'=>$btl_num[$key],
					'starfish'=>$btl_starfish[$key]);
					
					Hapyfish2_Island_Cache_Bottle::update($btl_ids[$key], $id, $info);
				}
			}	
		}
		
		$list = Hapyfish2_Island_Cache_Hash::get($this->_btl_key);
		$list = unserialize($list);
		$info = $list[$id];
		
		$this->view->info = $info;
		
		$list = Hapyfish2_Island_Cache_Bottle::getAllByBottleId($id);
		$this->view->list = $list['list'];

		$this->view->id = $id;
		$this->view->erron = $erron;
	}

	// 给玩家发送钥匙
    public function sendcardtouserAction()
    {
    	$uid = $this->_request->getParam('uid');
    	if ($uid) {
    		$com = new Hapyfish2_Island_Bll_Compensation();
	    	$com->setItem('86241', 10);
	    	$com->sendOne($uid,'');
	    	echo 'ok';
    	} else {
    		echo 'no';
    	}
    	exit();
    }
    
    // 清除今天领奖缓存
    public function clearbottletodaytfAction()
    {
    	$uid = $this->_request->getParam('uid');
    	if ($uid) {
    		$key = 'bottle:todaytf:' . $uid;
			$cache = Hapyfish2_Cache_Factory::getMC($uid);
			$cache->delete($key);
			echo 'ok';
    	} else {
    		echo 'no';
    	}
    	
		exit();
    }
    
    // 重置掉宝箱缓存
    public function reloadbottleallAction()
   	{
   		$btl_id = $this->_request->getParam('btl_id');
   		if ($btl_id) {
   			$hashkey = 'bottle:list';
			Hapyfish2_Island_Cache_Hash::reloadVal($hashkey);
			Hapyfish2_Island_Cache_Bottle::reloadAllByBottleId($btl_id);
			echo 'ok';
   		} else {
   			echo 'no';
   		}
   		
		exit();
    }

    
    private function _prerand($items, $num)
    {
    	$temp = array();
    	
    	for ($i=0; $i<$num; $i++) {
    		$rand = rand ($items['interval'][0]['a'], $items['interval'][19]['b']);
    		
    		foreach ($items['interval'] as $key => $val) {
				if ($val['a'] <= $rand && $rand < $val['b']) {
					$temp[] = $val['id'];
					break;
				}
			}
    	}
    	
    	return $temp;
    }
    
    // 转多少个十次，可以把6个物品集齐
   	public function precomputed10Action()
   	{
   		$btl_id = $this->_request->getParam('btl_id', 0);			// 第几季
   		$ids = $this->_request->getParam('ids', '8,9,13,14,17,18');	// 监控的物品
   		$ids = explode(',', $ids);
   		
   		if ($btl_id || $btl_id == 0) {
   			
   			// 获得季，物品
   			$items = Hapyfish2_Island_Cache_Bottle::getAllByBottleId($btl_id);
   			$sum = 0;
   			
   			for ($i=0; $i<1000; $i++) {
	   			$hash = array();
	   			$total = 0;
	   			while (true) {
	   				$total++;
	   			
		   			$randlist = $this->_prerand($items, 10);
		   			
		   			foreach ($randlist as $key => $val) {
		   				if (isset($hash)) {
		   					$hash[$val]++;
		   				} else {
		   					$hash[$val] = 1;
		   				}
		   			}
		   			
		   			$tf = true;
		   			foreach ($ids as $ikey => $ival) {
		   				if (empty($hash[$ival])) {
		   					$tf = false;
		   				}
		   			}
		   			
		   			if ($tf) 
		   				break;
	   			}
	   			
	   			$sum = $sum + $total;
   			}
   			
   			echo $sum / 1000;
   			
   			Zend_Debug::dump($hash);
   			$this->view->values = $items;
   		}
   		exit();
   	}
   	
   	public function precomputed1Action()
   	{
   		$btl_id = $this->_request->getParam('btl_id', 0);			// 第几季
   		$ids = $this->_request->getParam('ids', '8,9,13,14,17,18');	// 监控的物品
   		$ids = explode(',', $ids);
   		
   		if ($btl_id || $btl_id == 0) {
   			// 获得季，物品
   			$items = Hapyfish2_Island_Cache_Bottle::getAllByBottleId($btl_id);
			
   			$sum = 0;
   			
   			for ($i=0; $i<1000; $i++) {
	   			$hash = array();
	   			$total = 0;
	   			while (true) {
	   				$total++;
	   			
		   			$randlist = $this->_prerand($items, 1);
		   			
		   			foreach ($randlist as $key => $val) {
		   				if (isset($hash)) {
		   					$hash[$val]++;
		   				} else {
		   					$hash[$val] = 1;
		   				}
		   			}
		   			
		   			$tf = true;
		   			foreach ($ids as $ikey => $ival) {
		   				if (empty($hash[$ival])) {
		   					$tf = false;
		   				}
		   			}
		   			
		   			if ($tf) 
		   				break;
	   			}
	   			$sum = $sum + $total;
   			}
   			
   			echo $sum / 1000;

   			Zend_Debug::dump($hash);
   			$this->view->values = $items;
   		}
   		exit();	
   	}
   	 	
   	public function reloadbtlAction()
   	{
   		$btl_id = $this->_request->getParam('btl_id');
   		
   		Zend_Debug::dump(Hapyfish2_Island_Cache_Bottle::reloadAllByBottleId($btl_id));
   		
   		exit();
   	}
   	
   	public function getuserinfoAction()
   	{
   		$uid = $this->_request->getParam('uid');
   		
   		$user = Hapyfish2_Platform_Bll_User::getUser($uid);
   		
   		Zend_Debug::dump($user);
   		
   		exit();
   	}
   	
   	public function getqueueAction()
   	{
   		Hapyfish2_Island_Cache_BottleQueue::getall();
   	}
	
   	public function clearqueueAction()
   	{
   		Zend_Debug::dump(Hapyfish2_Island_Cache_BottleQueue::clear());
   		exit();
   	}
	/***************宝箱后台***************/
   	/***************收集后台***************/
	public function collectlistAction()
	{

		$key = 'collectgift';
		$jianglikey = 'jiangliid';
		$timekey = 'time';
		$xiaoxikey = 'xiaoxi';

		$val = Hapyfish2_Island_Event_Bll_Hash::getval($key);
		$jianglival = Hapyfish2_Island_Event_Bll_Hash::getval($jianglikey);
		$time = Hapyfish2_Island_Event_Bll_Hash::getval($timekey);
		$message = Hapyfish2_Island_Event_Bll_Hash::getval($xiaoxikey);

		$keyswitch = "collectcontrolswitch";
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$switch = $cache->get($keyswitch);

		if($switch['uid']) {
			$this->view->switchuid = $switch['uid'];
		}

		if( $val ) {
			$list = unserialize($val);
			$this->view->list = $list;
		}

		if( $jianglival ) {
			$this->view->jiangli_id = $jianglival;
		}

		if($time) {
			$time = unserialize( $time );
			$time['start'] = date('Y-m-d H:i:s',$time['start']);
			$time['end'] = date('Y-m-d H:i:s',$time['end']);
		    $this->view->time = $time;
		}

		if($message) {
		    $this->view->message = unserialize( $message );
		}
	}

	public function collectlistdoAction()
	{
		$key = 'collectgift';
		$jianglikey = 'jiangliid';
		$timekey = 'time';
		$xiaoxikey = 'xiaoxi';

		$names = $this->_request->getParam('names');
		$cids = $this->_request->getParam('cids');
		$tips = $this->_request->getParam('tips');
		$time['start'] = $this->_request->getParam('start');
		$time['end'] = $this->_request->getParam('end');
		$message['tishi'] = $this->_request->getParam('tishi');
		$message['zhu'] = $this->_request->getParam('zhu');
		$jiangli_id = $this->_request->getParam('jiangli_id');

		$time['start'] = $time['start'] ? strtotime($time['start']) : strtotime('now');
		$time['end'] = strtotime($time['end']);

		$arr = array();
		foreach( $names as $k => $v ) {
			$arr[] = array('name'=>$names[$k], 'cid'=>$cids[$k], 'tip'=>$tips[$k]);
		}
		if( $arr ) {
			Hapyfish2_Island_Event_Bll_Hash::setval($key, serialize($arr));
		}
		if( $jiangli_id ) {
			Hapyfish2_Island_Event_Bll_Hash::setval($jianglikey, $jiangli_id);
		}
		if($time){
		   Hapyfish2_Island_Event_Bll_Hash::setval($timekey, serialize($time));
		}
		if($message){
		    Hapyfish2_Island_Event_Bll_Hash::setval($xiaoxikey, serialize($message));
		}

		$this->_redirect("teambuy/collectlist");
	}

	public function controlswitchAction()
	{
		$uids = $this->_request->getParam('uids');
		$type = $this->_request->getParam('type');

		$result = array();
		$result['type'] = $type;
		$result['uid'] = $uids;

		$key = "collectcontrolswitch";
		$cache = Hapyfish2_Cache_Factory::getBasicMC('mc_0');
		$cache->set($key,$result);

		$this->_redirect("teambuy/collectlist");
	}

	public function clearcollectAction()
	{
		Hapyfish2_Island_Event_Bll_Hash::clearall();
		$this->_redirect("teambuy/collectlist");
	}
	/***************收集后台***************/
	
	public function addcoinAction()
	{
		$uid = $this->_request->getParam('uid');
		$coin = $this->_request->getParam('coin');
		if (empty($coin) || $coin <= 0) {
			echo 'add coin error, must > 1';
			exit;
		}

		Hapyfish2_Island_HFC_User::incUserCoin($uid, $coin);

		echo 'OK';
		exit;
	}

	public function addgoldAction()
	{
		$uid = $this->_request->getParam('uid');
		$gold = $this->_request->getParam('gold');
		if (empty($gold) || $gold <= 0) {
			echo 'add gold error, must > 1';
			exit;
		}

		$goldInfo = array(
			'uid' => $uid,
			'gold' => $gold,
			'type' => 0
		);
		Hapyfish2_Island_Bll_Gold::add($uid, $goldInfo);

		echo 'OK';
		exit;
	}

	public function addstarfishAction()
	{
		$uid = $this->_request->getParam('uid');
		$starfish = $this->_request->getParam('starfish');
		if (empty($starfish) || $starfish <= 0) {
			echo 'add starfish error, must > 1';
			exit;
		}

		Hapyfish2_Island_HFC_User::incUserStarFish($uid, $starfish);

		echo 'OK';
		exit;
	}
	
	public function addexpAction()
	{
		$uid = $this->_request->getParam('uid');
		$exp = $this->_request->getParam('exp');
		if (empty($exp) || $exp <= 0) {
			echo 'add exp error, must > 1';
			exit;
		}

		Hapyfish2_Island_HFC_User::incUserExp($uid, $exp);

		echo 'OK';
		exit;
	}
	
	public function tosendgiftAction()
	{
		$uid = $this->_request->getParam('uid');
		$cid = $this->_request->getParam('cid');
		$num = $this->_request->getParam('num');
		
		$ok = Hapyfish2_Island_Bll_GiftPackage::addGift($uid, $cid, $num);
		
		echo $ok ? 'OK' : 'NOT';
		exit;
	}
	
	public function addlovethdayAction()
	{
		$uid = $this->_request->getParam('uid');
		$num = $this->_request->getParam('num');
		
		$key = 'ev:thday:love:' . $uid;
		$cache = Hapyfish2_Cache_Factory::getMC($uid);
		$data = $cache->get($key);

		$data += $num;
		$cache->set($key, $data, 2592000);
		
		$feed = '補發：' . $num . '愛心';
		
        $minifeed = array('uid' => $uid,
                          'template_id' => 0,
                          'actor' => $uid,
                          'target' => $uid,
                          'title' => array('title' => $feed),
                          'type' => 6,
                          'create_time' => time());
        Hapyfish2_Island_Bll_Feed::insertMiniFeed($minifeed);
        
        echo 'OK';
        exit;
	}
}