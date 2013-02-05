<?php
class Snsplus_Rest_Client {
    const NS = 'mj_sig';
    const JSON = 'json';
    const XML = 'xml';
    const CONNECT_TIMEOUT = 4;
    const TIMEOUT = 4;
    const DNS_CACHE_TIMEOUT = 600;

    private $api_key;
    private $secret;
    private $server_addr;
    private $last_call_id;
    private $auth_token;
    private $format = "json";
    private $domain = "snsplus";
    private $compress = true;
    private $fileUpload = false;
    private $platform;

    public function __construct($api_key, $secret) {
        $this->api_key = $api_key;
        $this->secret = $secret;
    }

    /**
     * 設置SERVER_ADDR
     */
    public function set_server_addr($server_addr) {
        $this->server_addr = (string)$server_addr;
        return $this;
    }

    /**
     * 獲得用戶訊息
     */
    public function user_getInfo($uid = null, $fields = null, $usecache = true) {
        $params = array();
        if(! empty($fields)){
            $params['fields'] = $fields;
        }
        if(! empty($uid)){
            $params['uid'] = $uid;
        }
        $params['usecache'] = (int)$usecache;
        return $this->call_method("user.getInfo", $params);
    }

    /**
     * 批量獲得用戶訊息
     */
    public function user_getBatchInfo($uids, $fields = null, $usecache = true) {
        $params = array();
        if(! empty($fields)){
            $params['fields'] = $fields;
        }
        $params['uids'] = $uids;
        $params['usecache'] = (int)$usecache;
        return $this->call_method("user.getBatchInfo", $params);
    }

    /**
     * 獲得好友訊息
     */
    public function user_getProfile($fields = null, $usecache = true) {
        $params = array();
        if(! empty($fields)){
            $params['fields'] = $fields;
        }
        $params['usecache'] = (int)$usecache;
        return $this->call_method("user.getProfile", $params);
    }

    /**
     * 獲得當前登入用戶ID
     *
     */
    public function user_getLoggedInUser() {
        return $this->call_method("user.getLoggedInUser");
    }

    /**
     * 获取用户在平台的uid
     *
     * @return unknown
     */
    public function user_getPlatformUser() {
        return $this->call_method("user.getPlatformUser");
    }

    /**
     * 根据传递的snsplus uids获取平台uids,多个uid之间用逗号分隔
     *
     * @return array
     */
    public function user_getPlatformUsers($uids) {
        $params = array();
        $params['uids'] = $uids;
        return $this->call_method("user.getPlatformUsers", $params);
    }

    /**
     * 根据传递的平台uids获取snsplus uids,多个uid之间用逗号分隔
     *
     * @return array
     */
    public function user_getUsers($uids) {
        $params = array();
        $params['uids'] = $uids;
        return $this->call_method("user.getUsers", $params);
    }

    /**
     * 获取支付URL地址
     *
     * @param string $game_coding
     * @param int $testing
     * @return string
     */
    public function user_getPaymentUrl($game_coding = null, $testing = 0) {
        $params = array();
        if(! is_null($game_coding)){
            $params['game_coding'] = (string)$game_coding;
        }
        $params['testing'] = (int)$testing;

        return $this->call_method("user.getPaymentUrl", $params);
    }
    /**
     * 获取App Requests
     * @param String $id
     */
    public function user_getAppRequests($id = null) {
        $params = array();
        if($id){
            $params['id'] = $id;
        }
        return $this->call_method("user.getAppRequests", $params);
    }
    /**
     * 移除App Request
     * @param String $id
     */
    public function user_removeAppRequest($id) {
        $params = array();
        $params['id'] = $id;
        return $this->call_method("user.removeAppRequest", $params);
    }
    /**
     * 返回好友列表
     *
     */
    public function friends_get($usecache = true) {
        $params = array();
        $params['usecache'] = (int)$usecache;
        return $this->call_method("friends.get", $params);
    }

    /**
     * 返回好友列表
     *
     */
    public function friends_getAppUsers($usecache = true) {
        $params = array();
        $params['usecache'] = (int)$usecache;
        return $this->call_method("friends.getAppUsers", $params);
    }

    /**
     * 返回未安裝該應用的好友列有
     * @param boolean $usecache
     */
    public function friends_getUnAppUsers($usecache = true) {
        $params = array();
        $params['usecache'] = (int)$usecache;
        return $this->call_method("friends.getUnAppUsers", $params);
    }

