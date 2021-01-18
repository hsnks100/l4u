<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/lib/tailwind.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<script src="<?php echo $member_skin_url?>/js/popup.resize.js"></script>
<!-- 쪽지 보내기 시작 { -->
<div id="memo_write" class="new_win bg-gray-900 popup-body">
    <div class="new_win_con2">
    <ul class="win_ul py-3 px-3 flex items-center justify-between">
            <div class="flex text-gray-300 text-xs whitespace-no-wrap">
            <li class="border-gray-500 whitespace-no-wrap rounded-lg mx-1 border hover:bg-blue-500 hover:font-bold hover:text-white px-1 py-2"><a href="./memo.php?kind=send">보낸쪽지</a></li>
            <li class="border-gray-500 rounded-lg mx-1 border hover:bg-blue-500 hover:font-bold hover:text-white px-1 py-2"><a href="./memo.php?kind=recv">받은쪽지</a></li>
            <li class="border-gray-500 text-white bg-blue-500 font-bold rounded-lg mx-1 border hover:bg-blue-500 hover:font-bold hover:text-white px-1 py-2"><a href="./memo_form.php">쪽지쓰기</a></li>
            </div>
        </ul>

        <form name="fmemoform" action="<?php echo $memo_action_url; ?>" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
        <div class="form_01">
            <h2 class="sound_only">쪽지쓰기</h2>
            <ul class="mx-3 my-2">
                <li>
                    <label for="me_recv_mb_id" class="sound_only">받는 회원아이디<strong>필수</strong></label>
                    <input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id; ?>" id="me_recv_mb_id" required class="bg-gray-700 appearance-none border-2 border-gray-500 rounded w-full py-2 px-4 text-gray-300 leading-tight focus:outline-none focus:bg-gray-800 focus:border-blue-500" size="47" placeholder="받는 회원아이디">
                        <div class="bg-blue-100 shadow border-l-4 border-blue-500 text-blue-700 px-4 py-1 mt-1" role="alert">
                        <p class="text-xs">여러 회원에게 보낼때는 컴마(,)로 구분하세요.</p>
                        <?php if ($config['cf_memo_send_point']) { ?>
                        <p class="text-xs">쪽지 보낼때 회원당 <?php echo number_format($config['cf_memo_send_point']); ?>점의 포인트를 차감합니다.</p>
                        <?php } ?>
                    </div>
                </li>
                <li class="my-3">
                    <label for="me_memo" class="sound_only">내용</label>
                    <textarea name="me_memo" id="me_memo" required class="bg-gray-700 appearance-none border-2 border-gray-500 rounded w-full py-2 px-4 text-gray-300 leading-tight focus:outline-none focus:bg-gray-800 focus:border-blue-500 h-32"><?php echo $content ?></textarea>
                </li>
                <li class="text-gray-300">
                    <span class="sound_only">자동등록방지</span>
                    
                    <?php echo tailwind_captcha_html(); ?>
                    
                </li>
            </ul>
        </div>
        <div class="win_btn mx-3 flex justify-end">
        	<button type="submit" id="btn_submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded mr-2">보내기</button>
            <button class="bg-blue-700 text-gray-200 py-2 px-3 hover:bg-blue-800 border border-blue-900 text-sm" onclick="popup_close()"> 닫기 </button>
        </div>
    </div>
    </form>
</div>

<script>
function fmemoform_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>
<!-- } 쪽지 보내기 끝 -->