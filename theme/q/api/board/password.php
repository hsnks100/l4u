<?php
$g5['title'] = '비밀번호 입력';

$write_table = "";
if ($bo_table) {
    $board = get_board_db($bo_table);
    if ($board['bo_table']) {
        set_cookie("ck_bo_table", $board['bo_table'], 86400 * 1);
        $gr_id = $board['gr_id'];
        $write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

        if (isset($wr_id) && $wr_id) {
            $write = get_write($write_table, $wr_id);
        } else if (isset($wr_seo_title) && $wr_seo_title) {
            $write = get_content_by_field($write_table, 'bbs', 'wr_seo_title', generate_seo_title($wr_seo_title));
            if( isset($write['wr_id']) ){
                $wr_id = $write['wr_id'];
            }
        }
    }
    
    // 게시판에서 
    if (isset($board['bo_select_editor']) && $board['bo_select_editor']){
        $config['cf_editor'] = $board['bo_select_editor'];
    }
}

if( isset($comment_id) ){
    $comment_id = (int) $comment_id;
}
$sql = " select wr_subject from {$write_table}
                      where wr_num = '{$write['wr_num']}'
                      and wr_reply = ''
                      and wr_is_comment = 0 ";
$row = sql_fetch($sql);

$g5['title'] = get_text($row['wr_subject']);
switch ($w) {
    case 'u' :
        $action = G5_HTTP_BBS_URL.'/write.php';
        $return_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id);
        break;
    case 'd' :
        set_session('ss_delete_token', $token = uniqid(time()));
        $action = https_url(G5_BBS_DIR).'/delete.php?token='.$token;
        $return_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id);
        break;
    case 'x' :
        set_session('ss_delete_comment_'.$comment_id.'_token', $token = uniqid(time()));
        $action = https_url(G5_BBS_DIR).'/delete_comment.php?token='.$token;
        $row = sql_fetch(" select wr_parent from $write_table where wr_id = '$comment_id' ");
        $return_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$row['wr_parent']);
        break;
    case 's' :
        // 비밀번호 창에서 로그인 하는 경우 관리자 또는 자신의 글이면 바로 글보기로 감
        if ($is_admin || ($member['mb_id'] == $write['mb_id'] && $write['mb_id']))
            goto_url(short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id));
        else {
            $action = https_url(G5_BBS_DIR).'/password_check.php';
            $return_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table);
        }
        break;
    case 'sc' :
        // 비밀번호 창에서 로그인 하는 경우 관리자 또는 자신의 글이면 바로 글보기로 감
        if ($is_admin || ($member['mb_id'] == $write['mb_id'] && $write['mb_id']))
            goto_url(short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id));
        else {
            $action = https_url(G5_BBS_DIR).'/password_check.php';
            $return_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id);
        }
        break;
    default :
        alert('w 값이 제대로 넘어오지 않았습니다.');
}
$return_url = str_replace(G5_URL, '', $return_url);
$arr = get_defined_vars();
foreach ( $arr as $key => $value ) {
  $data[$key] = $value;
}
?>
