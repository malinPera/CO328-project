<?php
/**
 * Description of submission
 *
 * @author Malin Prematilake
 */
define("expiry", 1209600);
class submission extends event {
    var $id;
    var $webid;
    
    function submission($id, $webid){
        $this->id = $id;
        $this->webid = $webid;
    }
    
    function added_time($conn){
        
        $id = $this->id;
        $sql = "select timemodified from mdl_assign
			where id=".$id.";";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ret_val = $row["timemodified"];
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }
    
    function get_dueDate($conn){
        
        $id = $this->id;
        $sql = "select duedate from mdl_assign
			where id=".$id.";";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ret_val = $row["duedate"];
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }
    
    function get_cutOffDate($conn){
        
        $id = $this->id;
        $sql = "select cutoffdate from mdl_assign
                        where id=".$id.";";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ret_val = $row["cutoffdate"];
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }
    
    function get_link($conn){
        
        $id = $this->id;
        $webid = $this->webid;
        
        $sql = "select name from mdl_assign
                        where id=".$id.";";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $n = $row["name"];
                $ret_val = 'Name: <a href="../mod/assign/view.php?id='.$webid.' ">'.$n."</a><br>";
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }
    
    function isSubmit($conn, $userid){
        
        $id = $this->id;
        $sql = "select status from mdl_assign_submission
			where userid=".$userid." and assignment=".$id.";";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $status = $row["status"];
            }
        }
        return $status;
    }
    
    function isExpired($conn, $timeC){
        
        $id = $this->id;
        $sql = "select cutoffdate from mdl_assign
                        where id=".$id.";";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ret_val = $row["cutoffdate"];
            }
            $diff = $timeC - $ret_val;
            if($diff>=expiry){
                $exp=TRUE;
            }
            else {
                $exp=FALSE;
            }
        } else {
            $exp=FALSE;
        }
        return $exp;
    }
}
