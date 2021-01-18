<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<form name="foutlogin" class="text-left text-xs border-b border-gray-600 pb-3" action="<?php echo $outlogin_action_url ?>" onsubmit="return fhead_submit(this);" method="post" autocomplete="off">
    <fieldset>
        <div class="ol_wr mb-4 mx-3">
            <input type="hidden" name="url" value="<?php echo $outlogin_url ?>">
            <label for="ol_id" id="ol_idlabel" class="block text-gray-500 text-sm font-bold text-gray-200 my-2">회원아이디</label>
            <input type="text" id="ol_id" name="mb_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required maxlength="20" placeholder="아이디">
            <label for="ol_pw" id="ol_pwlabel" class="block text-gray-500 text-sm font-bold text-gray-200 my-2">비밀번호</label>
            <input type="password" name="mb_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ol_pw" required maxlength="20" placeholder="비밀번호">
        </div>
        <div class="mx-3">
            <?php @include_once(get_social_skin_path().'/social_login.skin.php');?>
        </div>
        <div id="ol_auto" class="mb-2 mx-3 text-xs mt-2">
                <input type="checkbox" name="auto_login" value="1" id="auto_login2" class="selec_chk mr-2">
                <label for="auto_login2" id="auto_login_label"><span></span>자동로그인</label>
        </div>
        <div class="flex items-center justify-around"> 
            <input type="submit" id="ol_submit2" value="로그인" class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded focus:outline-none focus:shadow-outline w-1/2 mx-3">
            <a href="<?php echo G5_BBS_URL ?>/password_lost.php" class="popup_href bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded focus:outline-none focus:shadow-outline block mx-3 text-center w-1/2">정보찾기</a>
        </div>
    </fieldset>
</form>
<script>
jQuery(function($) {
    $("#auto_login2").click(function(){
        if ($(this).is(":checked")) {
            Swal_Ko.fire({
            onBeforeOpen: () => {
                $("#auto_login2").prop('checked', false);
            },
            customClass: {
                header: 'border-b border-gray-600 mb-2',
                content : 'text-left'
            },
            title: '자동로그인',
            html: '자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.<br>공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.<br>자동로그인을 사용하시겠습니까?',
            showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    $("#auto_login2").prop('checked', true);
                }
            })
        }
    });
});
</script>