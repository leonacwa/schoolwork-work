#!/bin/bash                                                                                                                
user=root
pwd=123456
db=work
bak=`date +%Y%m%d%H%M%S`

mysqldump -u$user -p$pwd -hlocalhost $db -R  > bak_$bak.sql
mysqldump -u$user -p$pwd -hlocalhost $db -R -d > schema_$bak.sql

