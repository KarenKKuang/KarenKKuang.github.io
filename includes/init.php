<?php
// Define nav class variables
$nav_home_class = '';
$nav_connect_class = '';
$nav_join_class = '';
$nav_thanks_class = '';


// open connection to database
include_once("includes/db.php");
$db = init_sqlite_db('db/site.sqlite', 'db/init.sql');


// check login/logout params
include_once("includes/sessions.php");
$session_messages = array();
process_session_params($db, $session_messages);

// is the current user an alumnus?
define('ALUMNUS_GROUP_ID', 1);
$is_alumnus = is_user_member_of($db, ALUMNUS_GROUP_ID);

// is the current user a student?
define('STUDENT_GROUP_ID', 2);
$is_student = is_user_member_of($db, STUDENT_GROUP_ID);
