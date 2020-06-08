#!/bin/bash

cd /home/wpe-user/sites/WPENVNAMESTAG
mkdir migrate_sql
cd migrate_sql
wp db export migrate.sql --tables=wp_posts  # add the list of tables you want to export