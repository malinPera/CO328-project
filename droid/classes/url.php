<?php

/**
 * Description of url
 *
 * @author Buddhi Wickramasinghe
 */
define("expiry", 1209600);

class url extends event {

    var $id;
    var $webid;

    function url($id, $webid) {

        $this->id = $id;
        $this->webid = $webid;
    }

    function get_timeModified($conn) {

        $id = $this->id;
        $sql = "select timemodified from mdl_url
			where id=" . $id . ";";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret_val = $row["timemodified"];
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }

    //Not needed
    function get_exLink($conn) {

        $id = $this->id;

        $sql = "select externalurl from mdl_url
                        where id=" . $id . ";";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret_val = $row["externalurl"];
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }

    function get_link($conn) {

        $id = $this->id;
        $webid = $this->webid;

        $sql = "select name from mdl_url
                        where id=" . $id . ";";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $n = $row["name"];
                $ret_val = 'Name: <a href="../mod/url/view.php?id=' . $webid . ' ">' . $n . "</a><br>";
            }
        } else {
            $ret_val = -1;
        }
        return $ret_val;
    }

}
