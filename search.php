<?php

/**
 * Description of users
 *
 * @author Buddhi Wickramasinghe
 */
//class search {

    function get_user($conn) {

      //  echo "ddddddddd<br>";
        $sql = "select * from mdl_user
			where SOUNDEX(`firstname`)=SOUNDEX('Malin');";

        
        //if($sql){
            $result = $conn->query($sql);
        //}
        //else{
         //   echo mysql_errno($conn) . ": " . mysql_error($conn) . "\n";
        //}
            

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $return_val = $row['lastname'];
            }
        }
        else{
            
            $return_val = 0;
        }
        return $return_val;
    }

//}
