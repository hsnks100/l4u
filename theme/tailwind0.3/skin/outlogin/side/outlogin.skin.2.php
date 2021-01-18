<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<!-- 로그인 후 아웃로그인 시작 { -->
<div class="pb-3 border-b border-gray-700">
<section id="ol_after" class="ol mx-3">
    <header id="ol_after_hd" class="flex items-center text-xs justify-between">
        <div class="flex items-center self-center">
            <div class="profile_img h-8 w-8">
                <?php echo get_member_profile_img($member['mb_id']); ?>
            </div>
        <div class="text-sm pl-1 tnuncate"><?php echo $nick ?>님</div>
        </div>
        <?php if ($is_admin == 'super' || $is_auth) {  ?><a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>" class="w-6 h-6 justify-center text-xs bg-red-500 hover:bg-red-600 rounded-lg flex items-center self-center" title="관리자"><i class="fa fa-cog fa-fw"></i><span class="sound_only">관리자</span></a><?php }  ?>
    </header>
    <ul id="ol_after_private" class="grid grid-cols-2">
        <li class="text-xs text-center mr-1"> <a class="block w-full bg-purple-600 hover:bg-purple-700 py-1 mt-2 rounded" href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" id="ol_after_info" title="정보수정"><i class="mr-1 fas fa-user-edit"></i>정보수정</a> </li>
    	<li class="text-xs text-center ml-1">
            <a href="<?php echo G5_BBS_URL ?>/point.php" id="ol_after_pt" class="popup_href block w-full bg-teal-600 hover:bg-teal-700 py-1 mt-2 rounded">
                <i class="mr-1 fas fa-database"></i>포인트
				<strong><?php echo $point; ?></strong>
            </a>
        </li>
        <li class="text-xs text-center mr-1">
            <a href="<?php echo G5_BBS_URL ?>/memo.php" id="ol_after_memo" class="popup_href block w-full bg-pink-600 hover:bg-pink-700 py-1 mt-2 rounded">
                <i class="mr-1 far fa-envelope"></i><span class="sound_only">안 읽은 </span>쪽지
                <strong><?php echo $memo_not_read; ?></strong>
            </a>
        </li>
        <li class="text-xs text-center ml-1">
            <a href="<?php echo G5_BBS_URL ?>/scrap.php" id="ol_after_scrap" class="popup_href block w-full bg-indigo-600 hover:bg-indigo-700 py-1 mt-2 rounded">
                <i class="mr-1 fas fa-thumbtack"></i></i>스크랩
            	<strong class="scrap"><?php echo $mb_scrap_cnt; ?></strong>
            </a>
        </li>
    </ul>
    <footer>
    	<a href="<?php echo G5_BBS_URL ?>/logout.php" id="ol_after_logout" class="block w-full bg-red-600 hover:bg-red-700 py-1 mt-2 rounded text-xs text-center" ><i class="mr-1 fas fa-sign-out-alt"></i> 로그아웃</a>
    </footer>
</section>
</div>
<script>
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave()
{
    Swal_Ko.fire({
        title: '경고',
        text : '정말 회원에서 탈퇴 하시겠습니까?',
        showCancelButton: true,
        }).then((result) => {
        if (result.value) {
            location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
        }
        return false;
    });
}
</script>
<!-- } 로그인 후 아웃로그인 끝 -->