    /**
     *
     * 好友召回
     * @param int $days 定義召回多少天之前的好友
     * @param string $calllink 定義召回鏈接地址
     * @param int $recallnums 已經成功召回數量
     * @param string $rewardurl 領獎地址
     * @param string $content 發送給好友的內容， 不支持html
     * @param boolean $usecache 是否使用緩存
     */
    public function friends_call($days, $calllink, $recallnums, $rewardurl, $content, $extend_params = array(), $usecache = true) {
        $params = array();
        $params['days'] = $days;
        $params['calllink'] = $calllink;
        $params['recallnums'] = $recallnums;
        $params['rewardurl'] = $rewardurl;
        $params['content'] = $content;
        $params['usecache'] = (int)$usecache;

        if(is_array($extend_params) && count($extend_params)){
            $params['extend_params'] = $extend_params;
        }
        return $this->call_method("friends.call", $params);
    }

    /**
     * 发布通知
     *
     * @param string $message
     * @param int $uid
     * @return int
     */
    public function notification_send($message, $title = null, $uid = null) {
        $params = array();
        $params['message'] = $message;
        if(! empty($title)){
            $params['title'] = $title;
        }
        if(! empty($uid)){
            $params['uid'] = $uid;
        }
        return $this->call_method("notification.send", $params);
    }

    /**
     * 发送Email给特定用户
     * @param String $subject
     * @param String $content
     * @param String $uids 多个用户之间用逗号分隔
     * @param Array $extend_params
     */
    public function notification_sendMail($subject, $content, $uids, $extend_params = array()) {
        $params = array();
        $params['subject'] = $subject;
        $params['content'] = $content;
        $params['uids'] = $uids;
        if(is_array($extend_params) && count($extend_params)){
            $params['extend_params'] = $extend_params;
        }
        return $this->call_method("notification.sendMail", $params);
    }

    /**
     * 获取所有的通知列表
     * @param Array $args
     */
    public function notification_getList($args = array()) {
        $params = array();
        if(is_array($args) && count($args)){
            $params['args'] = $args;
        }
        return $this->call_method("notification.getList", $params);
    }

    /**
     *
     * 标记一个或多个Notification为已读
     * @param String $notification_ids
     */
    public function notification_markRead($notification_ids) {
        $params = array();
        $params['notification_ids'] = $notification_ids;
        return $this->call_method("notification.markRead", $params);
    }

    /**
     * 发布动态
     *
     * @param string $message
     * @param string $name
     * @param string $link
     * @param string $caption
     * @param string $description
     * @param string $picture
     * @param int $uid
     * @return int
     */
    public function feed_publish($message, $name = null, $link = null, $caption = null, $description = null, $picture = null, $uid = null) {
        $params = array();
        $params['message'] = $message;
        if(! is_null($name)){
            $params['name'] = $name;
        }
        if(! is_null($link)){
            $params['link'] = $link;
        }
        if(! is_null($caption)){
            $params['caption'] = $caption;
        }
        if(! is_null($description)){
            $params['description'] = $description;
        }
        if(! is_null($picture)){
            $params['picture'] = $picture;
        }
        if(! is_null($uid)){
            $params['uid'] = $uid;
        }
        return $this->call_method("feed.publish", $params);
    }

    /**
     * 獲取SNSPlus平台支持那些接口
     */
    public function implementation_getSupportedApis() {
        return $this->call_method("implementation.getSupportedApis");
    }

    /**
     * 攻取平台名稱
     *
     * @return string
     */
    public function platform_getName() {
        return $this->call_method("platform.getName");
    }

    /**
     * 獲取特定平台的應用URL地址
     *
     * @return string
     */
    public function platform_getApplicationUrl() {
        return $this->call_method('platform.getApplicationUrl');
    }

    /**
     * 獲取平台Javascript
     *
     * @return string
     */
    public function platform_getScript($include_jquery = true) {
        $params = array();
        if($include_jquery){
            $params['include_jquery'] = $include_jquery;
        }
        return $this->call_method("platform.getScript", $params);
    }

    /**
     * 判斷是否支持好友选择
     */
    public function platform_isSupportInviteFriendSelector() {
        return $this->call_method("platform.isSupportInviteFriendSelector");
    }

    /**
     * 獲取好友選擇代碼
     */
    public function platform_getInviteFriendSelector($title, $content, $action, $extend_params = array()) {
        $params = array();
        $params['title'] = $title;
        $params['content'] = $content;
        $params['action'] = $action;
        $params['extend_params'] = $extend_params;
        return $this->call_method("platform.getInviteFriendSelector", $params);
    }

