<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of grades
 *
 * @author Malin Prematilake
 */
class grades {
    var $status;
    var $course;
    var $id;
    var $finalGrade;
    var $testName;
    
    function grades($id, $course, $testName){//auto gen the id
        $this->id = $id;
        $this->course = $course;
        $this->testName = $testName;             
    }
    
    function get_grade($conn,$userID){
        $cId = $this->course;
        $itName = $this->testName;
        
        $sql = "select finalgrade
                from mdl_grade_grades,mdl_grade_items
                where mdl_grade_items.id = itemid and itemname!='NULL' and userid=".$userID." "
                . "and courseid=".$cId." and itemname=".$itName.";";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $ret_val = $row["finalgrade"];
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }
}
