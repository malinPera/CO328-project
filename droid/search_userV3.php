<?php

/**
 * Description of users
 * Using similar_text()
 * Including AJAX
 * @author Buddhi Wickramasinghe
 */
//$entered_name = (string) $_GET['name'];

// get the q parameter from URL
$entered_name = $_REQUEST["q"];

$servername = "127.0.0.1:444";
$username = "root";
$password = "926140795v";
$dbname = "bitnami_moodle";

$conn = new mysqli($servername, $username, $password, $dbname);



echo "To be searched: " . $entered_name . "<br>";

$sql = "select * from mdl_user;";

$result = $conn->query($sql);

$percent;

$closest_list = array();
$i = 0;

// output data of each row
/*while ($row = $result->fetch_assoc()) {

    $ret_name = $row['lastname'];

    $ret_name_u = strtoupper($ret_name);
    $entered_name_u = strtoupper($entered_name);

    similar_text($ret_name_u, $entered_name_u, $percent);
    echo $ret_name . " " . $percent . "<br></br>";

    if ($percent >= 70.0) {
        $closest_list[$i] = $row['firstname'] . " " . $row['lastname'] . " " . $row['username'];
        $i = $i + 1;
    }
}*/



$hint = "";

// lookup all hints from array if $q is different from "" 
if ($entered_name !== "") {
    $entered_name = strtolower($entered_name);
    $len = strlen($entered_name);
    
    while ($row = $result->fetch_assoc()) {

    //$ret_name = $row['lastname'];
     $ret_name = strtolower($row['lastname']);
    //substr($name, 0, $len)
            
    similar_text( substr($ret_name, 0, $len), $entered_name, $percent);  
          
        if ($percent >= 70.0) {
            
            $fullname = $row['firstname']." ".$row['lastname'];
            
            if ($hint === "") {
                $hint = $fullname;
                $n = 0;
                $hint = '<a href="../mod/assign/view.php?id=' . $n . ' ">' . $hint . "</a>";
            } else {
                $hint .= ', <a href="../mod/assign/view.php?id=' . $n . ' ">' . $fullname . "</a>";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "no suggestion" : $hint;
