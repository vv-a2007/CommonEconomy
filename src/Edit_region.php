<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 21.06.18
 * Time: 15:20
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


function edit_region($region,$region_id){
    {
        function edit_record($region,$region_id){
            global $mysqli;
            $query = "UPDATE regions SET region_name ='".$region."' WHERE id=".$region_id.";";
            $res = $mysqli->query($query);
            if ($res==FALSE) {return NULL;} else {return $region;}
        }

        global $return;

        $region_is = query_find_field('regions', 'id', $region_id, 'region_name');

        if ($region_is != NULL) {

            $id_eniti = edit_record($region,$region_id);
            if ($id_eniti != NULL) { $return->answer=TRUE; $return->result=$region; $return->message='Region  '.$region.' successfully changed';}
            else {$return->answer=FALSE; $return->result=NULL; $return->message='Something was wrong! Region '.$region.' not changed';};
            return $return;
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="Region ".$region." not found!";
            return $return;
        }

    }

}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$return = new return_message();

$_POST['Content-Type'] = "application/json";

$region = $_POST['item'];
$region_id = $_POST['id'];

$return = edit_region($region,$region_id);

echo json_encode($return);

exit;

?>