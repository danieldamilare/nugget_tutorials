<?php
class CourseController{
    public static function courses (){
        $courses = CourseService::get_all_courses();
        render_view('course.php',
            ['title' => 'Our Courses',
             'courses' => $courses,
            ]
            );
    }

    public static function register_course(){
        login_required();
        $user = get_authenticated_user();
        $course_id = $_GET['course'] ?? null;
        if ($course_id === null || !(filter_var($course_id, FILTER_VALIDATE_INT))){
            flash_message("Invalid course selected", "error");
            redirect('/courses.php');
            return;
        }

        if (CourseService::is_user_registered_for_course($user, $course_id)){
            flash_message("You have already registered for this course", "info");
            redirect('/dashboard/courses.php?course=' . $course_id);
            return;
        }

        $course = CourseService::get_all_courses($course_id);
        if (!$course){
            flash_message("Selected course does not exist", "error");
            redirect('/courses.php');
            return;
        }
        $course = $course[0];

        render_view('register_course.php', [
            'title' => 'Register Course',
            'course' => $course,
            'user' => $user
        ]);
    }

}
?>
