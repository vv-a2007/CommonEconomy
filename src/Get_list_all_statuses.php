<?php
/**
 * Created by PhpStorm.
 * User: vladimiranokhin
 * Date: 19.06.18
 * Time: 13:46
 */
global $mysqli;

$mysqli = new mysqli("localhost:3306", "vladimiranokhin", "vladimir2071654", "SiteCollection");

$answer = array ();
$status = array ();

$query = "SELECT * FROM site_status ORDER BY id";
$res = $mysqli->query($query);

if ($res !== FALSE) {

    $res->data_seek(0);

    $value = 0;
    $status['text'] ="";
    $status['id_status'] = 0;
    $status['value'] = $value; $value++;
    $answer[] = $status;

    while ($row = $res->fetch_assoc()){

        $status['text'] = $row['status_name'];
        $status['id_status'] = $row['id'];
        $status['value'] = $value; $value++;
        $answer[] = $status;


    }} else {
    $answer[] = "";

}

$json_string = json_encode($answer);

echo $json_string;

?>