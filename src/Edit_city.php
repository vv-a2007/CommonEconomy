<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 21.06.18
 * Time: 15:24
 */
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


function edit_city($city,$city_id){
    {
        function edit_record($city,$city_id){
            global $mysqli;
            $query = "UPDATE cities SET city_name ='".$city."' WHERE id=".$city_id.";";
            $res = $mysqli->query($query);
            if ($res==FALSE) {return NULL;} else {return $city;}
        }

        global $return;

        $city_is = query_find_field('cities', 'id', $city_id, 'city_name');

        if ($city_is != NULL) {

            $id_eniti = edit_record($city,$city_id);
            if ($id_eniti != NULL) { $return->answer=TRUE; $return->result=$city; $return->message='City  '.$city.' successfully changed';}
            else {$return->answer=FALSE; $return->result=NULL; $return->message='Something was wrong! City '.$city.' not changed';};
            return $return;
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="City ".$city." not found!";
            return $return;
        }

    }

}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$return = new return_message();

$_POST['Content-Type'] = "application/json";

$city = $_POST['item'];
$city_id = $_POST['id'];

$return = edit_city($city,$city_id);

echo json_encode($return);

exit;

?>
