<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/lib/tailwind.lib.php');
$write_pages = get_tailwind_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "./memo.php?kind=$kind".$qstr."&amp;page=");
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<script src="<?php echo $member_skin_url?>/js/popup.resize.js"></script>
<!-- 쪽지 목록 시작 { -->
<div id="memo_list" class="new_win popup-body bg-gray-900">
    <div class="new_win_con2">
        <ul class="win_ul py-5 border-b flex items-center justify-between">
            <div class="flex text-gray-300 text-xs whitespace-no-wrap">
            <li class="border-gray-500 <?php if ($kind == 'send') {  ?> text-white bg-blue-500 font-bold<?php }  ?> rounded-lg mx-1 border hover:bg-blue-500 hover:font-bold hover:text-white px-1 py-2"><a href="./memo.php?kind=send">보낸쪽지</a></li>
            <li class="border-gray-500 <?php if ($kind == 'recv') {  ?> text-white bg-blue-500 font-bold<?php }  ?> rounded-lg mx-1 border hover:bg-blue-500 hover:font-bold hover:text-white px-1 py-2"><a href="./memo.php?kind=recv">받은쪽지</a></li>
            <li class="border-gray-500 rounded-lg mx-1 border hover:bg-blue-500 hover:font-bold hover:text-white px-1 py-2"><a href="./memo_form.php">쪽지쓰기</a></li>
            </div>
            <div class="win_total bg-gray-700 border py-1 px-1 rounded text-gray-300 text-xs">전체 <?php echo $kind_title ?>쪽지 <?php echo $total_count ?>통</div>
        </ul>
        
        <div class="memo_list">
            <ul class="bg-gray-700">
	            <?php
                for ($i=0; $i<count($list); $i++) {
                $readed = (substr($list[$i]['me_read_datetime'],0,1) == 0) ? '' : 'read';
                $memo_preview = utf8_strcut(strip_tags($list[$i]['me_memo']), 30, '..');
                ?>
	            <li class="<?php echo $readed; ?> flex py-1">
	            	<div class="memo_li profile_big_img flex items-center pl-1 pr-2 text-gray-400">
	            		<?php if (! $readed){ ?><span class="no_read"><i class="far fa-envelope<?php echo (substr($list[$i]['me_read_datetime'],0,1) == 0) ? '-open' : '';?> text-3xl"></i></i></span><?php } ?>
	            	</div>
	                <div class="memo_li memo_name text-sm text-gray-300">
	                	<?php echo $list[$i]['mb_nick']; ?> <span class="memo_datetime text-xs text-gray-500 mr-1"><i class="fas fa-clock"></i> <?php echo $list[$i]['send_datetime']; ?></span>
						<div class="memo_preview">
						    <a href="<?php echo $list[$i]['view_href']; ?>"><?php echo $memo_preview; ?></a>
                        </div>
					</div>	
					<a href="<?php echo $list[$i]['del_href']; ?>" onclick="del(this.href); return false;" class="memo_del"><i class="fa fa-trash-o" aria-hidden="true"></i> <span class="sound_only">삭제</span></a>
	            </li>
	            <?php } ?>
	            <?php if ($i==0) { echo '<li class="empty_table h-32 flex justify-center items-center font-bold text-gray-200 shadow bg-gray-700">자료가 없습니다.</li>'; }  ?>
            </ul>
        </div>

        <!-- 페이지 -->
        <?php echo $write_pages; ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-3 shadow" role="alert">
            <p class="win_desc"><i class="fa fa-info-circle" aria-hidden="true"></i> 쪽지 보관일수는 최장 <strong><?php echo $config['cf_memo_del'] ?></strong>일 입니다.
        </div>
        </p>
        <div class="flex justify-center mt-2">
            <button class="bg-blue-700 text-gray-200 py-2 px-3 hover:bg-blue-800 border border-blue-900 text-sm" onclick="popup_close()"> 닫기 </button>
        </div>
    </div>
</div>
<!-- } 쪽지 목록 끝 -->
