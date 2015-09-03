<?php
/**
 * Description of quiz
 *
 * @author Buddhi Wickramasinghe
 */
define("expiry", 1209600);
class quiz extends event {
    var $id;
    var $webid;
    
    function quiz($id, $webid){
        $this->id = $id;
        $this->webid = $webid;
    }
	
	function get_timeOpen($conn){
	
		$id = $this->id;
        $sql = "select timeopen from mdl_quiz
			where id=".$id.";";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ret_val = $row["timeopen"];
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }
	
	function get_timeClose($conn){
	
		$id = $this->id;
        $sql = "select timeclose from mdl_quiz
			where id=".$id.";";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ret_val = $row["timeclose"];
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }
	
	function get_timelimit($conn){
	
		$id = $this->id;
        $sql = "select timelimit from mdl_quiz
			where id=".$id.";";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ret_val = $row["timelimit"];
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }
	
	 
	
	function get_attribute($conn,$attrName){
	
		$id = $this->id;
        $sql = "select ".$attrName. " from mdl_quiz
			where id=".$id.";";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ret_val = $row[$attrName];
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
	}
	
    function get_link($conn){
        
        $id = $this->id;
        $webid = $this->webid;
        
        $sql = "select name from mdl_quiz
                        where id=".$id.";";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $n = $row["name"];
                $ret_val = 'Name: <a href="../mod/quiz/view.php?id='.$webid.' ">'.$n."</a><br>";
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }
    
    function get_state($conn, $userid){
        
        $id = $this->id;
        $sql = "select state from mdl_quiz_attempts
			where userid=".$userid." and quiz=".$id.";";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $state = $row["state"];
            }
        }
        else
        {
            $state = "No attempts";
        }
        return $state;
            
    }
    
        
	
}
    