<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<ul class="flex text-xs">
    <li class="px-1 h-10 w-10 -my-2 hover:bg-gray-600 flex justify-center items-center"><a href="<?php echo G5_BBS_URL ?>/register.php"><i class="fas fa-user-plus text-xl"></i></a></li>
    <li class="px-1 outlogin cursor-pointer h-10 w-10 -my-2 hover:bg-gray-600 flex justify-center items-center"> <i class="fas fa-sign-in-alt text-xl"></i> </li>
</ul>
<script>
var form = [
    '<form name="foutlogin" class="text-left" action="<?php echo $outlogin_action_url ?>" onsubmit="return fhead_submit(this);" method="post" autocomplete="off">',
    '<fieldset>',
        '<div class="ol_wr mb-4">',
            '<input type="hidden" name="url" value="<?php echo $outlogin_url ?>">',
            '<label for="ol_id" id="ol_idlabel" class="block text-gray-500 text-sm font-bold text-gray-200 my-2">회원아이디</label>',
            '<input type="text" id="ol_id" name="mb_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required maxlength="20" placeholder="아이디">',
            '<label for="ol_pw" id="ol_pwlabel" class="block text-gray-500 text-sm font-bold text-gray-200 my-2">비밀번호</label>',
            '<input type="password" name="mb_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ol_pw" required maxlength="20" placeholder="비밀번호">',
        '</div>',
        '<div id="ol_auto" class="mb-4 text-sm">',
                '<input type="checkbox" name="auto_login" value="1" id="auto_login" class="selec_chk mr-2">',
                '<label for="auto_login" id="auto_login_label"><span></span>자동로그인</label>',
        '</div>',
        '<div class="flex items-center justify-between"> ',
            '<input type="submit" id="ol_submit" value="로그인" class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">',
            '<div id="ol_svc">',
                '<a href="<?php echo G5_BBS_URL ?>/password_lost.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" id="ol_password_lost">정보찾기</a>',
            '</div>',
        '</div>',
    '</fieldset>',
    '</form>'].join('');
//'@include_once(get_social_skin_path().'/social_login.skin.php');',
$('.outlogin').click(function (e) { 
    e.preventDefault();
    Swal.fire({
    html: form,
    showCloseButton: false,
    showCancelButton: false,
    showConfirmButton: false,
    })
});
jQuery(function($) {

    var $omi = $('#ol_id'),
        $omp = $('#ol_pw'),
        $omi_label = $('#ol_idlabel'),
        $omp_label = $('#ol_pwlabel');

    $omi_label.addClass('ol_idlabel');
    $omp_label.addClass('ol_pwlabel');

    $("#auto_login").click(function(){
        if ($(this).is(":checked")) {
            if(!confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?"))
                return false;
        }
    });
});

function fhead_submit(f)
{
    if( $( document.body ).triggerHandler( 'outlogin1', [f, 'foutlogin'] ) !== false ){
        return true;
    }
    return false;
}
</script>