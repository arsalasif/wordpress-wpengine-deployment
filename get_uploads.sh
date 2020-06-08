#!/bin/bash

start=`date +%s`
rsync -arvz WPEENVNAMEDEV@WPEENVNAMEDEV.ssh.wpengine.net:/home/wpe-user/sites/WPEENVNAMEDEV/wp-content/uploads/ ./wordpress/wp-content/uploads/
echo "Duration: $((($(date +%s)-$start)/60)) minutes"