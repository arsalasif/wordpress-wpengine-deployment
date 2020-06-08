#!/bin/bash

start=`date +%s`
cat ./migration/local_export.sh | ssh WPEENVNAMEDEV@WPEENVNAMEDEV.ssh.wpengine.net
rm -rf ./db/data
rsync -rp --remove-source-files --delete-after -arvz --quiet WPEENVNAMEDEV@WPEENVNAMEDEV.ssh.wpengine.net:/home/wpe-user/sites/WPEENVNAMEDEV/local_export/ ./db/seed/
echo "Duration: $((($(date +%s)-$start)/60)) minutes"