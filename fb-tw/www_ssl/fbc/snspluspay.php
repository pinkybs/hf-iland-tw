<?php 
/**
 * Facebook Credit action 
 *
 * @author 林稘閎
 * @version $Id:snspluspay.php, v2.3 2011-06-08 21:42:00 Albert $
 * @package pay
 * @copyright 2011(C)Mymaji
 * 
 */
define("SITE_PATH"	,	str_ireplace('\\','/',dirname(__FILE__)));
define('SITE_URL'	,	'https://'.$_SERVER["HTTP_HOST"].str_ireplace(trim(strip_tags($_SERVER["DOCUMENT_ROOT"])),'',SITE_PATH));
define('ITEMPATH'   ,   'https://pay.snsplus.com/facebook_credit/');
require_once "config.inc.php";
require_once "pay-snsplus.php"; // albert 2011-03-11
	
$snspluspay = new snspluspay();
	
 switch($_GET['option']){
 	case 'getReady':
		$url = urldecode($_POST['url']);
		$point = $_POST['point'];
		$result = $snspluspay->getReadyResult($url,$point);
		//echo $url;
		echo $result; 		
 	break;
 	case 'getPage':
		$uid = $_REQUEST['fbcuid'];
		if($uid){
			$outputResult = $snspluspay->getPayUrl(GAME_CODING,$uid); //取得支付頁面URL
			$paymentUrl = $snspluspay->getPaymentUrl(GAME_CODING,$uid); //
			$exchangeResult = $snspluspay->getExcheangResult($outputResult); //取得匯率
			$value = json_decode(stripslashes($exchangeResult),true); //
			$value['payment_url'] = $paymentUrl;
		echo json_encode($value);
	}else{
		
		echo "request not allow";
	}
 	break;	
 	case 'getPayurl':
 		$uid = $_REQUEST['fbcuid'];
 		if($uid){
	 		$outputResult = $snspluspay->getPayUrl(GAME_CODING,$uid); //取得支付頁面URL
			$paymentUrl = $snspluspay->getPaymentUrl(GAME_CODING,$uid); //
			$exchangeResult = $snspluspay->getExcheangResult($outputResult); //取得匯率
			echo stripslashes($exchangeResult);
 		}else{
			
			echo "request not allow";
		}
	break;
 }

?>