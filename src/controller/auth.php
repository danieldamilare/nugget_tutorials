<?php
require_once __DIR__ . '/../service/user.php';

class AuthController{
    public static function register(){
        if (isset($_SESSION['is_authenticated'] ) && $_SESSION['is_authenticated'] === true){
            redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] =='POST'){
            if (!verify_csrf_token($_POST['csrf_token'])){
                flash_message("Invalid CSRF token", "error");
                redirect('/register.php');
            }

            $error_arr = array();
            $email = validate_email($_POST['email'], 'email', $error_arr);

            $full_name = trim($_POST['full_name']);
            check_required($full_name, 'full_name', $error_arr);
            check_required($_POST['password1'], 'password1', $error_arr, "Password is required");

            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];

            if ($password1 != $password2){
                $error_arr['password1'] =  $error_arr['password2'] = "Password does not match";
            }
            if (!isset($error_arr['email']) && UserService::get_user_by_email($email) != null){
                $error_arr['email'] = "Email has already been registered";
            }

            if (count($error_arr) == 0){
                if(UserService::create_user($email, $full_name, $password1)){
                    error_log("Created user successfully");
                    flash_message("Registration Successful. Check your email to verify your account.", "success");
                    redirect('/login.php');
                }
                else{
                    error_log("Error creating user");
                    flash_message("An error occur while registering new user", "error");
                }
            }
        }
        render_view('register.php', ['title' => 'Register', 'error_arr' => $error_arr ?? array()]);
    }

    public static function login(){
        if (isset($_SESSION['is_authenticated'] ) && $_SESSION['is_authenticated'] === true){
            redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!verify_csrf_token($_POST['csrf_token'])){
                flash_message("Invalid CSRF token", "error");
                redirect('/login.php');
            }

            error_log("Processing login POST request");
            $error_arr = array();
            $email = validate_email($_POST['email'], 'email', $error_arr);
            $password = check_required($_POST['password'],
                'password',
                $error_arr,
                "Password is required");

            if (count($error_arr) == 0){
                $user = UserService::get_user_by_email($email);

                if ($user){
                    error_log("Found user with email: $email");
                    if (!$user->email_verified){
                        error_log("User email not verified: $email");
                        UserService::resend_activation_email($user->email, $user);
                        flash_message(
                            "Your email is not verified. A new activation email has been sent to your inbox.", "warning");
                        redirect('/login.php');
                    }

                    if (password_verify($password, $user->password_hash)){
                        error_log("User credentials verified for email: $email");
                        login_user($user);
                        redirect('/dashboard.php');
                    }
                }

                $error_arr['general'] = "Invalid email or password";
            }
        }
        render_view('login.php', ['title' => 'Login', 'error_arr' => $error_arr ?? array()]);
    }
    public static function logout(){
        $token = $_POST['csrf_token'] ?? '';

        if (!verify_csrf_token($token)){
            redirect('/login.php');
            return;
        }

        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();

        session_start();
        flash_message("You have been logged out", "info");
        redirect('/login.php');
    }

    public static function activate_account(){
        $token = isset($_GET['token']) ? trim($_GET['token']) : null;
        $email = isset($_GET['email']) ? filter_var($_GET['email'], FILTER_SANITIZE_EMAIL) : null;

        if (!$token || !$email) {
            flash_message("Invalid activation request.", "error");
            redirect('/login.php');
        }

        if (UserService::activate_user_email($email, $token)){
            flash_message("Account verified! You can now login.", "success");
            redirect('/login.php');
        }

        else {
            flash_message("Activation link invalid or expired. Please login to request a new one.", "error");
            redirect('/login.php');
        }
    }


    public static function reset_password(){
        // To be implemented
    }

    public static function change_password(){
        // To be implemented
    }

    public static function forgot_password(){
        // To be implemented
    }

}
?>
