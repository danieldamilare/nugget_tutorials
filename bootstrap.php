<?php
ob_start();


ini_set('session.save_path', __DIR__ . '/sessions');
@mkdir(ini_get('session.save_path'), 0700, true);
ini_set('session.use_strict_mode', 1);

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
session_start();
require_once __DIR__ . '/db.php';
$db = get_db();

if (!isset($_SESSION['csrf_token'])){
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function redirect($url){
    header("Location: " . $url);
    exit();
}

function flash_message($message, $category = 'info'){
    if (!isset($_SESSION['flash_messages']))
        $_SESSION['flash_messages'] = array();
    $_SESSION['flash_messages'][] = array('message' => $message, 'category' => $category);
}

function get_flash_messages(){
    if (isset($_SESSION['flash_messages'])){
        $messages = $_SESSION['flash_messages'];
        unset($_SESSION['flash_messages']);
        return $messages;
    }
    return array();
}

function verify_csrf_token($token){
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function h($string){
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function is_logged_in(){
    return isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] === true;
}

function login_user($user){
    $_SESSION['is_authenticated'] = true;
    $_SESSION['user_id'] = $user->id;
    session_regenerate_id(true);
    flash_message("Login Successful", "success");
    $current_user = $user;
    redirect('/');
}

function login_required(){
    if (!is_logged_in()){
        flash_message("You must be logged in to access that page.", "warning");
        redirect("/login.php");
    }

}

function get_authenticated_user(){
    static $current_user = null;
    if ($current_user instanceof User)
        return $current_user;
    if (is_logged_in()){
        $current_user = UserService::get_user_by_id($_SESSION['user_id']);
        return $current_user;
    }
    return null;
}

function render_view($view_path, $data=array()){
    extract($data);
    include __DIR__ . '/views/' . $view_path;
}
?>
