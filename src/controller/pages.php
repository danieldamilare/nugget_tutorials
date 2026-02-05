<?php
class PageController{
    public static function about(){
        render_view('about.php', [
        'title' => 'About Us'
        ]);
    }

    public static function index(){
        render_view('landing.php',
        ['title' => 'Home']
        );
    }

    public static function courses (){
        $courses = CourseService::get_all_courses();
        render_view('course.php',
            ['title' => 'OUr Courses',
             'courses' => $courses]
            );
    }

    public static function contact(){
        if ($_SERVER['REQUEST_METHOD'] = 'POST'){
            error_log("Processing contact form POST request");
            $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
            $name = trim($_POST['name']);
            $message  = trim($_POST['message']);
            error_log("Contact form details: Name=$name, Email=$email, Message=$message");
            $error_arr = array();

            if (empty($name) || empty($email) || empty($message)){
                error_log("Contact form validation failed: Missing fields");
                $error_arr['general'] = "All fields required";
            }
            else{
                $admin_email = ADMIN_EMAIL;

                $subject = "New Contact Inquiry from $name";

                $html_content = "
                    <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #eee;'>
                        <h2 style='color: #2563eb;'>New Website Inquiry</h2>
                        <p><strong>Name:</strong> " . h($name) . "</p>
                        <p><strong>Email:</strong> " . h($email) . "</p>
                        <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                        <p><strong>Message:</strong></p>
                        <p style='background: #f9fafb; padding: 15px; border-radius: 5px; white-space: pre-wrap;'>" . h($message) . "</p>
                    </div>
                ";
                error_log("Prepared email content for contact form.");
                $success = send_email($admin_email, $subject, $html_content);
                error_log("Email send function returned: " . ($success ? "success" : "failure"));

                if ($success) {
                    flash_message("Message sent! We'll get back to you soon.", "success");
                } else {
                    error_log("Contact form failed to send email via Brevo.");
                    flash_message("Something went wrong. Please email us directly at info@nuggetstutorials.com", "error");
                }
                error_log("Flash message: " . print_r($_SESSION['flash_messages'], true));
                redirect('/contact.php');

            }
        }
        render_view('contact.php',[
            'title' => 'Contact Us',
            'error_arr' => $error_arr]);
    }
}

?>
