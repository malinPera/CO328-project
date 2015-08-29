<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
}
