<?php
include_once('./_common.php');
if ($write['wr_is_comment'])
alert_close('코멘트는 스크랩 할 수 없습니다.');

$sql = " select count(*) as cnt from {$g5['scrap_table']}
        where mb_id = '{$member['mb_id']}'
        and bo_table = '$bo_table'
        and wr_id = '$wr_id' ";
$row = sql_fetch($sql);
if($row['cnt']){
    echo '{"is_scrap" : "true", "back_url" : "'.$back_url.'"}';
    exit;
}else{
    echo '{"is_scrap" : "false", "back_url" : "'.$back_url.'"}';
}