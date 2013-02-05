<?php

class StaticsapiController extends Zend_Controller_Action
{
	function vaild()
	{

	}

    protected function echoResult($data)
    {
    	$data['errno'] = 0;
    	echo json_encode($data);
    	exit;
    }

    protected function echoError($errno, $errmsg)
    {
    	$result = array('errno' => $errno, 'errmsg' => $errmsg);
    	echo json_encode($result);
    	exit;
    }

    public function noopAction()
    {
    	$data = array('id' => SERVER_ID, 'time' => time(), 'method' => 'noop');
    	$this->echoResult($data);
    }

	public function uidlistAction()
	{
		$uidlist = Hapyfish2_Island_Bll_Statics::getUidList();
		$data = array('list' => $uidlist);

		$this->echoResult($data);
	}

	public function maxuidAction()
	{
		$maxuid = Hapyfish2_Island_Bll_Statics::getMaxUid();
		$data = array('maxuid' => $maxuid);
		$this->echoResult($data);
	}

	public function mainAction()
	{
		$day = $this->_request->getParam('day');
		if (empty($day)) {
			$day = date("Ymd", strtotime("-1 day"));
		}

		$log = Hapyfish2_Island_Stat_Bll_Day::getMain($day);
		$data = array('data' => $log);
		$this->echoResult($data);
	}

	public function retentionAction()
	{
		$day = $this->_request->getParam('day');
		if (empty($day)) {
			$day = date("Ymd", strtotime("-1 day"));
		}

		$log = Hapyfish2_Island_Stat_Bll_Day::getRetention($day);
		$data = array('data' => $log);
		$this->echoResult($data);
	}

	public function paymentofcalAction()
	{
		$day = $this->_request->getParam('day');
		if (empty($day)) {
			$day = date("Y-m-d", strtotime("-1 day"));
		}

		$log = Hapyfish2_Island_Stat_Bll_Payment::cal($day);
		$data = array('data' => $log);
		$this->echoResult($data);
	}

	public function paymentAction()
	{
		$day = $this->_request->getParam('day');
		if (empty($day)) {
			$day = date("Y-m-d", strtotime("-1 day"));
		}

		$log = Hapyfish2_Island_Stat_Bll_Day::getPayment($day);
		$data = array('data' => $log);
		$this->echoResult($data);
	}

	public function activeuserlevelAction()
	{
		$day = $this->_request->getParam('day');
		if (empty($day)) {
			$day = date("Ymd", strtotime("-1 day"));
		}

		$log = Hapyfish2_Island_Stat_Bll_Day::getActiveUserLevel($day);
		$data = array('data' => $log);
		$this->echoResult($data);
	}

	public function mainhourAction()
	{
		$day = $this->_request->getParam('day');
		if (empty($day)) {
			$day = date("Ymd", strtotime("-1 day"));
		}

		$log = Hapyfish2_Island_Stat_Bll_DayHour::getMain($day);
		$data = array('data' => $log);
		$this->echoResult($data);
	}

	public function propsaleAction()
	{
		$day1 = $this->_request->getParam('dtBegin');
		$day2 = $this->_request->getParam('dtEnd');
		if (empty($day1)) {
			$day1 = date("Ymd", strtotime("-2 day"));
		}
	    if (empty($day2)) {
			$day2 = date("Ymd", strtotime("-1 day"));
		}
		$cid = $this->_request->getParam('dtCid');
		$log = Hapyfish2_Island_Stat_Bll_Propsale::getData($day1, $day2, $cid);
		$data = array('data' => $log[0], 'total'=>$log[1]);
		$this->echoResult($data);
	}

    public function mainmonthAction()
    {
        $month = $this->_request->getParam('month');
        if (empty($month)) {
            $month = date("Ym", strtotime("-1 day"));
        }

        $log = Hapyfish2_Island_Stat_Log_Mainmonth::getMainMonth($month);
        $data = array('data' => $log);
        $this->echoResult($data);
    }

    public function tutorialAction()
    {
        $day = $this->_request->getParam('day');
        if (empty($day)) {
            $day = date("Ymd", strtotime("-1 day"));
        }

        $log = Hapyfish2_Island_Stat_Log_Tutorial::getDay($day);
        $data = array('data' => $log);
        $this->echoResult($data);
    }
    public function sendgoldAction()
    {
        $day = $this->_request->getParam('day');
        if (empty($day)) {
            $day = date("Ymd", strtotime("-1 day"));
        }

        $log = Hapyfish2_Island_Stat_Bll_Goldlog::getSendGoldLog($day);
        $data = array('data' => $log);
        $this->echoResult($data);
    }


    public function cloadtmdayAction()
	{
		$day = $this->_request->getParam('day');
		if (empty($day)) {
			$day = date("Ymd", strtotime("-1 day"));
		}

		$log = Hapyfish2_Island_Stat_Bll_DaycLoadTm::getDay($day);
		$data = array('data' => $log);
		$this->echoResult($data);
	}

    public function cloadtmAction()
	{
		$day1 = $this->_request->getParam('dtBegin');
		$day2 = $this->_request->getParam('dtEnd');
		if (empty($day1)) {
			$day1 = date("Ymd", strtotime("-2 day"));
		}
	    if (empty($day2)) {
			$day2 = date("Ymd", strtotime("-1 day"));
		}

		$log = Hapyfish2_Island_Stat_Bll_DaycLoadTm::listData($day1, $day2);
		$data = array('data' => $log);
		$this->echoResult($data);
	}
}