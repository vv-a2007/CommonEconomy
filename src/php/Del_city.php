<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 15.06.18
 * Time: 15:51
 */
global $mysqli;
if (!headers_sent()) {
    header('Access-Control-Allow-Origin: *');
}
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


function del_city($city) {

    function del_record($city_id){

        global $mysqli;

        $query = "DELETE FROM cities  WHERE id=".$city_id.";";
        $res = $mysqli->query($query);
        if ($res==FALSE) {return NULL;} else {return TRUE;}
    }

    global $return;

    $city_is = query_find_field('cities', 'city_name', $city, 'id');

    if ($city_is != NULL && $city !=null) {

        $child_area_is = query_find_field('areas', 'id_city', $city_is, 'area_name');

        if ($child_area_is === NULL) {

            $try_del = del_record($city_is);

            if ($try_del === True) {

                $return->answer = TRUE;
                $return->result = $city;
                $return->message = 'City  ' . $city . ' successfully deleted';
                return $return;

            } else {

                $return->answer = FALSE;
                $return->result = $city_is;
                $return->message = 'Something was wrong! City ' . $city . ' not deleted';
            };
            return $return;

        } else {

            $return->answer = FALSE;
            $return->result = $child_area_is;
            $return->message = 'Can`t delete city! City ' . $city . ' have areas';
            return $return;
        }
    }
    else {
        $return->answer=FALSE; $return->result=NULL; $return->message=" City ".$city." not find!";
        return $return;
    }

}


$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");
$return = new return_message();


$_POST['Content-Type'] = "application/json";

$city = $_POST['item'];

$return = del_city($city);

echo json_encode($return);

exit;

?>
