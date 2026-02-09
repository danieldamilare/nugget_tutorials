<?php
if (!($lines = file(__DIR__ . '/.env', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES))){
    die("Error: Loading Envoriment context");
}
foreach ($lines as $line){
    putenv($line);
}

define('DB_HOST', getenv('NUGGET_DB_HOST') ?: 'localhost');
define('DB_USER', getenv("NUGGET_DB_USER") ?: 'dannyworld');
define('DB_PASSWORD', getenv('NUGGET_DB_PASSWORD')?: 'password'); //test
define('DB_NAME', getenv('NUGGET_DB_NAME') ?: 'nugget_tutorial.db');     //test
define('DB_PATH', getenv('NUGGET_DB_PATH') ?: __DIR__);
define('BREVO_API_KEY', getenv('BREVO_API_KEY') ?: '');
define('BREVO_SENDER_EMAIL', getenv('BREVO_SENDER_EMAIL') ?: '');
define('ADMIN_EMAIL', getenv('ADMIN_EMAIL')?: '');
define ('PAYMENT_PLAN_CODE', getenv('PAYMENT_PLAN_CODE') ?: '');
define('PAYSTACK_KEY', getenv('PAYSTACK_KEY')?: '');
define('EMAIL_USERNAME', getenv('EMAIL_USERNAME') ?: '');
define('EMAIL_PASSWORD', getenv('EMAIL_PASSWORD') ?: '');
define('EMAIL_HOST', getenv('EMAIL_HOST') ?: '');
define('EMAIL_PORT', getenv('EMAIL_PORT') ?: 587);
define('EMAIL_FROM', getenv('EMAIL_FROM') ?: '');
define('BASE_URL', getenv('BASE_URL') ?: 'http://localhost:8000');
?>
