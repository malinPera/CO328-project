<html>
<html xml:lang="en" lang="en">
<head>
<title>FEeLS Home Page</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="form.css">
<!--script src="struct.js"></script-->

</head>

  <!--h1>Feels Home Page</h1-->

<div class="container">
<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 define("expiry", 1209600);
$timeZ = "Asia/Colombo";
require_once(dirname(__FILE__) . '/../config.php');
require_once($CFG->dirroot . '/my/lib.php');

//my files
require_once('droid/classes/users.php');
require_once('droid/classes/course.php');
require_once('droid/classes/event.php');
require_once('droid/classes/submission_v2.php');
require_once('droid/classes/grades.php');
require_once('droid/forum_updates.php');
require_once('droid/added_files.php');
require_once('droid/classes/quiz.php');
require_once('droid/classes/url.php');

//require_once('droid/classes/quiz.php');
//require_once('droid/classes/url.php');
//require_once('droid/classes/search.php');
//date and time settings
date_default_timezone_set($timeZ);

global $USER;

$servername = "127.0.0.1:3307";
$username = "root";
$password = "lumos";
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

$n = $userInfo[1]." ".$userInfo[2];
$crses = $current_user->get_user_courses($conn);
echo $current_user->get_link($n,$conn);

//echo "<h4>Assignments:</h4>";
?>
<div class="accordion">

    <dl>
      <dt>
<a class="accordionTitle" href="#">Assignments Due</a></dt>
      <dd class="accordionItem accordionItemCollapsed">
        <p>
            <?php
foreach ($crses as $cs){
	$crse1 = new course($cs);
	
	$crse1_events = new event($cs);
	$rest1 = $crse1_events->get_all_events($conn);
	
	$assigns = $rest1[0];
	echo $crse1->get_course_name($conn)."<br>";
	if (sizeof($assigns)>0){
		
		$count = 0;
		foreach ($assigns as $aa){
			
			$s1=new submission($aa[1],$aa[0]);
			
			$sbmt = $s1->isSubmit($conn,$userr)."<br>";			
			
			$t = time();
			$exp = $s1->isExpired($conn,$t);
			
			if (($sbmt == 1) && ($exp==1)) {
			
				continue;
			}
			echo $s1->get_link($conn);
			echo "Due: ".date("Y-m-d h:i:sa",$s1->get_dueDate($conn))."<br>";
			//echo date("Y-m-d h:i:sa",$s1->get_cutOffDate($conn))."<br>";
			$count++;
			
			if (($sbmt==0)&&($exp==0))
				echo "To be submitted<br>";
			
			elseif (($sbmt==0)&&($exp==1))
				echo "Overdue<br>";
				
			elseif (($sbmt==1)&&($exp==0))
				echo "Submitted<br>";
			echo "---------------------------------------------------<br>";
		}
		if ($count==0) {echo "No assignments due<br>";
					echo "---------------------------------------------------<br>";}
	}  else{
   echo "No assignments due<br>";
   echo "---------------------------------------------------<br>";
 }
}
?>
        </p>
      </dd>      
<dt><a href="#" class="accordionTitle">New URL</a></dt>
      <dd class="accordionItem accordionItemCollapsed">
        <p>
            <?php
//echo "<h4>Urls:</h4> <br>";
foreach ($crses as $cs){
	$crse1 = new course($cs);
	$crse1_events = new event($cs);
	$rest1 = $crse1_events->get_all_events($conn);
	
	$urls = $rest1[3];
	echo $crse1->get_course_name($conn)."<br>";
	if (sizeof($urls)>0){
		
		$count = 0;
		foreach ($urls as $uu){
			//echo "rererer: ".$aa[0]."<br>";
			$u1=new url($uu[1],$uu[0]);
			
			echo $u1->get_link($conn)."<br>";
			//$sbmt = $s1->isSubmit($conn,$userr)."<br>";			
			$t = time();

			//$exp = $s1->isExpired($conn,$t);
			
			//if (($sbmt != "new") && ($exp==1)) {
			//	break;
			//}
		
		
			
		}

			
		
		
	}  else echo "No added urls<br>";
  echo "---------------------------------------------------<br>";
}
?>
        </p>
      </dd>
<dt><a href="#" class="accordionTitle">New Quiz</a></dt>
      <dd class="accordionItem accordionItemCollapsed">
        <p>
            <?php
//echo "<h4>Quizes:</h4> <br>";
foreach ($crses as $cs){
	$crse1 = new course($cs);
	$crse1_events = new event($cs);
	$rest1 = $crse1_events->get_all_events($conn);
	
	$quizzes = $rest1[2];
	echo $crse1->get_course_name($conn)."<br>";
	if (sizeof($quizzes)>0){
		
		$count = 0;
		foreach ($quizzes as $qq){
			//echo "rererer: ".$aa[0]."<br>";
			$q1=new quiz($qq[1],$qq[0]);
			
			$state = $q1->get_state($conn, $userr);
			
			$t = time();
			
			if ($state =="NoAttempts"){
			
				$time_closed = $q1->get_attribute($conn,"timeclose");
				
				echo $q1->get_link($conn);
				
				echo "Open from: ".date("Y-m-d h:i:sa",$q1->get_attribute($conn,"timeopen"))."<br>";
				echo "Closing on: ".date("Y-m-d h:i:sa",$time_closed)."<br>";
				if (($t-$time_closed)>=expiry){
					echo "Closed!!<br>";
				}
				
			//echo date("Y-m-d h:i:sa",$s1->get_dueDate($conn))."<br>";
			//echo date("Y-m-d h:i:sa",$s1->get_cutOffDate($conn))."<br>";
				$count++;
			
			}
			echo "---------------------------------------------------<br>";
		}
		if ($count==0) echo "No quizes due<br>";
	}  else{
   echo "No quizes due<br>";
  echo "---------------------------------------------------<br>";
}
}
?>
        </p>
      </dd>
