<?php

// cleanup - remove table on uninstall
function my_plugin_remove_database() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'greetings';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");
}

// create greetings table in wordpress db
function table_creation() {
    global $wpdb;
    $greetings = $wpdb->prefix . "greetings";
    $charset = $wpdb->get_charset_collate;

    $msg_det = "CREATE TABLE $greetings(
            id  int (10)    NOT NULL AUTO_INCREMENT,
            greeting     varchar (100) DEFAULT '',
            PRIMARY KEY (id)
        ) $charset;";

    require_once(ABSPATH . "wp-admin/includes/upgrade.php");

    dbDelta($msg_det);
}

// inserts initial greeting in table
function initial_data() {
    global $wpdb;
    $welcome_text = 'Hi There!';
    $table_name = $wpdb->prefix . 'greetings';

    $wpdb->insert(
        $table_name,
        array(
            'greeting' => $welcome_text,
        )
    );
}


