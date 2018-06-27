<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 21.06.18
 * Time: 15:28
 */
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


function edit_postcode($postcode,$postcode_id){
    {
        function edit_record($postcode,$postcode_id){
            global $mysqli;
            $query = "UPDATE postcodes SET postcode ='".$postcode."' WHERE id=".$postcode_id.";";
            $res = $mysqli->query($query);
            if ($res==FALSE) {return NULL;} else {return $postcode;}
        }

        global $return;

        $postcode_is = query_find_field('postcodes', 'id', $postcode_id, 'postcode');

        if ($postcode_is != NULL) {

            $id_eniti = edit_record($postcode,$postcode_id);
            if ($id_eniti != NULL) { $return->answer=TRUE; $return->result=$postcode; $return->message='Postcode  '.$postcode.' successfully changed';}
            else {$return->answer=FALSE; $return->result=NULL; $return->message='Something was wrong! Postcode '.$postcode.' not changed';};
            return $return;
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="Postcode ".$postcode." not found!";
            return $return;
        }

    }

}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$return = new return_message();

$_POST['Content-Type'] = "application/json";

$postcode = $_POST['item'];
$postcode_id = $_POST['id'];

$return = edit_postcode($postcode,$postcode_id);

echo json_encode($return);

exit;

?>
