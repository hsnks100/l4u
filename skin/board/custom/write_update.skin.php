<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가


function getR($table, $id) {
    $sql = "SELECT * FROM $table WHERE mb_id = '$id'";
    $row = sql_fetch($sql);
    return $row['mb_1'];
}


function getIdByName($table, $name) {

    $sql = "SELECT * FROM $table WHERE mb_name = '$name'";
    $row = sql_fetch($sql);
    return $row['mb_id'];
    $names = array();
    $names[0] = $players[0]['Name'];
    $names[1] = $players[1]['Name'];
    return $names;

}
function getWinnerIndex($root) {
    $winner = $root['Computed']['WinnerTeam'];
    return $winner;
}

if(!$wr_comment) {  // 코멘일때는 저장하면 안됩.
    $cmd ="/volume1/web/l4u/screp " . $dest_file;
    $output = shell_exec($cmd);
    $root = json_decode($output, true);
    $table = $g5['member_table'];

    $repHeader = $root['Header'];
    $players = $repHeader['Players'];

    $winnerIndex = getWinnerIndex($root) - 1;
    // print_r($root);
    echo "winnerIndex: $winnerIndex";
    $player1Id = getIdByName($table, $players[0]['Name']);
    $player2Id = getIdByName($table, $players[1]['Name']);
    echo "player1: $player1Id, player2: $player2Id <br />";
    if ($winnerIndex != 0) {
        $temp = $player1Id;
        $player1Id = $player2Id;
        $player2Id = $temp;
    }

    echo "player1: $player1Id, player2: $player2Id";

    $Ra = getR($g5['member_table'], $player1Id);
    $Rb = getR($g5['member_table'], $player2Id);

    $K = 20;
    $Ea = 1.0/(1.0 + pow(10.0, ($Rb - $Ra)/600.0));
    $Eb = 1.0/(1.0 + pow(10.0, ($Ra - $Rb)/600.0));
    $Ra2 = $Ra + $K * (1 - $Ea);
    $Rb2 = $Rb + $K * (0 - $Eb);


    $sql = "update $table set mb_1 = '$Ra2' where mb_id = '$player1Id'";
    sql_query($sql);

    $sql = "update $table set mb_1 = '$Rb2' where mb_id = '$player2Id'";
    sql_query($sql);

    $winName = $players[$winnerIndex]['Name'];
    $sql = " update $write_table
                set wr_content = '<p>$winName 승!</p>', wr_subject = '{$players[0]['Name']}[{$players[0]['Race']['Name']}] vs {$players[1]['Name']}[{$players[1]['Race']['Name']}] [{$repHeader['Map']}]', wr_1 = '$player1Id', wr_2 = '$player2Id', wr_3 = '$Ra2', wr_4 = '$Rb2'where wr_id = '$wr_id' " ;

    sql_query($sql);
}
