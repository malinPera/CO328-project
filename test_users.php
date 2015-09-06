<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$timeZ = "Asia/Colombo";
require_once(dirname(__FILE__) . '/../config.php');
require_once($CFG->dirroot . '/my/lib.php');

//my files
require_once('droid/classes/users.php');
require_once('droid/classes/course.php');
require_once('droid/classes/event.php');
require_once('droid/classes/submission.php');

//date and time settings
date_default_timezone_set($timeZ);

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

//creating the current user
$userr = $USER->id;
$current_user = new users($userr);
$userInfo = $current_user->get_user_cont($conn);
echo "Testing get_user_cont()<br>";
echo $userInfo[0]."<br>";
echo $userInfo[1]."<br>";
echo $userInfo[2]."<br>";
echo $userInfo[3]."<br>";
echo $userInfo[4]."<br>";
echo $userInfo[5]."<br>";
echo $userInfo[6]."<br>";

$crses = $current_user->get_user_courses($conn);
echo "Testing get_user_courses()<br>";
echo $crses[0]."<br>";
echo $crses[1]."<br>";

$crse1 = new course($crses[0]);
$crse1_info = $crse1->get_course_info($conn);

echo $crse1_info[0]."<br>";
echo $crse1_info[1]."<br>";
echo $crse1_info[2]."<br>";
echo $crse1_info[3]."<br>";

$crse1_events = new event($crses[0]);

$rest = $crse1_events->get_all_events($conn);

$assigns = $rest[0];
$quizzes = $rest[2];
$forums = $rest[1];
$urls = $rest[3];
$rescs = $rest[4];

echo "a: ".sizeof($assigns)."<br>";
echo "f: ".sizeof($quizzes)."<br>";
echo "q: ".sizeof($forums)."<br>";
echo "u: ".sizeof($urls)."<br>";
echo "r: ".sizeof($rescs)."<br>";

$e=$assigns[0];
echo "aa: ".$e[1]."<br>";

$s1=new submission($e[1],$e[0]);

echo $s1->get_link($conn);
echo $s1->get_dueDate($conn)."<br>";
echo $s1->get_cutOffDate($conn)."<br>";
echo $s1->isSubmit($conn,$userr)."<br>";

$t = time();

echo $s1->isExpired($conn,$t);
