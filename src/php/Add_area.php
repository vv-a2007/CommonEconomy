<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 15.06.18
 * Time: 17:40
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


function add_area($area,$city_id){
    {
        function add_record($area,$city_id,$region_id,$country_id){
            global $mysqli;

            global $region_id;
            global $country_id;


            $query = "INSERT HIGH_PRIORITY INTO areas SET area_name='".$area."', id_city=".$city_id.", id_region=".$region_id.", id_country=".$country_id.";";
            $res = $mysqli->query($query);
            $id = mysqli_insert_id($mysqli);
            if ($res==FALSE) {return NULL;} else {return $id;}
        }

        global $return;
        global $region_id;
        global $country_id;


        $area_is = query_find_field('areas', 'area_name', $area, 'area_name');

        if ($area_is == NULL) {
            if ($city_id != 0) {
                $city_is = query_find_field('cities', 'id', $city_id, 'city_name');
                if ($city_is != null) {
                    $region_id = query_find_field('cities', 'id', $city_id, 'id_region');
                    $country_id = query_find_field('cities', 'id', $city_id, 'id_country');

                    if (($region_id != null)&&($country_id != null)){
                            $id_eniti = add_record($area, $city_id,$region_id,$country_id);
                    } else {
                        $return->answer = FALSE;
                        $return->result = NULL;
                        $return->message = 'Parent country or region not found! Area ' . $area . ' not added';
                    }
                    if ($id_eniti != NULL) {
                        $return->answer = TRUE;
                        $return->result = $id_eniti;
                        $return->message = 'Area  ' . $area . ' successfully added';
                    } else {
                        $return->answer = FALSE;
                        $return->result = NULL;
                        $return->message = 'Something was wrong! Area ' . $area . ' not added';
                    };
                } else {
                    $return->answer = FALSE;
                    $return->result = NULL;
                    $return->message = 'Parent city not found! Area ' . $area . ' not added';
                }
            } else {
                $return->answer = FALSE;
                $return->result = NULL;
                $return->message = 'Not allowed area without parent city!';
            };
            return $return;
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="Area ".$area." not added, because exist yet!";
            return $return;
        }

    }

}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$return = new return_message();

$_POST['Content-Type'] = "application/json";
// принимаем данные отправленные POST
$area = $_POST['item'];
$city_id = $_POST['parent_id'];

$return = add_area($area,$city_id);

echo json_encode($return);

exit;

?>
