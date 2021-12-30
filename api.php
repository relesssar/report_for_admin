<?php
require_once('../../config.php');
global $DB;

require_login();
$userid = $USER->id;


if (is_siteadmin())
{
    if (isset($_POST) and isset($_POST['year']) and isset($_POST['date']))
    {
        $query = "
		SELECT
		  mdl_quiz.id,
		  mdl_quiz.timeopen,
		  mdl_quiz.timeclose,
		  mdl_quiz.course,
		  mdl_course.shortname,
		  mdl_course_modules.availability
		FROM mdl_quiz
		  INNER JOIN mdl_course
			ON mdl_quiz.course = mdl_course.id
		  INNER JOIN mdl_course_modules
			ON mdl_course.id = mdl_course_modules.course
		WHERE mdl_course.year = ".$_POST['year']."
		AND mdl_quiz.timeopen >= ".$_POST['date']."
		";

        $results = $DB->get_records_sql($query);

        $results_arr = [];
        foreach ($results as $item) {
            $results_arr[] = $item;
        }

        echo json_encode($results_arr, JSON_UNESCAPED_UNICODE);
    }
    else
    {
        echo json_encode(array('success' => 0));
    }
}
else
{
    echo 'NOT admin';
}



