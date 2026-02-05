<?php

class CourseService{
    private static function build_course_from_row($row) {
        if (!$row) return null;
        return new Course(
            $row['id'],
            $row['course_name'],
            $row['price'],
        );
    }

    public static function get_all_courses(){
        $db = get_db();
        $stmt = $db->query("SELECT * from courses");
        $result = array();
        while($row = $stmt->fetch()){
            $result[] = self::build_course_from_row($row);
        }
        return $result;
    }

    public static function get_user_courses($user){
        $db = get_db();
        $sql = "SELECT rsc.*, cs.course_name, cs.price, py.payment_date, py.expiry_date
                FROM registered_courses as rsc
                JOIN  courses as cs on cs.id = rsc.course_id
                JOIN payments as py on py.id = rsc.last_payment_id
                WHERE rsc.user_id = ? ;";
        $stmt = $db->prepare($sql);
        $stmt->execute([$user->id]);
        return $stmt->fetchall();
    }
}
?>
