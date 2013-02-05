<?php

define('APP_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'app');
define('CONFIG_DIR', APP_DIR . DIRECTORY_SEPARATOR . 'config');
define('MODULES_DIR', APP_DIR . DIRECTORY_SEPARATOR . 'modules');
define('LIB_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'lib');
define('DOC_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'www');
define('LOG_DIR', '/data/logs/island/debug');
define('TEMP_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'temp');
define('SMARTY_TEMPLATES_C', ROOT_DIR . DIRECTORY_SEPARATOR . 'templates_c');

define('ENABLE_DEBUG', true);

define('SERVER_ID', '6');

define('APP_ID', '125043264175761');
define('APP_KEY', '3f26204c99d1a2fd968f964f6c31571d');
define('APP_SECRET', 'a88b800ef979c25aaba803165d292a0f');
define('APP_NAME', 'fbisland');
define('NS', 'cs_sig');

define('DATABASE_NODE_NUM', 4);
define('MEMCACHED_NODE_NUM', 10);

define('HOST', HTTP_PROTOCOL.'dreamisland.snsplus.com');
if (HTTP_PROTOCOL == 'https://') {
    define('STATIC_HOST', HTTP_PROTOCOL.'static-happyislandtw.snsplus.com');
}
else {
    //define('STATIC_HOST', HTTP_PROTOCOL.'happyislandtw.ak.snsplus.com/v2');
    define('STATIC_HOST', HTTP_PROTOCOL.'happyislandtw-ak.snsplus.com/v2');
}

define('SEND_ACTIVITY', true);
define('SEND_MESSAGE', true);

define('APP_STATUS', 1);
define('APP_STATUS_DEV', 1);

define('ECODE_NUM', 4);