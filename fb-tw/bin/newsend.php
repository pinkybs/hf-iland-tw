<?php

define('ROOT_DIR', realpath('../'));

require(ROOT_DIR . '/bin/config.php');

try {
	//Hapyfish2_Island_Event_Bll_Peidui::deletePlant();
//	$result = Hapyfish2_Island_Event_Bll_Peidui::getPayCount();
//	echo 'OK: ' . $result;
//
//	$cids = array(92931, 93031);
//
//	foreach ($cids as $cid) {
//		$ok = 0;
//		$ok = Hapyfish2_Island_Event_Bll_Peidui::getPlantNum($cid);
//		
//		echo $cid . ' : ' . $ok . ';';
//	}
	
	$ok = Hapyfish2_Island_Event_Bll_Peidui::addUserFishSkill();
	
	echo 'OK  ' . $ok;
}
catch (Exception $e) {
	err_log($e->getMessage());
}