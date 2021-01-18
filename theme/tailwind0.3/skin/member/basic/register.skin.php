<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>

<!-- 회원가입약관 동의 시작 { -->
<form  name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
<div class="bg-teal-100 border-l-4 border-teal-500 text-teal-700 p-4 m-3" role="alert">
    <h2 class="font-bold flex justify-between">
        <div> <i class="fa fa-check-circle" aria-hidden="true"></i> 회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</div>
        <div class="flex items-center">
        <input type="checkbox" name="agree" value="1" id="agree11" class="selec_chk form-checkbox h-5 w-5 text-teal-600">
        <label for="agree11"><span></span><b class="sound_only">회원가입약관의 내용에 동의합니다.</b></label>
        </div>
    </h2>
    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
    @include_once(get_social_skin_path().'/social_register.skin.php');
    ?>
    <textarea class="mt-3 w-full border bg-teal-100 border-teal-200 appearance-none leading-normal p-3" readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>

    <h2 class="font-bold text-lg flex justify-between"> 
        <div> <i class="fa fa-info-circle my-2"></i> 개인정보처리방침안내 </div>
        <div class="flex items-center">
        <input type="checkbox" name="agree2" value="1" id="agree21" class="selec_chk form-checkbox h-5 w-5 text-teal-600">
        <label for="agree21"><span></span><b class="sound_only">개인정보처리방침안내의 내용에 동의합니다.</b></label>
        </div>
    </h2>
    <div class="grid grid-rows-3 grid-cols-3">
        <div class="flex text-sm items-center border-b border-r border-t border-l px-2 justify-center font-bold">목적</div>
        <div class="flex text-sm items-center border-b border-r border-t px-2 justify-center font-bold">항목</div>
        <div class="flex text-sm items-center border-b border-r border-t px-2 justify-center font-bold">보유기간</div>
        <div class="flex text-sm items-center border-b border-r border-l px-2">이용자 식별 및 본인여부 확인</div>
        <div class="flex text-sm items-center border-b border-r px-2">아이디, 이름, 비밀번호</div>
        <div class="flex text-sm items-center border-b border-r px-2">회원 탈퇴 시까지</div>
        <div class="flex text-sm items-center border-b border-r border-l px-2">고객서비스 이용에 관한 통지,<br>CS대응을 위한 이용자 식별</div>
        <div class="flex text-sm items-center border-b border-r px-2">연락처 (이메일, 휴대전화번호)</div>
        <div class="flex text-sm items-center border-b border-r px-2">회원 탈퇴 시까지</div>
    </div>
    <div id="fregister_chkall" class="chk_all fregister_agree mt-3 font-bold flex items-center">
        <input type="checkbox" name="chk_all" id="chk_all" class="selec_chk form-checkbox h-5 w-5 text-teal-600">
        <label class="ml-2" for="chk_all"><span></span>회원가입 약관에 모두 동의합니다</label>
    </div>
</div>
<div class="btn_confirm flex justify-end text-sm mx-3">
    <a href="<?php echo G5_URL ?>" class="btn_close block bg-red-700 hover:bg-red-500 text-white font-bold py-2 px-4 rounded">취소</a>
    <button type="submit" class="ml-3 btn_submit bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">회원가입</button>
</div>
</form>
<script>
function fregister_submit(f) {
    if (!f.agree.checked) {
        alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        f.agree.focus();
        return false;
    }
    if (!f.agree2.checked) {
        alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        f.agree2.focus();
        return false;
    }
    return true;
}
jQuery(function($){
    // 모두선택
    $("input[name=chk_all]").click(function() {
        if ($(this).prop('checked')) {
            $("input[name^=agree]").prop('checked', true);
        } else {
            $("input[name^=agree]").prop("checked", false);
        }
    });
});
</script>
<!-- } 회원가입 약관 동의 끝 -->