    /**
     * 判斷是否支持贈送禮物好友选择器
     */
    public function platform_isSupportGiftPresentFriendSelector() {
        return $this->call_method("platform.isSupportGiftPresentFriendSelector");
    }

    /**
     * 獲取贈送禮物好友选择器代碼
     */
    public function platform_getGiftPresentFriendSelector($title, $content, $action, $extend_params = array()) {
        $params = array();
        $params['title'] = $title;
        $params['content'] = $content;
        $params['action'] = $action;
        $params['extend_params'] = $extend_params;
        return $this->call_method("platform.getGiftPresentFriendSelector", $params);
    }

    /**
     * 外部好友邀請功能
     */
    public function platform_inviteExternalFriends($options = array()) {
        $params = array();
        $params['options'] = $options;
        return $this->call_method("platform.inviteExternalFriends", $params);
    }

    /**
     *
     * QQ平台分享功能
     * @param string $shareType  space:分享到QQ空间, pengyou:分享到朋友社区
     * @param unknown_type $buttonType  0.文字, 1.小按鈕, 2.大按鈕
     * @param unknown_type $text
     */
    public function platform_share($shareType, $buttonType, $title, $shareurl = null) {
        $params = array();
        if(in_array($shareType, array('space', 'pengyou'))){
            $params['sharetype'] = $shareType;
        }
        if(is_numeric($buttonType) && in_array($buttonType, array(0, 1, 2))){
            $params['buttontype'] = intval($buttonType);
        }
        if(! empty($title) && is_string($title)){
            $params['title'] = $title;
        }
        if(! is_null($shareurl)){
            $params['shareurl'] = $shareurl;
        }
        return $this->call_method("platform.share", $params);
    }

    /**
     * 照片上傳
     * @param string $file 文件實際路徑
     * @param string $caption 標題
     * @param string $aid 相冊編號
     */
    public function photos_upload($file, $caption, $aid) {
        $params = array();
        $params['_file'] = '@' . $file;
        $params['caption'] = $caption;
        $params['aid'] = $aid;
        $this->fileUpload = true;
        $result = $this->call_method("photos.upload", $params);
        $this->fileUpload = false;
        return $result;
    }

    /**
     * $aids或pids必須任指一個
     *
     * @param string $aids 相冊ID列表,多個ID之間用逗號分隔
     * @param string $pids 圖片ID列表，多個ID之間用逗號分隔
     */
    public function photos_get($aids, $pids = null) {
        $params = array();
        if(! empty($aids)){
            $params['aids'] = $aids;
        }
        if(! empty($pids)){
            $params['pids'] = $pids;
        }
        return $this->call_method("photos.get", $params);
    }

    /**
     *
     * 獲取相冊
     * @param string $uids 用戶ID列表， 多個ID之間用逗號分隔
     * @param string $aids 相冊ID列表，多個ID之間用逗號分隔
     */
    public function photos_getAlbums($uids = null, $aids = null) {
        $params = array();
        if(! empty($aids)){
            $params['aids'] = $aids;
        }
        if(! empty($uids)){
            $params['uids'] = $uids;
        }
        return $this->call_method("photos.getAlbums", $params);
    }

    /**
     * 創建相薄
     * @param string $name
     * @param null or string $description
     */
    public function photos_createAlbum($name, $description = null) {
        $params = array();
        $params['name'] = $name;
        if(! empty($description)){
            $params['description'] = $description;
        }
        return $this->call_method("photos.createAlbum", $params);
    }

    /**
     * 设置数据返回格式
     *
     * @param string $format
     */
    public function set_format($format) {
        if(in_array($format, array("json", "xml"))){
            $this->format = $format;
        }
    }

    /**
     * 設定auth_token;
     */
    public function set_auth_token($auth_token) {
        $this->auth_token = $auth_token;
        return $this;
    }

    /**
     * 設置當前實際請求的平台
     * @param string $platform_name
     */
    public function set_platform($platform_name) {
        $this->platform = $platform_name;
        return $this;
    }

    /**
     * 设置是否压缩返回数据
     */
    public function set_compress($compress = true) {
        $this->compress = (boolean)$compress;
        return $this;
    }

