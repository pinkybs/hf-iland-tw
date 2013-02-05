<?php

define('ROOT_DIR', realpath('../'));

require(ROOT_DIR . '/bin/config.php');

try {
	$ok = Hapyfish2_Island_Event_Bll_Peidui::clearFishTask();
	
	echo $ok . ' :  OK';
}
catch (Exception $e) {
	err_log($e->getMessage());
}