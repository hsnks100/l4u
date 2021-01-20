<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);

$sql_common = " from " . "{$g5['write_prefix']}ksooboard";

$myid = $member['mb_id'];
$sql = " select wr_1, wr_2, wr_3, wr_4, wr_datetime {$sql_common} where wr_1 = '$myid' or wr_2 = '$myid' order by wr_datetime desc";
$result = sql_query($sql);

// echo "myid: $myid<br />";
// echo "sql: $sql<br />";


$arr = array();
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($row['wr_1'] == $myid) {
        array_unshift($arr, $row['wr_3']);
    } else {
        array_unshift($arr, $row['wr_4']);
    }
}


?>

<article id="ctt" class="ctt_<?php echo $co_id; ?>">
    <header>
        <h1><?php echo $g5['title']; ?></h1>
    </header>

    <div id="ctt_con">
        <?php echo $str; ?>
        <?php
            $sep = "=>";
            for ($i=0; $i<count($arr); $i++) {
                if ($i == count($arr) - 1) {
                    $sep = '';
                }
                echo "{$arr[$i]} $sep";

            }
            // print_r($arr);
        ?>
    </div>

</article>
