#!/bin/bash

cd /home/wpe-user/sites/WPENVNAMEPROD
cd deployment_backups
wp db export
cd ..
wp db import ./migrate_sql/migrate.sql
rm -rf migrate_sql
wp search-replace 'http://WPENVNAMESTAG.wpengine.com' 'http://PRODURL' --skip-columns=guid --precise --recurse-objects
wp search-replace 'https://WPENVNAMESTAG.wpengine.com' 'https://PRODURL' --skip-columns=guid --precise --recurse-objects
wp search-replace 'WPENVNAMESTAG.wpengine.com' 'PRODURL' --skip-columns=guid --precise --recurse-objects
wp search-replace '//WPENVNAMESTAG.wpengine.com' '//PRODURL' --skip-columns=guid --precise --recurse-objects
wp search-replace '/nas/content/live/WPENVNAMESTAG' '/nas/content/live/WPENVNAMEPROD' --skip-columns=guid --precise --recurse-objects
wp cache flush