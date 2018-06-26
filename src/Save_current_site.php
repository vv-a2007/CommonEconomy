<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 19.06.18
 * Time: 17:26
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


function edit_site($check_loc){
    {
        function edit_record($site_id,$check_loc){

            global $mysqli;
            global $new_location_id;


            switch ($check_loc) {
                case "del" :
                    $query = "DELETE FROM locations WHERE id=".$_POST['id_location'].";";
                    $res = $mysqli->query($query);
                    if ($res != FALSE) {$new_location_id=0;} else {$new_location_id=$_POST['id_location'];};
                    break;

                case "edit" :
                    $query = "UPDATE locations SET id_country=".$_POST['id_country'].", id_region=".$_POST['id_region'].", id_city=".$_POST['id_city'].", id_area=".$_POST['id_area'].", id_postcode=".$_POST['id_postcode'].", address='".$_POST['address']."' WHERE id=".$_POST['id_location'].";";
                    $res = $mysqli->query($query);

                    break;

                case "new" :
                    $query ="INSERT HIGH_PRIORITY INTO locations SET id_country=".$_POST['id_country'].", id_region=".$_POST['id_region'].", id_city=".$_POST['id_city'].", id_area=".$_POST['id_area'].", id_postcode=".$_POST['id_postcode'].", address='".$_POST['address']."';";
                    $res = $mysqli->query($query);
                    if ($res != FALSE) {$new_location_id = mysqli_insert_id($mysqli);} else {$new_location_id=0;};
                    break;

                case "not" :
                    $new_location_id=0;
                    break;
            }

            $query1 = "UPDATE seller_sites SET site_name ='".$_POST['name']."', cart_path ='".$_POST['cart_path']."', border_item_search ='".$_POST['border']."', position_item_search ='".$_POST['position']."', item_structure = '".$_POST['structure']."', id_site_status = ".$_POST['id_status'].", id_root_location = ".$new_location_id."  WHERE id=".$site_id.";";
            $res1 = $mysqli->query($query1);
            if ($res1 == FALSE) {return NULL;} else {return TRUE;}
        }

        global $return;
        global $site_id;

        $site_is = query_find_field('seller_sites', 'id', $site_id, 'site_name');

        if ($site_is != NULL) {

            $id_eniti = edit_record($site_id, $check_loc);

            if ($id_eniti != NULL) { $return->answer=TRUE; $return->result=$site_is; $return->message='Site  '.$site_is.' successfully changed';}
            else {$return->answer=FALSE; $return->result=NULL; $return->message='Something was wrong! Site '.$site_is.' not changed';};
            return $return;
        }
        else {
            $return->answer=FALSE; $return->result=NULL; $return->message="Site ".$_POST['name']." not found!";
            return $return;
        }

    }

}

function check_location (){
    if ($_POST['id_location']>0) {
        if (($_POST['id_country']>0)||($_POST['id_region']>0)||($_POST['id_city']>0)||($_POST['id_area']>0)||($_POST['id_postcode']>0)||($_POST['address']!= "")) {return "edit";}
          else {
            return "del";
          }
    }
    else {
        if (($_POST['id_country'] > 0) || ($_POST['id_region'] > 0) || ($_POST['id_city'] > 0) || ($_POST['id_area'] > 0) || ($_POST['id_postcode'] > 0) || ($_POST['address'] != "")) {
            return "new";
        } else {
            return "not";
          }
    }
}

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$return = new return_message();

$_POST['Content-Type'] = "application/json";

$site_id = $_POST['id'];

$check_loc = check_location();

$new_location_id = $_POST['id_location'];

$return = edit_site($check_loc);

echo json_encode($return);

exit;

?>
