<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/lib/tailwind.lib.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<script src="<?php echo $member_skin_url?>/js/popup.resize.js"></script>

<!-- 폼메일 시작 { -->
<div id="formmail" class="new_win text-gray-300 text-xs">
    <h1 id="win_title py-1"><?php echo $name ?>님께 메일보내기</h1>

    <form name="fformmail" action="./formmail_send.php" onsubmit="return fformmail_submit(this);" method="post" enctype="multipart/form-data" style="margin:0px;">
    <input type="hidden" name="to" value="<?php echo $email ?>">
    <input type="hidden" name="attach" value="2">
    <?php if ($is_member) { // 회원이면  ?>
    <input type="hidden" name="fnick" value="<?php echo get_text($member['mb_nick']) ?>">
    <input type="hidden" name="fmail" value="<?php echo $member['mb_email'] ?>">
    <?php }  ?>

    <div class="form_01 new_win_con">
        <h2 class="sound_only">메일쓰기</h2>
        <ul>
            <?php if (!$is_member) {  ?>
            <li>
                <label for="fnick" class="sound_only">이름<strong>필수</strong></label>
                <input type="text" name="fnick" id="fnick" required class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-4 text-gray-300 leading-tight focus:outline-none focus:bg-gray-800 focus:border-blue-500" placeholder="이름">
            </li>
            <li>
                <label for="fmail" class="sound_only">E-mail<strong>필수</strong></label>
                <input type="text" name="fmail"  id="fmail" required class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-4 text-gray-300 leading-tight focus:outline-none focus:bg-gray-800 focus:border-blue-500" placeholder="E-mail">
            </li>
            <?php }  ?>
            <li>
                <label for="subject" class="sound_only">제목<strong>필수</strong></label>
                <input type="text" name="subject" id="subject" required class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-4 text-gray-300 leading-tight focus:outline-none focus:bg-gray-800 focus:border-blue-500"  placeholder="제목">
            </li>
            <li class="chk_box py-1">
                <span class="sound_only">형식</span>
                <input type="radio" name="type" value="0" id="type_text" checked>
                <label for="type_text"><span></span>TEXT</label>
                
                <input type="radio" name="type" value="1" id="type_html">
                <label for="type_html"><span></span>HTML</label>
                
                <input type="radio" name="type" value="2" id="type_both">
                <label for="type_both"><span></span>TEXT+HTML</label>
            </li>
            <li>
                <label for="content" class="sound_only">내용<strong>필수</strong></label>
                <textarea name="content" id="content" required class="bg-gray-700 appearance-none border-2 h-20 border-gray-600 rounded w-full py-2 px-4 text-gray-300 leading-tight focus:outline-none focus:bg-gray-800 focus:border-blue-500"></textarea>
            </li>
            <li class="formmail_flie mt-2">
                <div class="file_wr relative flex">
                    <label for="file1" class="lb_icon absolute top-0 h-full flex items-center self-center left-0 px-1"><i class="fa fa-download" aria-hidden="true"></i><span class="sound_only"> 첨부 파일 1</span></label>
                    <input type="file" name="file1"  id="file1"  class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-4 text-gray-300 leading-tight focus:outline-none focus:bg-gray-800 focus:border-blue-500">
               </div>
            </li>
            <li class="formmail_flie mt-1 ">
                <div class="file_wr relative flex">
                    <label for="file2" class="lb_icon absolute top-0 h-full flex items-center self-center left-0 px-1"><i class="fa fa-download" aria-hidden="true"></i><span class="sound_only"> 첨부 파일 2</span></label>
                    <input type="file" name="file2" id="file2" class="bg-gray-700 appearance-none border-2 border-gray-600 rounded w-full py-2 px-4 text-gray-300 leading-tight focus:outline-none focus:bg-gray-800 focus:border-blue-500">
                </div>
            </li>
            <div class="frm_info text-xs text-blue-300 mt-1">첨부 파일은 누락될 수 있으므로 메일을 보낸 후 파일이 첨부 되었는지 반드시 확인해 주시기 바랍니다.</div>   
            <li>
                <span class="sound_only">자동등록방지</span>
                <?php echo tailwind_captcha_html(); ?>
            </li>
        </ul>
        <div class="win_btn flex justify-end">
        	<button type="submit" id="btn_submit" class="btn_b02 reply_btn bg-teal-600 hover:bg-teal-700 rounded py-2 px-3 mr-1">메일발송</button>
            <button class="bg-blue-700 text-gray-200 py-2 px-3 hover:bg-blue-800 border border-blue-900 text-sm" onclick="popup_close()"> 닫기 </button>
        </div>
    </div>


    </form>
</div>

<script>
with (document.fformmail) {
    if (typeof fname != "undefined")
        fname.focus();
    else if (typeof subject != "undefined")
        subject.focus();
}

function fformmail_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    if (f.file1.value || f.file2.value) {
        // 4.00.11
        if (!confirm("첨부파일의 용량이 큰경우 전송시간이 오래 걸립니다.\n\n메일보내기가 완료되기 전에 창을 닫거나 새로고침 하지 마십시오."))
            return false;
    }

    document.getElementById('btn_submit').disabled = true;

    return true;
}
</script>
<!-- } 폼메일 끝 -->