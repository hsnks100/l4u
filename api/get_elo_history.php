<?php

include_once('../common.php');
header('Content-Type: application/json; charset=UTF-8');

$myid = $_GET["id"];
$sql_common = " from " . "{$g5['write_prefix']}elo_reg";
$sql = " select wr_1, wr_2, wr_3, wr_4, wr_datetime {$sql_common} where wr_1 = '$myid' or wr_2 = '$myid' order by wr_datetime desc";
$result = sql_query($sql);

$arr = array();
$dateArr = array();
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($row['wr_1'] == $myid) {
        array_unshift($arr, $row['wr_3']);
    } else {
        array_unshift($arr, $row['wr_4']);
    }
    array_unshift($dateArr, $row['wr_datetime']);
}
$obj = array();
$obj["elo"] = $arr;
$obj["date"] = $dateArr;

echo json_encode( $obj);
?>
