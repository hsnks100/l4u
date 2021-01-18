<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 게시판 관리의 상단 내용
if (G5_IS_MOBILE) {
    // 모바일의 경우 설정을 따르지 않는다.
    $board_head = html_purifier(stripslashes($board['bo_mobile_content_head']));
} else {
    $board_head = html_purifier(stripslashes($board['bo_content_head']));
}
?>