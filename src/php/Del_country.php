<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 13.06.18
 * Time: 17:23
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


function del_country($country) {

        function del_record($country_id){

            global $mysqli;

            $query = "DELETE FROM countries  WHERE id=".$country_id.";";
            $res = $mysqli->query($query);
            if ($res==FALSE) {return NULL;} else {return TRUE;}
        }

        global $return;

        $country_is = query_find_field('countries', 'country_name', $country, 'id');

        if ($country_is != NULL && $country !=null) {

            $child_region_is = query_find_field('regions', 'id_country', $country_is, 'region_name');
            
            if ($child_region_is === NULL) {

                $try_del = del_record($country_is);

                if ($try_del === True) {

                    $return->answer = TRUE;
                    $return->result = $country;
                    $return->message = 'Country  ' . $country . ' successfully deleted';
                    return $return;

                   } else {

                    $return->answer = FALSE;
                    $return->result = $country_is;
                    $return->message = 'Something was wrong! Country ' . $country . ' not deleted';
                   };
                return $return;

            } else {

                $return->answer = FALSE;
                $return->result = $child_region_is;
                $return->message = 'Can`t delete country! Country ' . $country . ' have regions';
                return $return;
            }
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="Country ".$country." not find!";
            return $return;
        }

    }


$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");
$return = new return_message();


$_POST['Content-Type'] = "application/json";

$country = $_POST['item'];

$return = del_country($country);

echo json_encode($return);

exit;

?>
