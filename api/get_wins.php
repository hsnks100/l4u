<?php

include_once('../common.php');
header('Content-Type: application/json; charset=UTF-8');

$myid = $_GET["id"];
$sql_common = " from " . $g5['write_prefix'] . "ksooboard";
$sql = " select count(*) as cnt {$sql_common} where wr_1 = '$myid'";
$row = sql_fetch($sql);

$wins = $row['cnt'];

$sql = " select count(*) as cnt {$sql_common} where wr_2 = '$myid'";
$row = sql_fetch($sql);
$loses = $row['cnt'];



$mytemp = json_encode( array($wins + 0, $loses + 0), JSON_UNESCAPED_UNICODE);
echo $mytemp;
?>
