<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include G5_PATH.'/head.php';
?>

<!-- 회원 비밀번호 확인 시작 { -->
<div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md m-3" role="alert">
  <div class="flex">
    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
    <div>
      <p class="font-bold">비밀번호를 한번 더 입력해주세요.</p>
      <p class="text-sm">
        <?php if ($url == 'member_leave.php') { ?>
            비밀번호를 입력하시면 회원탈퇴가 완료됩니다.
        <?php }else{ ?>
            회원님의 정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인합니다.
        <?php }  ?>
      </p>
    </div>
  </div>
</div>
<form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post" class="bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3 m-3">
<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
<input type="hidden" name="w" value="u">
<fieldset>
    <div class="my-2">
    <span class="confirm_id">회원아이디</span>
    <span id="mb_confirm_id" class="font-bold"><?php echo $member['mb_id'] ?></span>
    </div>
    <label for="confirm_mb_password" class="sound_only">비밀번호<strong>필수</strong></label>
    <input type="password" name="mb_password" id="confirm_mb_password" required class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" size="15" maxLength="20" placeholder="비밀번호">
    <input type="submit" value="확인" id="btn_submit" class="btn_submit float-right clearfix mt-3 px-3 py-2 border cursor-pointer text-gray-100 rounded bg-blue-700 hover:bg-blue-500">
</fieldset>
</form>
<script>
function fmemberconfirm_submit(f)
{
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->
<?php include G5_PATH.'/tail.php';?>