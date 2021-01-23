<?php

include_once('../common.php');
header('Content-Type: application/json; charset=UTF-8');

$myid = $_GET["id"];
$t1 = $g5['member_table'];
$t2 = "{$g5['write_prefix']}elo_reg";
$sql_common = " from " . "$t1 ";
$sql = " select mb_id, mb_nick, mb_1, (select count(*) from $t2 where wr_1 = $t1.mb_id) as wins,  (select count(*) from $t2 where wr_2 = $t1.mb_id) as loses {$sql_common} where mb_1 <> '' order by mb_1 + 0 desc";
$result = sql_query($sql);


$dateArr = array();
for ($i=0; $row=sql_fetch_array($result); $i++) {
    array_push($dateArr, $row);
}

$mytemp = json_encode( $dateArr, JSON_UNESCAPED_UNICODE);
echo $mytemp;
?>
