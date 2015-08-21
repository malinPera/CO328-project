<?php
//malin
function get_user_courses($conn,$user_id){

	//$sql = "select * from mdl_course;";
	$sql = "select * from mdl_course
			where id in(
				select courseid from mdl_enrol
				where id in (
					select enrolid from mdl_user_enrolments where userid=".$user_id."));";
	$result = $conn->query($sql);
	$return_val = array();
	$i = 0;
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			//echo "id: " . $row["id"]. ' - Name: <a href="../course/view.php?id='.$row["id"].' ">'. $row["fullname"]. " " . $row["shortname"]. "</a><br>";
			$course_val = array();
			$course_val[0]=$row["id"];
			$course_val[1]=$row["fullname"];
			$course_val[2]=$row["shortname"];
			$course_val[3]=$row["summary"];
			$course_val[4]=$row["visible"];
			
			$return_val[$i] = $course_val;
			$i = $i + 1;
		}
		return $return_val;
	} else {
		$return_val=0;
	}
}
?>

