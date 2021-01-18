<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$nick = get_sideview($mb['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['mb_homepage']);
if($kind == "recv") {
    $kind_str = "보낸";
    $kind_date = "받은";
}
else {
    $kind_str = "받는";
    $kind_date = "보낸";
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<script src="<?php echo $member_skin_url?>/js/popup.resize.js"></script>

<!-- 쪽지보기 시작 { -->
<div id="memo_view" class="new_win bg-gray-900">
    <div class="new_win_con2">
        <!-- 쪽지함 선택 시작 { -->
        <ul class="win_ul py-5 border-b flex items-center justify-between">
            <div class="flex text-gray-300 text-xs whitespace-no-wrap">
            <li class="<?php if ($kind == 'send') {  ?> text-white bg-blue-500 font-bold<?php }  ?> rounded-lg mx-1 border hover:bg-blue-500 hover:font-bold hover:text-white px-1 py-2"><a href="./memo.php?kind=send">보낸쪽지</a></li>
            <li class="<?php if ($kind == 'recv') {  ?> text-white bg-blue-500 font-bold<?php }  ?> rounded-lg mx-1 border hover:bg-blue-500 hover:font-bold hover:text-white px-1 py-2"><a href="./memo.php?kind=recv">받은쪽지</a></li>
            <li class="rounded-lg mx-1 border hover:bg-blue-500 hover:font-bold hover:text-white px-1 py-2"><a href="./memo_form.php">쪽지쓰기</a></li>
            </div>
            <div class="win_total bg-gray-700 border py-1 px-1 rounded text-gray-300 text-xs"><?php echo $g5['title'] ?></div>
        </ul>
        <!-- } 쪽지함 선택 끝 -->

        <article id="memo_view_contents" class="bg-gray-700 text-gray-300 border-0 px-1 py-2">
            <header>
                <h2 class="sound_only">쪽지 내용</h2>
            </header>
            <div id="memo_view_ul">
                <div class="memo_view_li memo_view_name">
                	<div class="memo_from text-sm flex justify-between">
                        <div class="flex">
						<div class="memo_view_nick text-gray-300 mr-1"><?php echo $nick ?></div>
						<div class="memo_view_date text-xs text-gray-500"><span class="sound_only"><?php echo $kind_date ?>시간</span><i class="fas fa-clock" aria-hidden="true"></i> <?php echo $memo['me_send_datetime'] ?></div> 
                        </div>
                        <div class="flex">
						<div class="memo_op_btn px-1 list_btn"><a href="<?php echo $list_link ?>" class="btn_b01 btn"><i class="fa fa-list" aria-hidden="true"></i><span class="sound_only">목록</span></a></div>
						<div class="memo_op_btn px-1 del_btn"><a href="<?php echo $del_link; ?>" onclick="del(this.href); return false;" class="memo_del hover:text-pink-800"><i class="far fa-trash-alt"></i> <span class="sound_only">삭제</span></a></div>	
                        </div>
					</div>
                    <div class="memo_btn">
                    	<?php if($prev_link) {  ?>
			            <a href="<?php echo $prev_link ?>" class="btn_left"><i class="fa fa-chevron-left" aria-hidden="true"></i> 이전쪽지</a>
			            <?php }  ?>
			            <?php if($next_link) {  ?>
			            <a href="<?php echo $next_link ?>" class="btn_right">다음쪽지 <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
			            <?php }  ?>  
                    </div>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-1 ml-1">
                <?php echo conv_content($memo['me_memo'], 0) ?>
            </p>
        </article>
		<div class="win_btn py-3 flex justify-end">
			<?php if ($kind == 'recv') {  ?><a href="./memo_form.php?me_recv_mb_id=<?php echo $mb['mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>" class="inline-block reply_btn bg-teal-700 text-gray-200 py-2 px-3 hover:bg-teal-800 border border-teal-900 text-sm mr-2">답장</a><?php }  ?>
            <button class="bg-blue-700 text-gray-200 py-2 px-3 hover:bg-blue-800 border border-blue-900 text-sm" onclick="popup_close()"> 닫기 </button>
    	</div>
    </div>
</div>
<!-- } 쪽지보기 끝 -->