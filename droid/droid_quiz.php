<?php

function get_quizes($conn, $user_id){

	//for all courses student is erolled in
	$sql = "select * from mdl_quiz
		where id in(
			select courseid from mdl_enrol 
			where id in (
				select enrolid from mdl_user_enrolments where userid=".$user_id."));";

	$result = $conn -> query($sql);

	$return_val = array();
	$i = 0;
	if ($result->num_rows > 0) {
	
		while($row = $result->fetch_assoc()) {
                        $quiz_val = array();
			$quiz_val[0] = $row["id"];
			$quiz_val[1]=$row["course"];
			$quiz_val[2]=$row["name"];
			$quiz_val[3]=$row["timeopen"];
			$quiz_val[4]=$row["timeclose"];
			$quiz_val[5]=$row["timelimit"];
			
			$return_val[$i] = $quiz_val;
			$i = $i + 1;
		}
		return $return_val;
	}
	else{
		return 0;
	}
}