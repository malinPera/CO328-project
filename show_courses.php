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
      
$userr = $USER->id;
date_default_timezone_set($timeZ);

require_once('droid/droid_courses.php');
require_once('droid/forum_updates.php');
require_once('droid/droid_user.php');
require_once('droid/helpers.php');

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
//' - Name: <a href="../course/view.php?id='.$row["id"].' ">'. $row["fullname"]. " " . $row["shortname"]. "</a><br>" 
echo "----------------------------<br>";
/////////////////////////////////////////////////////////////////////////////////////////////////////////

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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

$forums = get_new_forums($conn,$userr);

 if($forums == 0){
        echo "ERROR!";
 }
 else{
         for ($i = 0; $i < sizeof($forums_info); $i++) {
                $forum_new = $forums_info[$i];
                //echo "id: ".$course_info[0]."</br>";
                //echo 'Name: <a href="../course/view.php?id='.$course_info[0].' ">'.$course_info[1]."</a><br>";
                //if ($last_login<$forum_new[3]){
                    $course_name = get_course_name($conn, $forum_info[1]);
                    echo "Id: ".$forum_new[0]."<br>";
                    echo "Course: ".$course_name."<br>";
                    echo ' ->Name: <a href="../mod/forum/discuss.php?d='.$forum_info[0].' ">'.$forum_info[2]."</a><br>";
                    echo " ->Time: ".date("Y-m-d h:i:sa",$forum_info[3])."<br>";
                    echo "---------------------------------------------------<br>";
                //}
         }
}
$conn->close();


