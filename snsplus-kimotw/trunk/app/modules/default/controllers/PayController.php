<?php

class PayController extends Zend_Controller_Action
{
    protected $uid;

    protected $info;

    public function init()
    {
    	$info = $this->vailid();
        if (!$info) {
            echo '<html><body><script type="text/javascript">window.top.location="http://tw.socialgame.yahoo.net/userapp/userapp.php?appid='.APP_ID.'";</script></body></html>';
            exit;
        }

        $this->info = $info;
        $this->uid = $info['uid'];
        $data = array('uid' => $info['uid'], 'puid' => $info['puid'], 'session_key' => $info['session_key']);
        $context = Hapyfish2_Util_Context::getDefaultInstance();
        $context->setData($data);

        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->staticUrl = STATIC_HOST;
        $this->view->hostUrl = HOST;
        $this->view->appId = APP_ID;
        $this->view->appKey = APP_KEY;
        $this->view->uid = $info['uid'];
        $this->view->platformUid = $info['puid'];
    }

	protected function vailid()
    {
    	$skey = $_COOKIE['hf_skey'];
    	if (!$skey) {
    		return false;
    	}

    	$tmp = explode('.', $skey);
    	if (empty($tmp)) {
    		return false;
    	}
    	$count = count($tmp);
    	if ($count != 5 && $count != 6) {
    		return false;
    	}

        $uid = $tmp[0];
        $puid = $tmp[1];
        $session_key = base64_decode($tmp[2]);
        $t = $tmp[3];

        $rnd = -1;
        if ($count == 5) {
        	$sig = $tmp[4];
	        $vsig = md5($uid . $puid . $session_key . $t . APP_KEY);
	        if ($sig != $vsig) {
	        	return false;
	        }
        } else if ($count == 6) {
        	$rnd = $tmp[4];
        	$sig = $tmp[5];
        	$vsig = md5($uid . $puid . $session_key . $t . $rnd . APP_KEY);
        	if ($sig != $vsig) {
	        	return false;
	        }
        }

        //max long time one day
        if (time() > $t + 86400) {
        	return false;
        }

        return array('uid' => $uid, 'puid' => $puid, 'session_key' => $session_key,  't' => $t, 'rnd' => $rnd);
    }

	public function topAction()
	{
        $uid = $this->uid;
		$user = Hapyfish2_Platform_Bll_User::getUser($uid);
		$user['face'] = $user['figureurl'];
		$user['gold'] = Hapyfish2_Island_HFC_User::getUserGold($uid);

		$this->view->user = $user;
		$this->render();
	}

    public function payAction()
    {
		$rest = Snsplus_RestApi::getInstance(false);
		$rest->setUser($this->info['puid'], $this->info['session_key']);
		$isTest = (APP_ID == 676) ? 0 : 1;
		$paymenturl = $rest->getPaymentUrl('AISSAD', $isTest);
        /*
        $limit_uids = array('579418666',
                            '1177325294',
                            '1640183732',
                            '100000271335713',
                            '1526002634',
                            '1095877457',
                            '817308554',
                            '100000138260101',
                            '766589061',
                            '573648228',
                            '1018066459',
                            '1174038253',
                            '564138216',
                            '100000100757344',
                            '1496300630',
                            '100000189996355',
                            '1849555388',
                            '1806655922',
                            '100000718267940',
                            '541289768',
                            '100000490156245',
                            '100001052452664',
                            '100000212739414',
                            '100000428600337',
                            '100000075313234',
                            '703824034',
                            '905790458');

        if (in_array($application->getUserId(), $limit_uids)) {
            $this->view->html = "<iframe src='$url'  height='1100' width='750' name='pay_page' frameborder='0'></iframe>";
        }*/

		if ($paymenturl) {
		    $this->view->html = "<iframe src='$paymenturl' height='1100' width='750' name='pay_page' frameborder='0'></iframe>";
		}
		else {
		    $this->view->html = 'sth. Error, Please reload.';
		}

		$this->render();
    }

    public function logAction()
    {
		$uid = $this->uid;
		$user = Hapyfish2_Platform_Bll_User::getUser($uid);
		$user['face'] = $user['figureurl'];
		$user['gold'] = Hapyfish2_Island_HFC_User::getUserGold($uid);

    	$logs = Hapyfish2_Island_Bll_PaymentLog::getPayment($uid, 50);
    	if (!$logs) {
    		$count = 0;
    		$logs = '[]';
    	} else {
    		$count = count($logs);
    		$logs = json_encode($logs);
    	}
    	$pageSize = 25;
    	$this->view->user = $user;
		$this->view->logs = $logs;
        $this->view->count = $count;
        $this->view->pageSize = 25;
        $this->view->pageNum = ceil($count/$pageSize);
        $this->render();
    }
}