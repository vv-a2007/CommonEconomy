<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 20.06.18
 * Time: 18:57
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


function add_postcode($postcode,$region_id){
    {
        function add_record($postcode,$region_id,$country_id){
            global $mysqli;
            $query = "INSERT HIGH_PRIORITY INTO postcodes SET postcode='".$postcode."', id_region=".$region_id.", id_country=".$country_id.";";
            $res = $mysqli->query($query);
            $id = mysqli_insert_id($mysqli);
            if ($res==FALSE) {return NULL;} else {return $id;}
        }

        global $return;

        $postcode_is = query_find_field('postcodes', 'postcode', $postcode, 'postcode');

        if ($postcode_is == NULL) {
            if ($region_id != 0) {
                $region_is = query_find_field('regions', 'id', $region_id, 'region_name');
                if ($region_is != null) {
                    $country_id = query_find_field('regions', 'id', $region_id, 'id_country');
                    if ($country_id != null) {
                        $id_eniti = add_record($postcode, $region_id,$country_id);
                    }
                    else{
                        $return->answer = FALSE;
                        $return->result = NULL;
                        $return->message = 'Parent country not found! Postcode ' . $postcode . ' not added';
                    }
                    if ($id_eniti != NULL) {
                        $return->answer = TRUE;
                        $return->result = $id_eniti;
                        $return->message = 'Postcode  ' . $postcode . ' successfully added';
                    } else {
                        $return->answer = FALSE;
                        $return->result = NULL;
                        $return->message = 'Something was wrong! Postcode ' . $postcode . ' not added';
                    };
                } else {
                    $return->answer = FALSE;
                    $return->result = NULL;
                    $return->message = 'Parent not found! Postcode ' . $postcode . ' not added';
                }
            } else {
                $return->answer = FALSE;
                $return->result = NULL;
                $return->message = 'Not allowed to enter postcode without parent region!';
            };
            return $return;
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="Postcode ".$postcode." not added, because exist yet!";
            return $return;
        }

    }

}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$return = new return_message();

$_POST['Content-Type'] = "application/json";

$postcode = $_POST['item'];
$region_id = $_POST['parent_id'];

$return = add_postcode($postcode,$region_id);

echo json_encode($return);

exit;

?>
