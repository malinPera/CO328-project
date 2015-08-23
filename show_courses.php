<?php
//malin

$timeZ = "Asia/Colombo";
require_once(dirname(__FILE__) . '/../config.php');
require_once($CFG->dirroot . '/my/lib.php');
global $USER;

$servername = "localhost";
$username = "malin";
$password = "moodle829";
$dbname = "bitnami_moodle";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
 
function get_web_id($conn,$assignId){
    
   $type = "assign";
   $sql = "";
   
   $sql .= 'create view temp1 as
            select id,course from mdl_course_modules where
            module = (
            select id from mdl_modules where name="'.$type.'");';
   
    $result1 = $conn->query($sql);
    $x = (int)$assignId - 1;
    //echo "X: ".$x."<br>";
    $sql = "select id from temp1 limit ".$x.",1;";
    //echo $sql;
    $res = $conn->query($sql);
    
    $returnId=0;
    if ($res->num_rows > 0) {
        while( $row = $res->fetch_assoc() ) {                
                $returnId = $row["id"];
        }
    }
    $returr = $returnId;
    
    $sql = "drop view temp1;";
    $result2 = $conn->query($sql);

    return $returr;
}

$userr = $USER->id;
date_default_timezone_set($timeZ);

require_once('droid/droid_courses.php');
require_once('droid/forum_updates.php');
require_once('droid/droid_user.php');
require_once('droid/helpers.php');
require_once('droid/added_files.php');
require_once('droid/droid_assign.php');
///////////////////////////////////////////////////////////////////////////////////////////////
$t = time();
echo "Current time: ";
echo(date("Y-m-d h:i:sa",$t));
echo "<br>";
///////////////////////////////////////////////////////////////////////////////////////////////
$stud_info = get_user_cont($conn,$userr);

if($stud_info == 0){
        echo "ERROR!<br>";
}
else{
        $last_login = $stud_info[5];
        echo $stud_info[1]." ".$stud_info[2]."<br>";
        echo " ->Last access: ".date("Y-m-d h:i:sa",$stud_info[4])."<br>";
        echo " ->Last login: ".date("Y-m-d h:i:sa",$stud_info[5])."<br>";
        echo " ->Current login: ".date("Y-m-d h:i:sa",$stud_info[6])."<br>";
        echo "=====================================================<br>";
}
////////////////////////////////////////////////////////////////////////////////////////////////
echo "My Courses<br>";
$all_course_info = get_user_courses($conn,$userr);

if($all_course_info == 0){
        echo "ERROR!";
}
else{
        for ($i = 0; $i < sizeof($all_course_info); $i++) {
            $course_info = $all_course_info[$i];
                echo 'Name: <a href="../course/view.php?id='.$course_info[0].' ">'.$course_info[1]."</a><br>";
        }
}
echo "=====================================================================================<br>";
/////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "Forum updates<br>";

$all_forum_info = get_forum_updates($conn,$userr);

 if($all_forum_info == 0){
        echo "ERROR!";
 }
 else{
         for ($i = 0; $i < sizeof($all_forum_info); $i++) {
                $forum_info = $all_forum_info[$i];
                //echo "id: ".$course_info[0]."</br>";
                //echo 'Name: <a href="../course/view.php?id='.$course_info[0].' ">'.$course_info[1]."</a><br>";
                if ($last_login<$forum_info[3]){
                    $course_name = get_course_name($conn, $forum_info[1]);
                    echo "Id: ".$forum_info[0]."<br>";
                    echo "Course: ".$course_name."<br>";
                    echo ' ->Name: <a href="../mod/forum/discuss.php?d='.$forum_info[0].' ">'.$forum_info[2]."</a><br>";
                    echo " ->Time: ".date("Y-m-d h:i:sa",$forum_info[3])."<br>";
                    echo "---------------------------------------------------<br>";
                }
         }
}
echo "=====================================================================================<br>";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo "New files<br>";
$all_files = get_addFiles($conn,$userr);

if($all_files == 0){
        echo "ERROR!";
 }
 else{
         for ($i = 0; $i < sizeof($all_files); $i++) {
                $file_info = $all_files[$i];
                //echo "id: ".$course_info[0]."</br>";
                //echo 'Name: <a href="../course/view.php?id='.$course_info[0].' ">'.$course_info[1]."</a><br>";
                if ($last_login<$file_info[3]){
                    $course_name = get_course_name($conn, $file_info[1]);
                    echo "Id: ".$file_info[0]."<br>";
                    //echo "Course: ".$course_name."<br>";
                    echo 'Name: <a href="../course/view.php?id='.$file_info[1].' ">'.$course_name."</a><br>";
                    echo "File name: ".$file_info[2]."<br>";
                    echo " Added time: ".date("Y-m-d h:i:sa",$file_info[3])."<br>";
                    echo "---------------------------------------------------<br>";
                }
         }
}
echo "=====================================================================================<br>";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
$forums = get_new_forums($conn,$userr);

 if($forums == 0){
        echo "ERROR!";
 }
 else{
         for ($i = 0; $i < sizeof($forums_info); $i++) {
                $forum_new = $forums_info[$i];{
                    $course_name = get_course_name($conn, $forum_info[1]);
                    echo "Id: ".$forum_new[0]."<br>";
                    echo "Course: ".$course_name."<br>";
                    echo ' ->Name: <a href="../mod/forum/discuss.php?d='.$forum_info[0].' ">'.$forum_info[2]."</a><br>";
                    echo " ->Time: ".date("Y-m-d h:i:sa",$forum_info[3])."<br>";
                    echo "----------------------------------------------------------------------------------------<br>";
                //}
         }
    }
 }
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
echo "Assignments<br>";
$assigns = get_assigns($conn,$userr);

if($assigns == 0){
        echo "ERROR!";
 }
 else{
         for ($i = 0; $i < sizeof($assigns); $i++) {
                $a_1 = $assigns[$i];
                $course_name = get_course_name( $conn,$a_1[1] );
                echo "Course: ".$course_name."<br>";
                //echo "Name: ".$a_1[2]."<br>";
                $webid = get_web_id($conn,$a_1[0]);
              
                echo 'Name: <a href="../mod/assign/view.php?id='.$webid.' ">'.$a_1[2]."</a><br>";
                echo "Submission status: ".$a_1[5]."<br>";
                echo "Due date: ".date("Y-m-d h:i:sa",$a_1[3])."<br>";
                
                $time_left = $a_1[3] - $t;
                if ($time_left < 0){
                    if ($a_1[5]=="new"){
                        echo "OVERDUE!";
                    }
                    else {}
                }
                else {
                    echo "Time left: ".$time_left."<br>";
                }
                echo "<br>----------------------------------------------------------------------------------------<br>";
         }
         
}
echo "=====================================================================================<br>";
$conn->close();
