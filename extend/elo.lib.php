<?

add_event('write_update_before', 'fn_write_update_before', 0, 1);
add_event('bbs_delete', 'fn_bbs_delete', 0, 2);

function lastElo($myid) {
    global $g5;
    $sql_common = " from " . "{$g5['write_prefix']}elo_reg";
    $sql = " select wr_1, wr_2, wr_3, wr_4, wr_datetime {$sql_common} where wr_1 = '$myid' or wr_2 = '$myid' order by wr_datetime desc";
    $result = sql_query($sql);

    for ($i=0; $row=sql_fetch_array($result); $i++) {
        if ($i == 0) {
            if ($row['wr_1'] == $myid) {
                return $row['wr_3'];
            } else {
                return $row['wr_4'];
            }
        }
    }

    return 1500;
}
function fn_bbs_delete($write, $board) {
    global $g5;
    print_r($write);
    echo "...";
    print_r($board['bo_table']);
    // wr_1 에서 이전 점수 구하고, wr_2 의 이전점수 구하고 member 업데이트!
    if ($board['bo_table'] == "elo_reg") {
        $before1 = lastElo($write['wr_1']);
        $before2 = lastElo($write['wr_2']);
        sql_query("update {$g5['member_table']} set mb_1 = '$before1' where mb_id = '{$write['wr_1']}'");
        sql_query("update {$g5['member_table']} set mb_1 = '$before2' where mb_id = '{$write['wr_2']}'");
    }
    // $myid = $_GET["id"];
    // $sql_common = " from " . "{$g5['write_prefix']}elo_reg";
    // $sql = " select wr_1, wr_2, wr_3, wr_4, wr_datetime {$sql_common} where wr_1 = '$myid' or wr_2 = '$myid' order by wr_datetime desc";
    // $result = sql_query($sql);

    // $arr = array();
    // $dateArr = array();
    // for ($i=0; $row=sql_fetch_array($result); $i++) {
    //     if ($row['wr_1'] == $myid) {
    //         array_unshift($arr, $row['wr_3']);
    //     } else {
    //         array_unshift($arr, $row['wr_4']);
    //     }
    //     array_unshift($dateArr, $row['wr_datetime']);
    // }
}
function checkReplay($root, $table) {
    $repHeader = $root['Header'];
    $mapType = $repHeader['Type']['ShortName'];
    $mapName = $repHeader['Map'];
    $players = $repHeader['Players'];
    $player1 = $players[0];
    $player2 = $players[1];
    $winner = $root['Computed']['WinnerTeam'];
    $chats = $root['Computed']['ChatCmds'];

    $declareElo = array();
    foreach($chats as &$value) {
        if ($value['Message'] == "elo") {
            $declareElo[$value['SenderSlotID']]++;
        }
    }

    $eloCount = count($declareElo);
    $sql = "SELECT * FROM $table WHERE mb_nick = '{$player1['Name']}' or mb_nick = '{$player2['Name']}'";
    $result = sql_query($sql);
    $matchs = sql_num_rows($result);

    $valid = "";
    if ($matchs != 2) {
        $valid .= "1. 클랜 홈페이지 닉네임과 스타 닉네임을 통일시켜주세요.<br />";
    }
    // if ($eloCount != 2) {
    //     $valid .= "2. 양 플레이어가 \"elo\" 라고 게임중에 외쳐야 합니다.<br />";
    // }

    if ($mapType != "1v1") {
        // $valid .= "3. 맵 타입이 1대1 이어야 합니다.<br />";
    }
    return $valid;
}
function fn_write_update_before($board) {
    if ($_REQUEST['w'] == 'u') {
        echo "수정은 불가합니다.";
        exit(-1);
    }
    if ($board['bo_skin'] == "custom") {
        global $g5;
        // print_r($_FILES);
        $file_count   = 0;
        $upload_count = (isset($_FILES['bf_file']['name']) && is_array($_FILES['bf_file']['name'])) ? count($_FILES['bf_file']['name']) : 0;

        for ($i=0; $i<$upload_count; $i++) {
            if($_FILES['bf_file']['name'][$i] && is_uploaded_file($_FILES['bf_file']['tmp_name'][$i]))
                $file_count++;
        }
        if ($file_count != 0) {
            $ggg = $_FILES['bf_file']['tmp_name'];
            $cmd ="/volume1/web/l4u/screp " . $ggg[0];
            $output = shell_exec($cmd);
            $root = json_decode($output, true);
            $table = $g5['member_table'];
            $valid = checkReplay($root, $table);
        } else {
            $valid .= "파일 업로드 해주세요.<br />";
        }
        // $valid = "";
        if ($valid != "") {
            echo "$valid";
            exit(-1);
        }
    }

    // $write_table = $g5['write_prefix'].$board['bo_table'];

    // $sql = " SHOW COLUMNS FROM `{$write_table}` LIKE 'wr_option' ";
    // $row = sql_fetch($sql);

    // $sql_sets = $change_sets = explode(",", str_replace(array("set(", ")", "'"), "", $row['Type']));

    // if( ! in_array('text', $sql_sets) ){
    //     $change_sets[] = 'text';
    // }

    // if( ! in_array('markdown_text', $sql_sets) ){
    //     $change_sets[] = 'markdown_text';

    // }

    // if( $sql_sets !== $change_sets ){
    //     $sql = " ALTER TABLE `{$write_table}` CHANGE `wr_option` `wr_option` set('".implode("','", $change_sets)."') NOT NULL DEFAULT '' ";

    //     sql_query($sql, false);

    // }


}
