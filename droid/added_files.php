<?php
//malin
function get_addFiles($conn,$user_id){

	//$sql = "select * from mdl_course;";
	$sql = "select * from mdl_resource
			where course in(
				select courseid from mdl_enrol
				where id in (
					select enrolid from mdl_user_enrolments where userid=".$user_id."));";
	$result = $conn->query($sql);
	$return_val = array();
	$i = 0;
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			
			$file_val = array();
			$file_val[0]=$row["id"];
                        $file_val[1]=$row["course"];
			$file_val[2]=$row["name"];
			$file_val[3]=$row["timemodified"];
			
			$return_val[$i] = $file_val;
			$i = $i + 1;
		}
		return $return_val;
	} else {
		$return_val=0;
                return $return_val;
	}
}
?>

