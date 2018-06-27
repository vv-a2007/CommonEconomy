<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 13.06.18
 * Time: 14:45
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


function edit_country($country,$country_id){
    {
        function edit_record($country,$country_id){
            global $mysqli;
            $query = "UPDATE countries SET country_name ='".$country."' WHERE id=".$country_id.";";
            $res = $mysqli->query($query);
            if ($res==FALSE) {return NULL;} else {return $country;}
        }

        global $return;

        $country_is = query_find_field('countries', 'id', $country_id, 'country_name');

        if ($country_is != NULL) {

            $id_eniti = edit_record($country,$country_id);
            if ($id_eniti != NULL) { $return->answer=TRUE; $return->result=$country; $return->message='Country  '.$country.' successfully changed';}
            else {$return->answer=FALSE; $return->result=NULL; $return->message='Something was wrong! Country '.$country.' not changed';};
            return $return;
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="Country ".$country." not found!";
            return $return;
        }

    }

}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$return = new return_message();

$_POST['Content-Type'] = "application/json";
// принимаем данные отправленные POST
$country = $_POST['item'];
$country_id = $_POST['id'];

$return = edit_country($country,$country_id);

echo json_encode($return);

exit;

?>
