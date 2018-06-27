<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 15.06.18
 * Time: 13:58
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


function add_region($region,$country_id){
    {
        function add_record($region,$country_id){
            global $mysqli;
            $query = "INSERT HIGH_PRIORITY INTO regions SET region_name='".$region."', id_country=".$country_id.";";
            $res = $mysqli->query($query);
            $id = mysqli_insert_id($mysqli);
            if ($res==FALSE) {return NULL;} else {return $id;}
        }

        global $return;

        $region_is = query_find_field('regions', 'region_name', $region, 'country_name');

        if ($region_is == NULL) {
            if ($country_id != 0) {
                $country_is = query_find_field('countries', 'id', $country_id, 'country_name');
                if ($country_is != null) {
                    $id_eniti = add_record($region, $country_id);
                    if ($id_eniti != NULL) {
                        $return->answer = TRUE;
                        $return->result = $id_eniti;
                        $return->message = 'Region  ' . $region . ' successfully added';
                    } else {
                        $return->answer = FALSE;
                        $return->result = NULL;
                        $return->message = 'Something was wrong! Region ' . $region . ' not added';
                    };
                } else {
                    $return->answer = FALSE;
                    $return->result = NULL;
                    $return->message = 'Parent not found! Region ' . $region . ' not added';
                }
            } else {
                $return->answer = FALSE;
                $return->result = NULL;
                $return->message = 'Not allowed region without parent country!';
            };
            return $return;
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="Region ".$region." not added, because exist yet!";
            return $return;
        }

    }

}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$return = new return_message();

$_POST['Content-Type'] = "application/json";
// принимаем данные отправленные POST
$region = $_POST['item'];
$country_id = $_POST['parent_id'];

$return = add_region($region,$country_id);

echo json_encode($return);

exit;

?>
