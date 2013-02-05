<?php

define('APP_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'app');
define('CONFIG_DIR', APP_DIR . DIRECTORY_SEPARATOR . 'config');
define('MODULES_DIR', APP_DIR . DIRECTORY_SEPARATOR . 'modules');
define('LIB_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'lib');
define('DOC_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'www');
define('LOG_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'logs');
define('TEMP_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'temp');
define('SMARTY_TEMPLATES_C', ROOT_DIR . DIRECTORY_SEPARATOR . 'templates_c');

define('ENABLE_DEBUG', true);

define('SERVER_ID', '99');

define('APP_ID', '117523854945742');
define('APP_KEY', '117523854945742');
define('APP_SECRET', '84a2df412302b0b1f89d408ca46a830c');
define('NS', 'cs_sig');
define('APP_NAME', 'fbisland_dev');

define('DATABASE_NODE_NUM', 4);
define('MEMCACHED_NODE_NUM', 10);

define('HOST', 'http://test-dreamisland.snsplus.com');
define('STATIC_HOST', 'http://test-dreamisland.snsplus.com/static');

//define('HOST', HTTP_PROTOCOL.'test-dreamisland.snsplus.com');
//if (HTTP_PROTOCOL == 'https://') {
//    define('STATIC_HOST', HTTP_PROTOCOL.'test-dreamisland.snsplus.com/static');
//}
//else {
//    define('STATIC_HOST', HTTP_PROTOCOL.'test-dreamisland.snsplus.com/static');
//}

define('SEND_ACTIVITY', true);
define('SEND_MESSAGE', true);

define('APP_STATUS', 1);
define('APP_STATUS_DEV', 1);

define('ECODE_NUM', 4);