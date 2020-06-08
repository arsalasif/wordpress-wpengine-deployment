#!/bin/bash

cd /home/wpe-user/sites/WPENVNAMEDEV
mkdir migrate_sql
cd migrate_sql
wp db export migrate.sql # add the list of tables you want to export: e.g, --tables=wp_posts 