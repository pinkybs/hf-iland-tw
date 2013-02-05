<?php 
/**
 * Facebook Credit snspluspay class 
 *
 * @author 林稘閎
 * @version $Id:snspluspay.php, v2.3 2011-06-08 21:42:00 Albert $
 * @package pay
 * @copyright 2011(C)Mymaji
 * 
 */
	class snspluspay{
		
		private $url;
		private $apiurl;
		private $game_coding;
		private $platform;
		private $uid;
		
		public function __construct(){
			
			$this->url = RATE_URL;
			$this->apiurl = API_URL;
			$this->platform = 'Facebook';
			
		}
		
		public function getRequestUrl($game_coding,$uid){
			
			$requestUrl = $this->url.'?game_coding='.$game_coding.'&uid='.$uid.'&platform='.$this->platform;
			
			return $requestUrl;
		}
		
		public function getPaymentUrl($game_coding,$uid){
			
			$requestUrl = $this->_curl($this->apiurl.'?game_coding='.$game_coding.'&uid='.$uid.'&platform='.$this->platform);
			
			return $requestUrl;
		}
		
		public function getPayUrl($gcod,$uid){
			
			
			$postObj = array('url'	=> $this->url,
							'game_coding'	=>	$gcod,
							'platform'	=> 	$this->platform,
							'uid'			=>	$uid);
			
			$result = $this->_curl($this->url,$postObj);
			
			$url = $this->_curl($result);
			
			if(!$url){
				return false;
			}else{
				return $url;
			}
		}
		
		public function getReadyResult($url,$point){
			$postObj = array('point' => $point);
			
			$result = $this->_curl($url,$postObj);
			
			return $result;
		}
		
		public function getExcheangResult($url){
			
			$result = $this->_curl($url);
			
			return $result;
		}
		
		private function _curl($url,$post_string = ''){
			
			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POST, 1);
            if(!empty($post_string))
          	  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 600);
            
            $result = curl_exec($ch);
            curl_close($ch);
            
            return $result;
			
		} 
		
		
	}
?>