<?php
//malin
function get_user_cont($conn,$user_id){

	//$sql = "select * from mdl_course;";
	$sql = "select * from mdl_user
			where id=".$user_id.";";
        
	$result = $conn->query($sql);
	$return_val = array();
        
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$return_val[0]=$row["username"];
			$return_val[1]=$row["firstname"];
			$return_val[2]=$row["lastname"];
			$return_val[3]=$row["department"];
			$return_val[4]=$row["lastaccess"];
                        $return_val[5]=$row["lastlogin"];
                        $return_val[6]=$row["currentlogin"];
		}
		
	} else {
		$return_val=0;
	}
        return $return_val;
}
?>

