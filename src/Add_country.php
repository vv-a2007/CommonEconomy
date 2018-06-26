<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 13.06.18
 * Time: 14:45
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


function add_country($country){
    {
        function add_record($country){
            global $mysqli;
            $query = "INSERT HIGH_PRIORITY INTO countries SET country_name ='".$country."';";
            $res = $mysqli->query($query);
            $id = mysqli_insert_id($mysqli);
            if ($res==FALSE) {return NULL;} else {return $id;}
        }

        global $return;

        $country_is = query_find_field('countries', 'country_name', $country, 'country_name');

        if ($country_is == NULL) {

            $id_eniti = add_record($country);
            if ($id_eniti != NULL) { $return->answer=TRUE; $return->result=$id_eniti; $return->message='Country  '.$country.' successfully added';}
            else {$return->answer=FALSE; $return->result=NULL; $return->message='Something was wrong! Country '.$country.' not added';};
            return $return;
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="Country ".$country." not added, because exist yet!";
            return $return;
        }

    }

}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$return = new return_message();

$_POST['Content-Type'] = "application/json";
// принимаем данные отправленные POST
$country = $_POST['item'];

$return = add_country($country);

echo json_encode($return);

exit;

?>
