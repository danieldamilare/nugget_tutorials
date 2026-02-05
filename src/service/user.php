<?php
class UserService{

   private static function build_user_from_row($row) {
        if (!$row) return null;

        return new User(
            $row['id'],
            $row['full_name'],
            $row['email'],
            $row['password_hash'],
            $row['role'],
            $row['email_verified'],
            $row['email_verification_token'],
            $row['email_verification_token_expires_at'],
            $row['password_reset_token'],
            $row['password_reset_token_expires_at'],
            $row['created_at']
        );
    }

    private static function find_user_by($column, $value) {
        $db = get_db();
        $sql = "SELECT * FROM users WHERE $column = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$value]);
        return self::build_user_from_row($stmt->fetch());
    }

    public static function get_user_by_email($email){
        return self::find_user_by('email', $email);
    }


    public static function get_user_by_id($id){
        return self::find_user_by('id', $id);
    }

    private static function send_activation_email($email, $token) {
        error_log("Sending activation email to $email with token $token");
        $user = UserService::get_user_by_email($email);
        if (!$user) {
            error_log("User not found for email: $email");
            return false;
        }
        $base_url = "http://localhost:8000";
        $activation_link = "$base_url/activate.php?email=" . urlencode($email) . "&token=$token";
        $full_name_escaped = htmlspecialchars($user->full_name);

        $content = <<<_EOF_
    <!DOCTYPE html>
    <html>
    <body style="font-family: Arial, sans-serif;">
        <h2>Welcome to Nugget Tutorials $full_name_escaped !</h2>
        <p>Please click the button below to activate your account and start learning:</p>
        <div style="margin: 20px 0;">
            <a href="$activation_link"
               style="background: #4A90E2; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
               Activate My Account
            </a>
        </div>
        <p>If the button doesn't work, copy and paste this link:<br>$activation_link</p>
    </body>
    </html>
    _EOF_;

        return send_email($email, "Activate your Nugget Tutorials account", $content);
    }

    public static function create_user($email, $full_name, $password, $role = 'student'){
        error_log("Creating user with email: $email");
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $token = generate_token();
        $token_expires_at = time() + 24 * 60 * 60;
        $sql = "INSERT into users(email, full_name, password_hash, role, email_verification_token, email_verification_token_expires_at) VALUES (?, ?, ?, ?, ?, ?)";
        try{
            $db = get_db();
            $stmt = $db->prepare($sql);
            if($stmt->execute([$email, $full_name, $password_hash, $role, $token, date('Y-m-d H:i:s', $token_expires_at)])){
                error_log("User created in database, sending activation email to $email");
                self::send_activation_email($email, $token);
                return new User(
                    $db->lastInsertId(),
                    $full_name,
                    $email,
                    $password_hash,
                    $role,
                    0, // email_verified
                    $token, // email_verification_token
                    date('Y-m-d H:i:s', $token_expires_at), // expires
                    null, // password_reset_token
                    null, // password_reset_token_expires
                    date('Y-m-d H:i:s') // created_at
                );
            }
            return null;
        } catch (PDOException $e){
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }

    public static function activate_user_email($email, $token){
        $db = get_db();
        $stmt= $db->prepare('SELECT * FROM users WHERE email = ? AND email_verification_token = ? AND email_verification_token_expires_at > ?');
        $stmt->execute([$email, $token, date('Y-m-d H:i:s')]);
        $row = $stmt->fetch();
        if (!$row){
            return false;
        }
        $sql = "UPDATE users SET email_verified = 1, email_verification_token = NULL, email_verification_token_expires_at = NULL WHERE email = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$email]);
    }

    public static function resend_activation_email($email) {
        $db = get_db();

        $user = self::get_user_by_email($email);

        if (!$user || $user->email_verified) {
            return false;
        }

        if ($user->email_verification_token_expires) {
            $expiry_timestamp = strtotime($user->email_verification_token_expires);
            $created_at_timestamp = $expiry_timestamp - (24 * 60 * 60);

            if (time() - $created_at_timestamp < 300) {
                error_log("Rate limit hit for email: $email");
                return true;
            }
        }


        $new_token = generate_token();
        $new_expiry = date('Y-m-d H:i:s', time() + 24 * 60 * 60);

        $sql = "UPDATE users SET email_verification_token = ?, email_verification_token_expires_at = ? WHERE email = ?";
        $stmt = $db->prepare($sql);

        if ($stmt->execute([$new_token, $new_expiry, $email])) {
            self::send_activation_email($email, $new_token);
            return true;
        }

        return false;
    }
}
?>
