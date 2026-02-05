<?php
class Model{
}
class User extends Model{
    public $id;
    public $full_name;
    public $email;
    public $password_hash;
    public $role;
    public $email_verified;
    public $email_verification_token;
    public $email_verification_token_expires;
    public $password_reset_token;
    public $password_reset_token_expires;
    public $created_at;


    public function __construct($id,
            $full_name,
            $email,
            $password_hash,
            $role,
            $email_verified,
            $email_verification_token,
            $email_verification_token_expires,
            $password_reset_token,
            $password_reset_token_expires,
            $created_at
    ){
        $this->id = $id;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->role = $role;
        $this->email_verified = $email_verified;
        $this->email_verification_token = $email_verification_token;
        $this->email_verification_token_expires = $email_verification_token_expires;
        $this->password_reset_token = $password_reset_token;
        $this->password_reset_token_expires = $password_reset_token_expires;
        $this->created_at = $created_at;
    }
}

class Course extends Model{
    public $id;
    public $course_name;
    public $price;
    public function __construct($id, $course_name, $price){
        $this->id = $id;
        $this->course_name = $course_name;
        $this->price = $price;
    }
}

class RegisteredCourse extends Model{
    public $course_id;
    public $user_id;
    public $last_payment_id;
    public $subscription_code;

    public function __construct($course_id, $user_id, $last_payment_id, $subscription_code){
        $this->course_id = $course_id;
        $this->user_id = $user_id;
        $this->last_payment_id = $last_payment_id;
        $this->subscription_code = $subscription_code;
    }
}
?>
