#!/bin/sh

date1=`date -d "$1 days ago" +%Y%m%d`
#date1='20110730'

prefix='tutorial'
statdbhost='10.67.223.45'
statdbuser='worker'
statdb='taiwan_island_log_stat'
tempdir='/data/logs/island/stat-data'
rm -rf  ${tempdir}/${prefix}/${date1}
mkdir -p -m 777  ${tempdir}/${prefix}/${date1}
cd ${tempdir}/${prefix}/${date1}

/usr/bin/wget -q -O  ${prefix}-${date1}.log.01   http://10.67.223.43/debug/${prefix}-${date1}.log
/usr/bin/wget -q -O  ${prefix}-${date1}.log.02   http://10.67.223.82/debug/${prefix}-${date1}.log
/usr/bin/wget -q -O  ${prefix}-${date1}.log.03   http://10.67.223.46/debug/${prefix}-${date1}.log
/usr/bin/wget -q -O  ${prefix}-${date1}.log.04   http://10.67.223.47/debug/${prefix}-${date1}.log
/usr/bin/wget -q -O  ${prefix}-${date1}.log.05   http://10.67.223.42/debug/${prefix}-${date1}.log
/usr/bin/wget -q -O  ${prefix}-${date1}.log.06   http://10.67.223.70/debug/${prefix}-${date1}.log

/bin/sort -m -t " " -k 1 -o all-${prefix}-${date1}.log   ${prefix}-${date1}.log.01  ${prefix}-${date1}.log.02  ${prefix}-${date1}.log.03  ${prefix}-${date1}.log.04 ${prefix}-${date1}.log.05 ${prefix}-${date1}.log.06

cd /data/website/island/bin/
/usr/local/php-cgi/bin/php -c /usr/local/php-cgi/lib/php.bin.ini /data/website/island/bin/stat-tutorial.php $1