    /**
     * 方法调用
     *
     * @param string $method
     * @param array $params
     * @return mixed
     */
    private function &call_method($method, $params = array()) {
        if($this->format){
            $params['format'] = $this->format;
        }
        $method = $this->domain . "." . $method;
        $data = $this->post_request($method, $params);
        if(! empty($data) && $this->compress){
            $data = gzuncompress($data);
        }
        $result = null;
        if($params['format'] == 'json'){
            $result = @json_decode($data, true);
        }elseif($params['format'] == 'xml'){
            $result = @$this->convert_xml_to_result($data, $method, $params);
        }
        if(! $result && ! is_array($result)){
            echo $data;
            exit(0);
        }else{
            if(is_array($result) && isset($result['error_code'])){
                if(isset($result['error_msg'])){
                    $error_msg = $result['error_msg'];
                }else{
                    $error_msg = $result['error_code'];
                }
                throw new Exception($error_msg, $result['error_code']);
            }
        }
        return $result;
    }

    /**
     * 轉換XML輸出
     * @param string $xml XML文檔
     * @param string $method
     * @param array $params
     */
    protected function convert_xml_to_result($xml, $method, $params) {
        $sxml = simplexml_load_string($xml);
        $result = self::convert_simplexml_to_array($sxml);
        return $result;
    }

    /**
     *
     * 轉換XML解析結果為數組
     * @param object $sxml
     */
    public static function convert_simplexml_to_array($sxml) {
        $arr = array();
        if($sxml){
            foreach($sxml as $k => $v){
                if($sxml['list']){
                    $arr[] = self::convert_simplexml_to_array($v);
                }else{
                    $arr[$k] = self::convert_simplexml_to_array($v);
                }
            }
        }
        if(sizeof($arr) > 0){
            return $arr;
        }else{
            return (string)$sxml;
        }
    }

    /**
     * 新增標準參數
     */
    private function add_standard_params($method, $params) {
        $post = $params;
        $get = array();

        $get['method'] = $method;
        if(! empty($this->auth_token)){
            $get['auth_token'] = $this->auth_token;
        }
        $get['api_key'] = $this->api_key;
        $post['call_id'] = microtime(true);
        if($post['call_id'] <= $this->last_call_id){
            $post['call_id'] = $this->last_call_id + 0.001;
        }
        $this->last_call_id = $post['call_id'];
        $get['compress'] = $this->compress;
        if(! empty($this->platform)){
            $get['platform'] = $this->platform;
        }

        return array($get, $post);
    }

    /**
     * 规范化参数
     *
     * @param string $method
     * @param array $params
     * @return array
     */
    private function finalize_params($method, $params) {
        list($get, $post) = $this->add_standard_params($method, $params);
        $this->convert_array_values_to_json($post);
        $post[self::NS] = $this->generate_sig(array_merge($get, $post), $this->secret);
        return array($get, $post);
    }

    /**
     * 格式化参数
     *
     * @param unknown_type $params
     */
    private function convert_array_values_to_json(&$params) {
        foreach($params as $key => &$val){
            if(is_array($val)){
                $val = json_encode($val);
            }else if(is_bool($val)){
                $val = intval($val);
            }
        }
    }

    /**
     * 生成signature
     *
     * @param array $params
     * @param string $secret
     * @return string
     */
    private function generate_sig($params, $secret) {
        $signature_str = '';
        ksort($params);
        foreach($params as $k => $v){
            if(substr($k, 0, 1) == '_'){
                continue;
            }
            if(is_bool($v)){
                $v = intval($v);
            }
            $signature_str .= "$k=$v";
        }
        $signature_str .= $secret;
        return md5($signature_str);
    }

    /**
     * 發送URL請求
     *
     * @param string $method
     * @param array $params
     * @return string
     */
    private function post_request($method, $params) {
        list($get, $post) = $this->finalize_params($method, $params);
        $this->append_namespace($get);
        $this->append_namespace($post);
        $get_string = http_build_query($get);
        $url_with_get = $this->server_addr . '?' . $get_string;
        $useragent = 'SNSPlus API PHP5 Client 1.1 (curl) ' . phpversion();

//info_log($url_with_get, 'aaa');
        try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url_with_get);
            if($this->fileUpload){
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            }else{
                $post_string = http_build_query($post);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::CONNECT_TIMEOUT);
            curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);

            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        }catch (Exception $e){
            echo $e->getMessage();
            exit(0);
        }
    }

    /**
     * 添加命名空间前缀
     *
     * @param array $params
     * @param string $namespace
     */
    private function append_namespace(&$params, $namespace = self::NS) {
        $prefix = $namespace . '_';
        foreach($params as $name => $value){
            if(strpos($name, $namespace) !== 0){
                unset($params[$name]);
                $params[$prefix . $name] = $value;
            }
        }
    }
}
?>