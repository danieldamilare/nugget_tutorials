<?php

use  PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/../../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../../PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../../PHPMailer-master/src/Exception.php';

class EmailService{
    private $mailer;
    public function __construct($email_name = EMAIL_USERNAME, $email_password = EMAIL_PASSWORD){
        $this->mailer = new PHPMailer(true);

        // Force SMTP protocol
        $this->mailer->isSMTP();
        $this->mailer->Host = EMAIL_HOST;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $email_name;
        $this->mailer->Password = $email_password;

        if (EMAIL_PORT == 465) {
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $this->mailer->Port = EMAIL_PORT;
        $this->mailer->addReplyTo('no-reply@nuggetstutorials.com', 'Nuggets Automated System');
        $this->mailer->addCustomHeader('Auto-Submitted', 'auto-generated');
        $this->mailer->addCustomHeader('Precedence', 'bulk');


        error_log("EmailService initialized with host: " . EMAIL_HOST);
        error_log("EmailService initialized with username: " . $email_name);
        error_log("EmailService initialized with port: " . EMAIL_PORT);
        error_log("EmailService initialized with encryption: " . PHPMailer::ENCRYPTION_STARTTLS);
        error_log("EmailService SMTPAuth: " . ($this->mailer->SMTPAuth ? "true" : "false"));
        error_log("EmailService isSMTP: " . ($this->mailer->isSMTP() ? "true" : "false"));
        error_log("EmailService Encryption: " . $this->mailer->SMTPSecure);
}
    public function send_email($to,
                               $subject,
                               $html_content,
                               $text_content = '') {

        error_log("Attempting to send email to $to with subject '$subject'");
        try {
            $this->mailer->setFrom(EMAIL_FROM, 'Nugget Tutorials');
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->isHTML(true);
            $this->mailer->Body = $html_content;
            if (!empty($text_content)) {
                $this->mailer->AltBody = $text_content;
            }
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            // Handle the exception or log the error
            error_log("Email could not be sent. Mailer Error: {$this->mailer->ErrorInfo}");
            return false;
        }
    }
}
?>
