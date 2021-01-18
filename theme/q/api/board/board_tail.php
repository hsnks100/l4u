<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 게시판 관리의 하단 파일 경로
if (G5_IS_MOBILE) {
    $board_tail = html_purifier(stripslashes($board['bo_mobile_content_tail']));
} else {
    $board_head = html_purifier(stripslashes($board['bo_content_tail']));
}
?>