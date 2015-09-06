<?php
/**
 * This is the class for the notifications
 *
 * @author Malin Prematilake
 */
class event {
    
    var $course;
    
    function event($course){
        $this->course = $course;
    }
    
    function get_module_name($conn, $nameD){
        $sql = "select id from mdl_modules
			where name=".$nameD.";";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ret_val = $row["id"];
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }
    
    function get_all_events($conn){
        $crse = $this->course;
        $sql = "select id,instance,module from mdl_course_modules
			where course=".$crse.";";
        
	$result = $conn->query($sql);
	
        $return_val = array();
        
        $assigns = array();
        $i1 = 0;
        $quizzes = array();
        $i2 = 0;
        $urls = array();
        $i3 = 0;
        $resources = array();
        $i4 = 0;
        $forums = array();
        $i5 = 0;
     
	if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $type=$row["module"];
                switch($type){
                    case 1:
                        $a1[0] = $row["id"];
                        $a1[1] = $row["instance"];
                        $assigns[$i1] = $a1;
                        $i1++;
                        break;
                    case 9:
                        $f1[0] = $row["id"];
                        $f1[1] = $row["instance"];
                        $forums[$i5] = $f1;
                        $i5++;
                        break;
                    case 16:
                        $q1[0] = $row["id"];
                        $q1[1] = $row["instance"];
                        $quizzes[$i2] = $q1;
                        $i2++;
                        break;
                    case 20:
                        $u1[0] = $row["id"];
                        $u1[1] = $row["instance"];
                        $urls[$i3] = $u1;
                        $i3++;
                        break;
                    case 17:
                        $r1[0] = $row["id"];
                        $r1[1] = $row["instance"];
                        $resources[$i4] = $r1;
                        $i4++;
                        break;
                    default:
                        break;
                }
            }
            $return_val[0] = $assigns;
            $return_val[1] = $forums;
            $return_val[2] = $quizzes;
            $return_val[3] = $urls;
            $return_val[4] = $resources;
        } else {
		$return_val=0;
	}   
        return $return_val;
    }
}
