<?php
//malin
function get_course_id($conn,$user_id){
        
	$sql = "select courseid from mdl_enrol
				where id in (
					select enrolid from mdl_user_enrolments where userid=".$user_id.");";
        
	$result = $conn->query($sql);
        $return_val = array();
	$i = 0;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
                        
			$return_val[$i] = $row["courseid"];
			$i = $i + 1;
		}
		
	} else {
		$return_val=0;
	}
        return $return_val;
}

function get_course_name($conn, $course_id){
      
        $sql = "select fullname from mdl_course
				where id=".$course_id.";";
       
	$result = $conn->query($sql);
        $return_val;
	if ($result->num_rows > 0) {
		while( $row = $result->fetch_assoc() ) {                
			$return_val = $row["fullname"];
		}
		
	} return $return_val;
}


