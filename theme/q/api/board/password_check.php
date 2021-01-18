<?php
if ($w == 's') {
    $qstr = 'bo_table='.$bo_table.'&sfl='.$sfl.'&stx='.$stx.'&sop='.$sop.'&wr_id='.$wr_id.'&page='.$page;

    $wr = get_write($write_table, $wr_id);

    if( !$wr['wr_password'] && $wr['mb_id'] ){
        if ( $mb = get_member($wr['mb_id']) ){
            $wr['wr_password'] = $mb['mb_password'];
        }
    }

    if (!check_password($wr_password, $wr['wr_password'])) {
        run_event('password_is_wrong', 'bbs', $wr, $qstr);
        alert('비밀번호가 틀립니다.');
    }

    // 세션에 아래 정보를 저장. 하위번호는 비밀번호없이 보아야 하기 때문임.
    //$ss_name = 'ss_secret.'_'.$bo_table.'_'.$wr_id';
    $ss_name = 'ss_secret_'.$bo_table.'_'.$wr['wr_num'];
    //set_session("ss_secret", "$bo_table|$wr[wr_num]");
    set_session($ss_name, TRUE);

} else if ($w == 'sc') {
    $qstr = 'bo_table='.$bo_table.'&sfl='.$sfl.'&stx='.$stx.'&sop='.$sop.'&wr_id='.$wr_id.'&page='.$page;

    $wr = get_write($write_table, $wr_id);

    if( !$wr['wr_password'] && $wr['mb_id'] ){
        if ( $mb = get_member($wr['mb_id']) ){
            $wr['wr_password'] = $mb['mb_password'];
        }
    }

    if (!check_password($wr_password, $wr['wr_password'])){
        run_event('password_is_wrong', 'bbs', $wr, $qstr);
        alert('비밀번호가 틀립니다.');
    }

    $row = sql_fetch("select wr_parent from $write_table where wr_id = '$wr_id'");
    $wr_id = $row['wr_parent'];
    $qstr = 'bo_table='.$bo_table.'&sfl='.$sfl.'&stx='.$stx.'&sop='.$sop.'&wr_id='.$wr_id.'&page='.$page;
    // 세션에 아래 정보를 저장. 하위번호는 비밀번호없이 보아야 하기 때문임.
    $ss_name = 'ss_secret_comment_'.$bo_table.'_'.$wr['wr_id'];
    //set_session("ss_secret", "$bo_table|$wr[wr_num]");
    set_session($ss_name, TRUE);

} else
    alert('w 값이 제대로 넘어오지 않았습니다.');

$redirect_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?'.$qstr);
echo '{"redirect_url" : "'.str_replace(G5_URL, '', $redirect_url).'"}';
?>