#!/bin/bash

cd /home/wpe-user/sites/WPENVNAMESTAG
cd deployment_backups
wp db export
cd ..
wp db import ./migrate_sql/migrate.sql
rm -rf migrate_sql
wp search-replace 'http://WPENVNAMEDEV.wpengine.com' 'http://WPENVNAMESTAG.wpengine.com' --skip-columns=guid --precise --recurse-objects
wp search-replace 'https://WPENVNAMEDEV.wpengine.com' 'https://WPENVNAMESTAG.wpengine.com' --skip-columns=guid --precise --recurse-objects
wp search-replace 'WPENVNAMEDEV.wpengine.com' 'WPENVNAMESTAG.wpengine.com' --skip-columns=guid --precise --recurse-objects
wp search-replace '//WPENVNAMEDEV.wpengine.com' '//WPENVNAMESTAG.wpengine.com' --skip-columns=guid --precise --recurse-objects
wp search-replace '/nas/content/live/WPENVNAMEDEV' '/nas/content/live/WPENVNAMESTAG' --skip-columns=guid --precise --recurse-objects
wp cache flush