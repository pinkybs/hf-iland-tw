<?php

define('ROOT_DIR', realpath('../'));

require(ROOT_DIR . '/bin/config.php');

try {
	//Hapyfish2_Island_Event_Bll_Peidui::Peidui(113932,1315908000,114632);
	Hapyfish2_Island_Event_Bll_Peidui::deletePlant();
	echo "OK ";
}
catch (Exception $e) {
	err_log($e->getMessage());
}