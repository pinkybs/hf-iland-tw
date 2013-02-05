#!/bin/sh

cd /data/website/island/bin/
/usr/local/php-cgi/bin/php -c /usr/local/php-cgi/lib/php.bin.ini /data/website/island/bin/tool_clearallusercache.php $1