<dt><a href="#" class="accordionTitle">New Forum Posts</a></dt>
      <dd class="accordionItem accordionItemCollapsed">
        <p>
            <?php
//echo "<h4>Forum updates</h4>";

$all_forum_info = get_forum_updates($conn,$userr);

 if($all_forum_info == 0){
        echo "No forum updates<br>";
 }
 else{
		
         for ($i = 0; $i < sizeof($all_forum_info); $i++) {
                $forum_info = $all_forum_info[$i];
				
				$ere = $current_user->get_user_cont($conn);
                $last_login = $ere[5];
				if ($last_login<$forum_info[3]){
					$crse1 = new course($forum_info[1]);
					echo $crse1->get_course_name($conn);
                    //$course_name = get_course_name($conn, $forum_info[1]);
                    echo "<br>";
                   
                    echo 'Name: <a href="../mod/forum/discuss.php?d='.$forum_info[0].' ">'.$forum_info[2]."</a><br>";
                    echo "Time: ".date("Y-m-d h:i:sa",$forum_info[3])."<br>";
                    echo "---------------------------------------------------<br>";
                }
         }
}
?>
        </p>
      </dd>
<dt><a href="#" class="accordionTitle">New Files</a></dt>
      <dd class="accordionItem accordionItemCollapsed">
        <p>
            <?php
//echo "<h4>New files</h4><br>";
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
                    $crse1 = new course($forum_info[1]);
					$course_name = $crse1->get_course_name($conn);
                    //echo "Course: ".$course_name."<br>";
                    echo 'Name: <a href="../course/view.php?id='.$file_info[1].' ">'.$course_name."</a><br>";
                    echo "File name: ".$file_info[2]."<br>";
                    echo "Added time: ".date("Y-m-d h:i:sa",$file_info[3])."<br>";
                    echo "---------------------------------------------------<br>";
                }
         }
}

?>
        </p>
      </dd>
<dt><a href="#" class="accordionTitle">All Courses</a></dt>
      <dd class="accordionItem accordionItemCollapsed">
        <p>
            <?php
//echo "<h4>Courses:</h4>";
foreach ($crses as $cs){
	$crse1 = new course($cs);
	$c1 = $crse1->get_course_info($conn);
	$nn = $c1[1]."  ".$c1[0];
	echo $crse1->get_link($nn,$conn);
	if (!$c[2]) echo "No description<br>";
	else echo $c[2];
  echo "---------------------------------------------------<br>";
}
?>
</dl>

  </div>
<?php
$grading = $current_user->get_all_grades($conn);

//Displaying grades
include ('grade_show.html');

foreach ($grading as $gg){
    $crse = $gg->course;
    $cc = new course($crse);
    $cName = $cc->get_course_name($conn);
    
    $test = $gg->testName;
    
    $fG = $gg->finalGrade;
    
    $mx = $gg->maxx;
    
    if ($fG==NULL) $fG="Not graded yet";
    echo "<tr>
            <td>".$cName."</td>
            <td>".$test."</td>
            <td>".$fG."</td>
            <td>".$mx."</td>    
         </tr>";
}
?>
</table>
	 
		</div>
	</div>
</body>
</html>

<script>
function showHint(str)
{
if (str.length==0) { 
    document.getElementById("txtHint").innerHTML="";
    return;
} else {
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","droid/search_userV3.php?q="+str,true);
    xmlhttp.send();
}    
}
</script>
</head>
<body>

<p><b>Start typing a name in the input field below:</b></p>
<form action=""> 
Last name: <input type="text" id="txt1" onkeyup="showHint(this.value)">
</form>
<p>Suggestions: <span id="txtHint"></span></p> ;

<script>

( function( window ) {

'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) {
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

var classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
};

// transport
if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( classie );
} else {
  // browser global
  window.classie = classie;
}

})( window );

//fake jQuery
var $ = function(selector){
  return document.querySelector(selector);
}
var accordion = $('.accordion');





//add event listener to all anchor tags with accordion title class
accordion.addEventListener("click",function(e) {
  e.stopPropagation();
  e.preventDefault();
  if(e.target && e.target.nodeName == "A") {
    var classes = e.target.className.split(" ");
    if(classes) {
      for(var x = 0; x < classes.length; x++) {
        if(classes[x] == "accordionTitle") {
          var title = e.target;

          //next element sibling needs to be tested in IE8+ for any crashing problems
          var content = e.target.parentNode.nextElementSibling;
          
          //use classie to then toggle the active class which will then open and close the accordion
         
          classie.toggle(title, 'accordionTitleActive');
          //this is just here to allow a custom animation to treat the content
          if(classie.has(content, 'accordionItemCollapsed')) {
            if(classie.has(content, 'animateOut')){
              classie.remove(content, 'animateOut');
            }
            classie.add(content, 'animateIn');

          }else{
             classie.remove(content, 'animateIn');
             classie.add(content, 'animateOut');
          }
          //remove or add the collapsed state
          classie.toggle(content, 'accordionItemCollapsed');



          
        }
      }
    }
    
  }
});
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46156385-1', 'cssscript.com');
  ga('send', 'pageview');

</script>