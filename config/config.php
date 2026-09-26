<?php
// Native PHP 8.3 configuration. Set these values for your server.
return [
    "db_host" => getenv("DB_HOST") ?: "localhost",
    "db_name" => getenv("DB_NAME") ?: "school",
    "db_user" => getenv("DB_USER") ?: "root",
    "db_pass" => getenv("DB_PASS") ?: "",
    "db_charset" => "utf8mb4",
    "app_name" => "Optimum School System",
];
