<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<script src="<?php echo $member_skin_url?>/js/popup.resize.js"></script>
<!-- 스크랩 시작 { -->
<div id="scrap_do" class="new_win text-left text-base text-gray-300">
    <form name="f_scrap_popin" action="<?php echo G5_THEME_URL?>/lib/scrap_popin_update.php" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <div class="new_win_con">
	    <h2 class="sound_only">제목 확인 및 댓글 쓰기</h2>
	    <ul>
	        <li class="scrap_tit bg-gray-800 rounded p-3 mb-2 text-left">
	            <span class="sound_only">제목</span>
	            <?php echo get_text(cut_str($write['wr_subject'], 255)) ?>
	        </li>
	        <li>
	            <label for="wr_content" class="text-left mb-2 block">댓글작성</label>
	            <textarea name="wr_content" id="wr_content" class="w-full h-24 bg-gray-800 focus:border-2 focus:border-gray-500 p-2"></textarea>
	        </li>
	    </ul>
	</div>
    <p class="win_desc bg-red-400 border-l-4 border-red-500 text-left my-3 text-sm text-gray-300 p-3 ">스크랩을 하시면서 감사 혹은 격려의 댓글을 남기실 수 있습니다.</p>

    <div class="win_btn w-full text-sm text-center" >
        <button type="submit" class="btn_submit bg-teal-600 py-2 px-3 rounded hover:bg-teal-700 mr-1">스크랩 확인</button>
		<button type="button" class="bg-blue-700 text-gray-200 py-2 px-3 hover:bg-blue-800 border border-blue-900 text-sm" onclick="popup_close()"> 닫기 </button>
    </div>
    </form>
</div>
<!-- } 스크랩 끝 -->