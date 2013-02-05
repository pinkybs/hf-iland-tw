<?php 
require_once "config.inc.php";
$url = SITE_URL."/pay.php?fb_sig_in_iframe=1";
?>
<fb:fbml>
    <fb:iframe src="<?php echo $url;?>" height="1100" width="760" name="pay_page" frameborder="0" include_fb_sig="false"/>
</fb:fbml>