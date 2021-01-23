<?php
include_once('../common.php');
header('Content-Type: application/json; charset=UTF-8');
$table = $g5['member_table'];
$sql = "SELECT mb_id, mb_nick, mb_1 FROM $table";

$result = sql_query($sql);
$ret = array();
for ($i=0; $row=sql_fetch_array($result); $i++) {
    array_push($ret, $row);
}

echo json_encode($ret);
