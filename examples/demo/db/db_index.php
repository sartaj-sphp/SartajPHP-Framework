<?php
/**
 * Framework / permissions conventions:
 *    id — default unique PK (if renamed: Page $where + Pagination fun-setPrimaryKey)
 *    spcmpId — company/project id (multi-company separation)
 *    userid — logged-in user; parentid — employee-under
 *    submit_timestamp / update_timestamp — create/update tracking (log + recycle)
 */
// write your database create table queries here and other installation commands here
        $mysql = SphpBase::dbEngine();
        $mysql->connect();
        if($mysql instanceof Sqlite){
        // 1. pkgs Tbl
        $sql = "CREATE TABLE IF NOT EXISTS pkgs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    txtname VARCHAR(100) NOT NULL,
    userid BIGINT NOT NULL,
    parentid BIGINT NOT NULL,
    sltweb_template VARCHAR(50) NOT NULL,
    sltproxy_template VARCHAR(50) NOT NULL,
    sltdns_template VARCHAR(50) NOT NULL,
    sltssh_access VARCHAR(50),
    numweb_domains INTEGER,
    numweb_aliases INTEGER,
    numdns_domains INTEGER,
    numdns_records INTEGER,
    nummail_domains INTEGER,
    nummail_accounts INTEGER,
    numdatabases INTEGER,
    numcron_jobs INTEGER,
    numbackups INTEGER,
    numquota INTEGER,
    numbandwidth INTEGER,
    txtns1 VARCHAR(100),
    txtns2 VARCHAR(100),
    submit_timestamp VARCHAR(20) NOT NULL,
    update_timestamp VARCHAR(20) NOT NULL,
    spcmpId VARCHAR(14)
)";
        $mysql->createTable($sql);
        $mysql->dropTable("mngftp");

        $sql = "CREATE TABLE IF NOT EXISTS mngftp (
            txtdomain VARCHAR(100) NOT NULL,
            txtuser VARCHAR(40) NOT NULL,
            txtpass VARCHAR(20) NOT NULL,
            txtpath VARCHAR(100) NOT NULL,

            id INTEGER PRIMARY KEY AUTOINCREMENT,
            submit_timestamp VARCHAR(20) NOT NULL,
            update_timestamp VARCHAR(20) NOT NULL,
            spcmpId VARCHAR(14),
            userid BIGINT NOT NULL,
            parentid BIGINT NOT NULL
        )";
        $mysql->createTable($sql);

        $sql = "CREATE TABLE IF NOT EXISTS mngdb (
            txtdomain VARCHAR(100) NOT NULL,
            txtdb VARCHAR(100) NOT NULL,
            txtuser VARCHAR(40) NOT NULL,
            txtpass VARCHAR(20) NOT NULL,

            id INTEGER PRIMARY KEY AUTOINCREMENT,
            submit_timestamp VARCHAR(20) NOT NULL,
            update_timestamp VARCHAR(20) NOT NULL,
            spcmpId VARCHAR(14),
            userid BIGINT NOT NULL,
            parentid BIGINT NOT NULL
        )";
        $mysql->createTable($sql);

        $sql = "CREATE TABLE IF NOT EXISTS mngemail (
            txtdomain VARCHAR(100) NOT NULL,
            txtuser VARCHAR(40) NOT NULL,
            txtpass VARCHAR(20) NOT NULL,

            id INTEGER PRIMARY KEY AUTOINCREMENT,
            submit_timestamp VARCHAR(20) NOT NULL,
            update_timestamp VARCHAR(20) NOT NULL,
            spcmpId VARCHAR(14),
            userid BIGINT NOT NULL,
            parentid BIGINT NOT NULL
        )";
        $mysql->createTable($sql);

        // Modular project tables (pattern: db/db_*.php included here)
        include_once(__DIR__ . '/db_ex10.php');
        include_once(__DIR__ . '/db_audit.php');
        include_once(__DIR__ . '/db_ex17.php');
        
        }else{
        include_once(__DIR__ . '/db_ex10.php');
        include_once(__DIR__ . '/db_audit.php');
        include_once(__DIR__ . '/db_ex17.php');
        }
		