<?php
require_once __DIR__ . '/../service/course.php';

class UserController{
    public static function dashboard(){
        login_required();
        $user = get_authenticated_user();
        $user_courses = CourseService::get_user_courses($user);
        $all_courses = CourseService::get_all_courses();
        $title = "User Dashboard";
        render_view('dashboard.php', [
            'title' => $title,
            'user_courses' => $user_courses,
            'all_courses' => $all_courses,
            'user' => get_authenticated_user()
        ]);
    }
}
?>
