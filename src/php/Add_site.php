<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 15.03.18
 * Time: 13:37
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


function add_site($site){
    {
        function add_record($site){
           global $mysqli;
           $query = "INSERT HIGH_PRIORITY INTO seller_sites SET site_name ='".$site."', id_site_status = 1 ;";
           $res = $mysqli->query($query);
           $id = mysqli_insert_id($mysqli);
           if ($res==FALSE) {return NULL;} else {return $id;}
}


        global $mysqli;
        $return = new return_message();
        $site_is = query_find_field('seller_sites', 'site_name', $site, 'site_name');


        if ($site_is == NULL && $site !="") {

                $id_eniti = add_record($site);
                if ($id_eniti != NULL) { $return->answer=TRUE; $return->result=$site; $return->message='Site  '.$site.' successfully added';}
                else {$return->answer=FALSE; $return->result=NULL; $return->message='Something was wrong! Site '.$site.' not added';};
                return $return;
            }
            else {
                $return->answer=FALSE; $return->result=NULL; $return->message="Site ".$site." not added, because exist yet or empty!";
                return $return;
            }

    }

}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$_POST['Content-Type'] = "application/json";
// принимаем данные отправленные POST
$site = $_POST['site'];

$return = add_site($site);

echo json_encode($return);

exit;

?>
