<?php
/*
Plugin Name: Query Logger
Description: This plugin logs all queries, as well as update queries
Version:     1.0
Author:      Arsal Asif
Author URI:  https://arsal.me
License:     GPL3
License URI: https://github.com/arsalasif/wordpress-docker-wpengine/blob/master/LICENSE to your plugin license

Copyright 2020 Arsal Asif
Query Logger is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.
 
Query Logger is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Query Logger. If not, see (https://github.com/arsalasif/wordpress-docker-wpengine/blob/master/LICENSE).
*/

# PHP 7
# -----> NEVER use this plugin on production
# Enable global SAVEQUERIES variable

if (!defined("SAVEQUERIES"))
define("SAVEQUERIES", 1);

add_action("shutdown", function() {
    # Gets the global wpdb variable, as well as current-user
    global $wpdb;
    $current_user = wp_get_current_user()->data->user_email;

    $date= getdate();

    # Timestamp + User email to file
    # Creates a database-versioning folder in root directory
    # Adds two query files, one for all queries and the latter for only update/insert queries

    $filename = $current_user . '_' . $date['mday'] . '_' . $date['month'] . '_' . $date['year'];
  
    $fileUpdates = $filename . '_updates.sql';
    $fileHandlerUpdates = fopen(ABSPATH . '/database-versioning/' . $fileUpdates, 'a');

    $fileAllUpdates = $filename . '_all_updates.sql';
    $fileHandlerAllUpdates = fopen(ABSPATH . '/database-versioning/' . $fileAllUpdates, 'a');

    $updates = array();
    $all_updates = array();

    foreach ($wpdb->queries as $query) {
        # Ignore transient
        if(preg_match('(transient|SELECT|zcf_submitlogs)', $query[0]) == false and preg_match('(INSERT|UPDATE|ALTER|DELETE|CREATE|DROP)', $query[0]) == true)
        {
            $all_updates[] = "/**";
            $all_updates[] = " * Time: " . $query[1];
            $all_updates[] = " * Caller: ";

            foreach (explode(",", $query[2]) as $caller)
                $all_updates[] = " *   -->  " . trim($caller);

            $all_updates[] = " */";

            $all_updates[] = preg_replace('/\s+/', ' ', $query[0]) . ";";
            $all_updates[] = "";

            # All updates NOT to core wp tables
            if (preg_match('(wp_options|wp_posts|wp_comments|wp_commentmeta|wp_links|wp_posts|wp_postmeta|wp_terms|wp_termmeta|wp_term_relationships|wp_term_taxonomy|wp_usermeta|wp_users)', $query[0]) == false)
            {
                $updates[] = "/**";
                $updates[] = " * Time: " . $query[1];
                $updates[] = " * Caller: ";
    
                foreach (explode(",", $query[2]) as $caller)
                    $updates[] = " *   -->  " . trim($caller);
    
                $updates[] = " */";
    
                $updates[] = preg_replace('/\s+/', ' ', $query[0]) . ";";
                $updates[] = "";
            }
        }
    }
    
    fwrite($fileHandlerUpdates, implode("\r\n", $updates));
    fclose($fileHandlerUpdates);
    fwrite($fileHandlerAllUpdates, implode("\r\n", $all_updates));
    fclose($fileHandlerAllUpdates);
});

?>