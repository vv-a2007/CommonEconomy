<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 15.06.18
 * Time: 15:08
 */
global $mysqli;

class return_message {
    public $answer=NULL;
    public $result=NULL;
    public $message=NULL;
}

function query_find_field($table_name, $search_by_field, $search_value, $return_field){
    global $mysqli;
    if ((gettype($search_value) == "integer") || (gettype($search_value) == "double")) {
        $query = "SELECT * FROM ".$table_name." WHERE " . $search_by_field . " = ".$search_value.";";
    } else {
        $query = "SELECT * FROM ".$table_name." WHERE " . $search_by_field . " = '".$search_value."';";
    }
    $res = $mysqli->query($query);
    if ($res != FALSE) { $row = $res->fetch_assoc(); return $row[$return_field];} else {return NULL;}
}


function del_region($region) {

    function del_record($region_id){

        global $mysqli;

        $query = "DELETE FROM regions  WHERE id=".$region_id.";";
        $res = $mysqli->query($query);
        if ($res==FALSE) {return NULL;} else {return TRUE;}
    }

    global $return;

    $region_is = query_find_field('regions', 'region_name', $region, 'id');

    if ($region_is != NULL && $region !=null) {

        $child_city_is = query_find_field('cities', 'id_region', $region_is, 'city_name');

        if ($child_city_is === NULL) {

            $try_del = del_record($region_is);

            if ($try_del === True) {

                $return->answer = TRUE;
                $return->result = $region;
                $return->message = 'Region  ' . $region . ' successfully deleted';
                return $return;

            } else {

                $return->answer = FALSE;
                $return->result = $region_is;
                $return->message = 'Something was wrong! Region ' . $region . ' not deleted';
            };
            return $return;

        } else {

            $return->answer = FALSE;
            $return->result = $child_city_is;
            $return->message = 'Can`t delete region! Region ' . $region . ' have cities';
            return $return;
        }
    }
    else {
        $return->answer=FALSE; $return->result=NULL; $return->message=" Region ".$region." not find!";
        return $return;
    }

}


$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");
$return = new return_message();


$_POST['Content-Type'] = "application/json";

$region = $_POST['item'];

$return = del_region($region);

echo json_encode($return);

exit;

?>
