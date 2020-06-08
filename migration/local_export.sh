#!/bin/bash

cd /home/wpe-user/sites/WPENVNAMEDEV

wp search-replace 'http://WPENVNAMEDEV.wpengine.com' 'http://localhost' --skip-columns=guid --precise --recurse-objects
wp search-replace 'https://WPENVNAMEDEV.wpengine.com' 'https://localhost' --skip-columns=guid --precise --recurse-objects
wp search-replace 'WPENVNAMEDEV.wpengine.com' 'localhost' --skip-columns=guid --precise --recurse-objects
wp search-replace '//WPENVNAMEDEV.wpengine.com' '//localhost' --skip-columns=guid --precise --recurse-objects
wp search-replace '/nas/content/live/WPENVNAMEDEV' '/nas/content/live/localhost' --skip-columns=guid --precise --recurse-objects

mkdir local_export
cd local_export
wp db export localdump.sql
cd ..

wp search-replace 'http://localhost' 'http://WPENVNAMEDEV.wpengine.com' --skip-columns=guid --precise --recurse-objects
wp search-replace 'https://localhost' 'https://WPENVNAMEDEV.wpengine.com' --skip-columns=guid --precise --recurse-objects
wp search-replace 'localhost' 'WPENVNAMEDEV.wpengine.com' --skip-columns=guid --precise --recurse-objects
wp search-replace '//localhost' '//WPENVNAMEDEV.wpengine.com' --skip-columns=guid --precise --recurse-objects
wp search-replace '/nas/content/live/localhost' '/nas/content/live/WPENVNAMEDEV' --skip-columns=guid --precise --recurse-objects
wp cache flush