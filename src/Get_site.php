<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 29.05.18
 * Time: 17:58
 */
global $mysqli;

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();

$query = "SELECT seller_sites.*, site_status.status_name FROM seller_sites JOIN site_status ON seller_sites.id_site_status = site_status.id  WHERE seller_sites.id=".$_GET['id'].";";
$res = $mysqli->query($query);
if ($res !== FALSE) {

    $res->data_seek(0);
    $row = $res->fetch_assoc();

    $answer['id'] = $row['id'];
    $answer['site_name'] = $row['site_name'];
    $answer['cart_path'] = $row['cart_path'];
    $answer['border_item_search'] = $row['border_item_search'];
    $answer['position_item_search'] = $row['position_item_search'];
    $answer['item_structure'] = $row['item_structure'];
    $answer['id_site_status'] = $row['id_site_status'];
    $answer['id_root_location'] = $row['id_root_location'];
    $answer['status']=$row['status_name'];
} else {
    $answer['id'] = null;
    $answer['site_name'] = "";
    $answer['cart_path'] = "";
    $answer['border_item_search'] = "";
    $answer['position_item_search'] = "";
    $answer['item_structure'] = "";
    $answer['id_site_status'] = null;
    $answer['id_root_location'] = null;
    $answer['status']="";
}

$json_string = json_encode($answer);

echo $json_string;

?>