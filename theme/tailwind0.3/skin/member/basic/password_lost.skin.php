<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/lib/tailwind.lib.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<script src="<?php echo $member_skin_url?>/js/popup.resize.js"></script>

<!-- 회원정보 찾기 시작 { -->
<div id="find_info" class="new_win text-gray-300 text-sm">
    <div class="new_win_con">
        <form name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
        <div class="bg-gray-800 text-gray-400 px-2 py-2 " role="alert">
            <div class="font-bold">회원가입 시 등록하신 이메일 주소를 입력해 주세요.</div>
            <div class="text-xs">해당 이메일로 아이디와 비밀번호 정보를 보내드립니다.</div>
        </div>

            <div class="md:flex md:items-center mb-6">
        <div class="md:w-32">
            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4 mt-1" for="mb_email">
                E-mail 주소
            </label>
            </div>
            <div class="md:w-full">
            <input type="text" name="mb_email" id="mb_email" required class="bg-gray-800 appearance-none border-2 border-gray-700 rounded py-2 px-4 text-gray-200 leading-tight focus:outline-none focus:bg-gray-700 focus:border-gray-500" size="30" placeholder="E-mail 주소">
            </div>
        </div>
        <?php echo tailwind_captcha_html();  ?>
        <div class="win_btn flex justify-end mx-3">
            <button type="submit" class="btn_submit bg-teal-600 hover:bg-teal-700 px-2 py-2 rounded text-white font-bold mr-3">확인</button>
            <button class="bg-blue-700 text-gray-200 py-2 px-3 hover:bg-blue-800 border border-blue-900 text-sm" onclick="popup_close()"> 닫기 </button>
        </div>
        </form>
    </div>
</div>

<script>
function fpasswordlost_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>
<!-- } 회원정보 찾기 끝 -->