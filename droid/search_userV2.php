<?php

/**
 * Description of users
 * Using similar_text()
 * @author Buddhi Wickramasinghe
 */
$entered_name = (string) $_GET['name'];

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
while ($row = $result->fetch_assoc()) {

    $ret_name = $row['lastname'];

    $ret_name_u = strtoupper($ret_name);
    $entered_name_u = strtoupper($entered_name);
    
    similar_text($ret_name_u, $entered_name_u, $percent);
    echo $ret_name . " " . $percent . "<br></br>";

    if ($percent >= 70.0) {
        $closest_list[$i] = $row['firstname'] . " " . $row['lastname'] . " " . $row['username'];
        $i = $i + 1;
    }
}

if (count($closest_list) > 0) {

    foreach ($closest_list as $close) {
        echo $close . "<br>";
    }
} else {
    echo "No matches found";
}

  //mdl_role_assignments 