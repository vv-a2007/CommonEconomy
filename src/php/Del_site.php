<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 08.06.18
 * Time: 11:24
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


function del_site($site_id){
    {
        function del_record($site_id){
            global $mysqli;
            $query = "UPDATE seller_sites SET id_site_status = 99 WHERE id ='".$site_id."';";
            $res = $mysqli->query($query);
            if ($res==FALSE) {return NULL;} else {return TRUE;}
        }


        $return = new return_message();

        $site_is = query_find_field('seller_sites', 'id', $site_id, 'site_name');

        if ($site_is != NULL && $site_id !=null) {

            $try_del = del_record($site_id);

            if ($try_del === True) { $return->answer=TRUE; $return->result=$site_id; $return->message='Site  '.$site_is.' successfully deleted';}
            else {$return->answer=FALSE; $return->result=NULL; $return->message='Something was wrong! Site '.$site_is.' not deleted';};
            return $return;
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="Site ".$site_is." not deleted!";
            return $return;
        }

    }

}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$site_id = $_POST['id'];

$return = del_site($site_id);

echo json_encode($return);

exit;

?>
