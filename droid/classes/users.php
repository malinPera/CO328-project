<?php
/**
 * Description of users
 *
 * @author Malin Prematilake
 */
class users {
    
    var $userID;
    
    function users($userID){
        $this -> userID = $userID;
    }
    
    function get_user_cont($conn){
        
        $user_ID = $this->userID;
	$sql = "select * from mdl_user
			where id=".$user_ID.";";
        
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
    
    function get_user_courses($conn){
        
        $user_id = $this->userID;

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
			$return_val[$i] = $row["id"];
			$i = $i + 1;
		}
		return $return_val;
	} else {
		return $return_val=0;
	}
    }
}
