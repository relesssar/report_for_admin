<?php
// File: /mod/mymodulename/view.php
require_once('../../config.php');
//$cmid = required_param('id', PARAM_INT);
//$cm = get_coursemodule_from_id('mymodulename', $cmid, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => 1), '*', MUST_EXIST);
//
require_login($course, true, $cm);
$PAGE->set_url('/local/report/report_for_admin', array('id' => $cm->id));
//$PAGE->set_title('My modules page title');
//$PAGE->set_heading('My modules page heading');
//$PAGE->set_pagelayout('standard');
// The rest of your code goes below this.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>report_for_admin</title>


    <script src="static/js/jquery.min.js"></script>

    <!-- datatable -->
    <link rel="stylesheet" type="text/css" href="static/css/datatables.min.css">
    <script type="text/javascript" charset="utf8" src="static/js/datatables.min.js"></script>
    <!-- datatable -->

    <!-- date picker -->
    <link rel="stylesheet" type="text/css" href="static/css/jquery.datetimepicker.min.css"/>
    <script src="static/js/jquery.datetimepicker.full.min.js"></script>
    <!-- date picker -->

</head>
<body>

<div>timeopen</div>
<input id="datepicker1" type="text" >

<div>year</div>
<input id="year" type="text" >
<br>
<button id="query">query</button>
<hr>
<table id="table_id" class="display" style="width:100%">
    <thead>
    <tr>
        <th>mdl_quiz.id</th>
        <th>mdl_quiz.timeopen</th>
        <th>mdl_quiz.timeclose</th>
        <th>mdl_quiz.course</th>
        <th>mdl_course.shortname</th>
        <th>mdl_course_modules.availability</th>
    </tr>
    </thead>
    <tbody>

    </tbody>

</table>


<script>

    $('#datepicker1').datetimepicker();
    $('#datepicker2').datetimepicker();

    var data = [
        [
            "no data",
            "no data",
            "no data",
            "no data",
            "no data",
            "no data"
        ]
    ]

    var datatable

    $(document).ready( function () {

        datatable = $('#table_id').DataTable({
            data:data
        });
    } );

    $( "#query" ).click(function() {
        var t1 = $('#datepicker1').val() + ':00';
        var d1 = new Date(t1);
        d1 = d1/1000;

        var y =  $('#year').val();


        $.ajax({
            url: '/local/report/api.php',
            method: 'post',
            dataType: 'json',
            data: {
                year: y,
                date:d1
            },
            success: function(data){
                let arr = []

                console.log(data);
                data.forEach(function(item){
                    let copy = [];
                    copy.push(item['id']);

                    let unix_timestamp = item['timeopen']
                    let date_open = new Date(unix_timestamp * 1000);
                    let date_open_str = date_open.getFullYear()+"/"+(date_open.getMonth()+1)+"/"+ date_open.getDate();
                    copy.push(date_open_str);

                    unix_timestamp = item['timeclose']
                    let date_close = new Date(unix_timestamp * 1000);
                    let date_close_str = date_close.getFullYear()+"/"+(date_close.getMonth()+1)+"/"+ date_close.getDate();
                    copy.push(date_close_str);

                    copy.push(item['course']);
                    copy.push(item['shortname']);
                    copy.push(item['availability']);

                    arr.push(copy);
                })


                datatable.clear();
                datatable.rows.add(arr);
                datatable.draw(false);
            }
        });
    });



</script>
</body>
</html>
