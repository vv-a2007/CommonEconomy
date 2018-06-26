<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 15.06.18
 * Time: 17:37
 */
global $mysqli;

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


function del_area($area) {

    function del_record($area_id){

        global $mysqli;

        $query = "DELETE FROM areas  WHERE id=".$area_id.";";
        $res = $mysqli->query($query);
        if ($res==FALSE) {return NULL;} else {return TRUE;}
    }

    global $return;

    $area_is = query_find_field('areas', 'area_name', $area, 'id');

    if ($area_is != NULL && $area !=null) {

            $try_del = del_record($area_is);

            if ($try_del === True) {

                $return->answer = TRUE;
                $return->result = $area;
                $return->message = 'Area  ' . $area . ' successfully deleted';
                return $return;

            } else {

                $return->answer = FALSE;
                $return->result = $area_is;
                $return->message = 'Something was wrong! Area ' . $area . ' not deleted';
            };
            return $return;


    }
    else {
        $return->answer=FALSE; $return->result=NULL; $return->message=" Area ".$area." not find!";
        return $return;
    }

}


$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");
$return = new return_message();


$_POST['Content-Type'] = "application/json";

$area = $_POST['item'];

$return = del_area($area);

echo json_encode($return);

exit;

?>
