<?php

/**
 * Facebook Credit 付款頁面
 *
 * @author 林稘閎
 * @version $Id:pay.php, v2.3 2011-06-08 21:42:00 Albert $
 * @package Pay
 * @copyright 2011(C)Mymaji
 */


require_once "config.inc.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="<?php echo ITEMPATH;?>css/_cashcss.css" rel="stylesheet" type="text/css" />
<title>Facebook Credit</title>
</head>
<body>

<div id="output"></div>
<div id="jqueryOutput"></div>
<div id="fb-root"></div>
<div id="credit-root"></div>

<script type="text/javascript">
	window.onerror = function(){return true;}
</script>
<script src="<?php echo ITEMPATH;?>js/jquery-1.3.2.min.js"></script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script  type="text/javascript">

var site_url = '<?php echo SITE_URL; ?>';
var app_id =  '<?php echo APP_ID; ?>';
var item_path = '<?php echo ITEMPATH;?>';

</script>
<script src="<?php echo ITEMPATH;?>js/ifbc.js"></script>

</body>
</html>
