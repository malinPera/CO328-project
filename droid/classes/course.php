<?php
/**
 * Description of course
 *
 * @author Malin Prematilake
 */
class course {
    
    var $courseID;
    
    function course($courseID){
        $this -> courseID = $courseID;
    }
    
    function get_course_info($conn){
        $ID = $this->courseID;
	$sql = "select * from mdl_course
			where id=".$ID.";";
        
	$result = $conn->query($sql);
	$return_val = array();
        
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$return_val[0]=$row["fullname"];
			$return_val[1]=$row["shortname"];
			$return_val[2]=$row["summary"];
		}
		
	} else {
		$return_val=0;
	}
        return $return_val;
    }
    
    function get_item_name($conn,$userID){
        $cId = $this->courseID;
        $sql = "select itemname
                from mdl_grade_grades,mdl_grade_items
                where mdl_grade_items.id = itemid and itemname!='NULL' and userid=".$userID." "
                . "and courseid=".$cId.";";

        $result = $conn->query($sql);
        $ret_val = array();
        $i = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ret_val[$i] = $row["itemname"];
                $i++;
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }
}
