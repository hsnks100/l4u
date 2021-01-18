<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/lib/tailwind.lib.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<script src="<?php echo $member_skin_url?>/js/popup.resize.js"></script>

<!-- 스크랩 목록 시작 { -->
<div id="scrap" class="new_win">
    <ul>
        <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li class="border-b bg-gray-900">
            <p class="mx-3 font-bold py-1 flex justify-between">
            <a href="<?php echo $list[$i]['opener_href_wr_id'] ?>" class="scrap_tit text-gray-300 hover:text-gray-100" onclick="parent.document.location.href='<?php echo $list[$i]['opener_href_wr_id'] ?>'; return false;"><?php echo $list[$i]['subject'] ?></a>
            <a href="<?php echo $list[$i]['del_href'];  ?>" onclick="del(this.href); return false;" class="scrap_del text-gray-500 hover:text-gray-100"><i class="far fa-trash-alt"></i><span class="sound_only">삭제</span></a>
            </p>
            <p class="mx-3 py-1 flex items-center mb-1">
            <a href="<?php echo $list[$i]['opener_href'] ?>" class="scrap_cate text-xs bg-purple-200 text-purple-500 text:text-purple-300 rounded py-1 px-1" onclick="parent.document.location.href='<?php echo $list[$i]['opener_href'] ?>'; return false;"><?php echo $list[$i]['bo_subject'] ?></a>
            <span class="scrap_datetime text-gray-500 text-xs ml-3"><i class="far fa-clock"></i> <?php echo $list[$i]['ms_datetime'] ?></span>
            </p>
        </li>
        <?php }  ?>
        <?php if ($i == 0) echo "<li class=\"empty_li h-10 flex justify-center items-center font-bold text-gray-300 shadow bg-gray-900\">자료가 없습니다.</li>";  ?>
    </ul>
    <?php echo get_tailwind_paging($config['cf_write_pages'], $page, $total_page, "?$qstr&amp;page="); ?>
    <div class="flex justify-center mt-2">
        <button class="bg-blue-700 text-gray-200 py-2 px-3 hover:bg-blue-800 border border-blue-900 text-sm" onclick="popup_close()"> 닫기 </button>
    </div>
</div>
<!-- } 스크랩 목록 끝 -->