<?php
if (count(get_included_files()) == 1) exit("Direct access not permitted.");

$web_config = [
    // Database Credentials - UPDATE THESE
    'db_host' => 'localhost',
    'db_user' => 'DB_USER_HERE',
    'db_pass' => 'DB_PASSWORD_HERE',
    'db_name' => 'DB_NAME_HERE',

    // Security & Logic
    'admin_hash'       => '', // Set this using passwordHasher.php
    'media_expiry_hrs' => 48,
    'upload_limit'     => 5,     
    'limit_window'     => 600,   
    'base_url'         => 'http://your-domain.com/' 
];

$conn = new mysqli($web_config['db_host'], $web_config['db_user'], $web_config['db_pass'], $web_config['db_name']);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Database Connection Error.");
}
?>
