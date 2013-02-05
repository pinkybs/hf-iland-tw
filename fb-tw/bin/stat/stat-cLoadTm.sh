#!/bin/sh

date1=`date -d "1 days ago" +%Y%m%d`
#date1='20110517'

prefix='cLoadTm'
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

prefix1='noflash'
/usr/bin/wget -q -O  ${prefix1}-${date1}.log.01   http://10.67.223.43/debug/${prefix1}-${date1}.log
/usr/bin/wget -q -O  ${prefix1}-${date1}.log.02   http://10.67.223.82/debug/${prefix1}-${date1}.log
/usr/bin/wget -q -O  ${prefix1}-${date1}.log.03   http://10.67.223.46/debug/${prefix1}-${date1}.log
/usr/bin/wget -q -O  ${prefix1}-${date1}.log.04   http://10.67.223.47/debug/${prefix1}-${date1}.log
/usr/bin/wget -q -O  ${prefix1}-${date1}.log.05   http://10.67.223.42/debug/${prefix1}-${date1}.log
/usr/bin/wget -q -O  ${prefix1}-${date1}.log.06   http://10.67.223.70/debug/${prefix1}-${date1}.log
/bin/sort -m -t " " -k 1 -o all-${prefix1}-${date1}.log   ${prefix1}-${date1}.log.01  ${prefix1}-${date1}.log.02  ${prefix1}-${date1}.log.03  ${prefix1}-${date1}.log.04 ${prefix1}-${date1}.log.05 ${prefix1}-${date1}.log.06

prefix2='nocookie'
/usr/bin/wget -q -O  ${prefix2}-${date1}.log.01   http://10.67.223.43/debug/${prefix2}-${date1}.log
/usr/bin/wget -q -O  ${prefix2}-${date1}.log.02   http://10.67.223.82/debug/${prefix2}-${date1}.log
/usr/bin/wget -q -O  ${prefix2}-${date1}.log.03   http://10.67.223.46/debug/${prefix2}-${date1}.log
/usr/bin/wget -q -O  ${prefix2}-${date1}.log.04   http://10.67.223.47/debug/${prefix2}-${date1}.log
/usr/bin/wget -q -O  ${prefix2}-${date1}.log.05   http://10.67.223.42/debug/${prefix2}-${date1}.log
/usr/bin/wget -q -O  ${prefix2}-${date1}.log.06   http://10.67.223.70/debug/${prefix2}-${date1}.log
/bin/sort -m -t " " -k 1 -o all-${prefix2}-${date1}.log   ${prefix2}-${date1}.log.01  ${prefix2}-${date1}.log.02  ${prefix2}-${date1}.log.03  ${prefix2}-${date1}.log.04 ${prefix2}-${date1}.log.05 ${prefix2}-${date1}.log.06

cd /data/website/island/bin/
nohup /usr/local/php-cgi/bin/php -f /data/website/island/bin/stat-cLoadTm.php &