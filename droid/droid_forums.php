<?php
//malin
function get_new_forums($conn,$user_id){
	//$sql = "select * from mdl_course;";
	$sql = "select * from mdl_forum where course in(
                    select courseid from mdl_enrol
                    where id in (
                        select enrolid from mdl_user_enrolments where userid=".$user_id."));";
        echo $sql;
	$result = $conn->query($sql);
	$return_val = array();
	$i = 0;
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			//echo "id: " . $row["id"]. ' - Name: <a href="../course/view.php?id='.$row["id"].' ">'. $row["fullname"]. " " . $row["shortname"]. "</a><br>";
			$forum_val = array();
			$forum_val[0]=$row["id"];
			$forum_val[1]=$row["course"];
			$forum_val[2]=$row["name"];
			$forum_val[3]=$row["timemodified"];
                        
			$return_val[$i] = $forum_val;
			$i = $i + 1;
		}
		return $return_val;
	} else {
		$return_val=0;
	}
}
?>

