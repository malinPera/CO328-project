<?php
//malin
function get_assigns($conn,$user_id){
        $sql = "select * from mdl_assign
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
                        $assign_val = array();
			$assign_val[0]=$row["id"];
			$assign_val[1]=$row["course"];
			$assign_val[2]=$row["name"];
			$assign_val[3]=$row["duedate"];
			$assign_val[4]=$row["cutoffdate"];
                        $a=get_status($conn, $user_id, $assign_val[0]);
			$assign_val[5]=$a;
                        $return_val[$i] = $assign_val;
			$i = $i + 1;
		}
		return $return_val;
	} else {
		$return_val=0;
	}
   
}

function get_status($conn, $user_id, $assign_id){
    
    $sql = "select status from mdl_assign_submission
			where userid=".$user_id." and assignment=".$assign_id.";";
    $result = $conn->query($sql);
   
    if ($result->num_rows > 0) {
		// output data of each row
        while($row = $result->fetch_assoc()) {
            $status = $row["status"];
        }
    }
    return $status;
}

