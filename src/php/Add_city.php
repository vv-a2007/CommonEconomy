<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 15.06.18
 * Time: 15:41
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


function add_city($city,$region_id){
    {
        function add_record($city,$region_id,$country_id){
            global $mysqli;
            $query = "INSERT HIGH_PRIORITY INTO cities SET city_name='".$city."', id_region=".$region_id.", id_country=".$country_id.";";
            $res = $mysqli->query($query);
            $id = mysqli_insert_id($mysqli);
            if ($res==FALSE) {return NULL;} else {return $id;}
        }

        global $return;

        $city_is = query_find_field('cities', 'city_name', $city, 'city_name');

        if ($city_is == NULL) {
            if ($region_id != 0) {
                $region_is = query_find_field('regions', 'id', $region_id, 'region_name');
                if ($region_is != null) {
                    $country_id = query_find_field('regions', 'id', $region_id, 'id_country');
                    if ($country_id != null) {
                        $id_eniti = add_record($city, $region_id,$country_id);
                    }
                    else{
                        $return->answer = FALSE;
                        $return->result = NULL;
                        $return->message = 'Parent country not found! City ' . $city . ' not added';
                    }
                    if ($id_eniti != NULL) {
                        $return->answer = TRUE;
                        $return->result = $id_eniti;
                        $return->message = 'City  ' . $city . ' successfully added';
                    } else {
                        $return->answer = FALSE;
                        $return->result = NULL;
                        $return->message = 'Something was wrong! City ' . $city . ' not added';
                    };
                } else {
                    $return->answer = FALSE;
                    $return->result = NULL;
                    $return->message = 'Parent region not found! City ' . $city . ' not added';
                }
            } else {
                $return->answer = FALSE;
                $return->result = NULL;
                $return->message = 'Not allowed city without parent region!';
            };
            return $return;
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="City ".$city." not added, because exist yet!";
            return $return;
        }

    }

}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$return = new return_message();

$_POST['Content-Type'] = "application/json";
// принимаем данные отправленные POST
$city = $_POST['item'];
$region_id = $_POST['parent_id'];

$return = add_city($city,$region_id);

echo json_encode($return);

exit;

?>
