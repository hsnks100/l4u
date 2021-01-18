<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include G5_PATH.'/head.sub.php';
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<script src="<?php echo $member_skin_url?>/js/popup.resize.js"></script>
<!-- 자기소개 시작 { -->
<div id="profile" class="new_win text-gray-200">
    <div class="profile_name py-2 shadow text-center w-full">
        <div class="text-normal my-1 text-gray-100">
            <?php echo get_member($mb_id, 'mb_nick')['mb_nick']?>님의 프로필
        </div>
    </div>
    <div class="table bg-gray-800 border border-gray-700 rounded w-full">
        <div class="table-row">
            <div class="border-b table-cell border-gray-700 py-2 px-3 text-xs font-bold"><i class="far fa-star"></i>  회원권한</div>
            <div class="border-b table-cell border-gray-700 py-2 px-3 text-xs"><?php echo $mb['mb_level'] ?></div>
            <div class="border-b table-cell border-gray-700 py-2 px-3 text-xs font-bold "><i class="fa fa-database" aria-hidden="true"></i> 포인트</div>
            <div class="border-b table-cell border-gray-700 py-2 px-3 text-xs "><?php echo number_format($mb['mb_point']) ?></div>
        </div>
        <div class="table-row">
            <div class="border-b table-cell border-gray-700 py-2 px-3 text-xs font-bold "><i class="far fa-clock"></i></i> 회원가입일</div>
            <div class="border-b table-cell border-gray-700 py-2 px-3 text-xs"><?php echo ($member['mb_level'] >= $mb['mb_level']) ?  substr($mb['mb_datetime'],0,10) ." (".number_format($mb_reg_after)." 일)" : "알 수 없음";  ?></div>
            <div class="border-b table-cell border-gray-700 py-2 px-3 text-xs font-bold"><i class="far fa-clock"></i></i> 최종접속일</div>
            <div class="border-b table-cell border-gray-700 py-2 px-3 text-xs "><?php echo ($member['mb_level'] >= $mb['mb_level']) ? $mb['mb_today_login'] : "알 수 없음"; ?></div>
        </div>
        <?php if ($mb_homepage) {  ?>
            <div><i class="fa fa-home" aria-hidden="true"></i> 홈페이지</div>
            <div colspan="3"><a href="<?php echo $mb_homepage ?>" target="_blank"><?php echo $mb_homepage ?></a></div>
        <?php }  ?>
    </div>
    <div class="mt-3 border p-3 text-blue-600 shadow text-sm bg-gray-800 border-gray-700 rounded">
        <h2 class="font-semibold">인사말</h2>
        <p><?php echo $mb_profile ?></p>
    </div>
</div>
<!-- } 자기소개 끝 -->
<?php include G5_PATH.'/tail.sub.php';?>