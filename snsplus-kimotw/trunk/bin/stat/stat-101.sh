#!/bin/sh

date1=`date -d "1 days ago" +%Y%m%d`
#date1='20110804'
#var1=$1;
#var2=$2;
#date1=`date -d "${var1} days ago" +%Y%m%d`

prefix='101'
statdb='kimotw_island_log_stat'
tempdir='/data/logs/kimo_island/stat-data'
rm -rf  ${tempdir}/${prefix}/${date1}
mkdir -p -m 777  ${tempdir}/${prefix}/${date1}
cd ${tempdir}/${prefix}/${date1}

/usr/bin/wget -q -O  ${prefix}-${date1}.log.01   http://10.67.223.43/kimo_debug/${prefix}-${date1}.log
#/usr/bin/wget -q -O  ${prefix}-${date1}.log.02   http://10.67.235.96/kimo_debug/${prefix}-${date1}.log

/bin/sort -m -t " " -k 1 -o all-${prefix}-${date1}.log   ${prefix}-${date1}.log.01  
#${prefix}-${date1}.log.02  

num4=`cat all-${prefix}-${date1}.log | wc -l`
num5=`cat all-${prefix}-${date1}.log | awk '{print $5}' | grep 1 | wc -l`
num6=`cat all-${prefix}-${date1}.log | awk '{print $5}' | grep 0 | wc -l`

##printf "${date1}\t${num4}\t${num5}\t${num6}\n"

/usr/local/mysql/bin/mysql -u worker -p'r$6i7kP#xp' -h 10.67.223.45  ${statdb}  -e "update day_main set active=${num4},active_male=${num5},active_male=${num5},active_female=${num6} where log_time=${date1}"

cat all-${prefix}-${date1}.log  | awk '{print $6}' | sort | uniq -c  | sort -n  -k 2 >  tmp_${date1}_level

while read i   
do  
num7=`echo $i | awk '{print $2}'`
num8=`echo $i | awk '{print $1}'`

echo -n "$num7:$num8,"  >>  ${date1}_level

done < tmp_${date1}_level

level=`cat ${date1}_level`

##printf "${date1}\t${level}\n"

/usr/local/mysql/bin/mysql -u worker -p'r$6i7kP#xp' -h 10.67.223.45 ${statdb} -e "insert into  day_active_user_level  values('${date1}','${level}')"

######################################

/usr/local/mysql/bin/mysql -u worker -p'r$6i7kP#xp' -h 10.67.223.45 ${statdb} -e "delete from day_user_retention where log_time=${date1}"

/usr/local/mysql/bin/mysql -u worker -p'r$6i7kP#xp' -h 10.67.223.45 ${statdb} -e "insert into day_user_retention(log_time) values(${date1})"

s=0
j=0
k=0
n=0

for (( i=1;  i<=30;  i=i+1 ))
do
    s=$(date -d "$i day ago 00:00:00" +%s)
    #s=`expr $s - 86400`
    j=`expr $s - 86400`
    n=`expr $n + 1`
    k=`cat all-${prefix}-${date1}.log | awk '$4>"'$j'" && $4 < "'$s'" {print $1}' | wc -l`
    
    ##printf "${n}:${k}\t"

    /usr/local/mysql/bin/mysql -u worker -p'r$6i7kP#xp' -h 10.67.223.45 ${statdb} -e "update day_user_retention set day_${n}=${k} where log_time=${date1}"
done
