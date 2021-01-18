<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>

<!-- 접속자집계 시작 { -->
<section id="visit" class="ft_cnt block py-3 border-b border-gray-700">
    <div class="flex justify-between mx-3">
    <span class="rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold text-normal">접속자집계</span>
    <?php if ($is_admin == "super") {  ?><a href="<?php echo G5_ADMIN_URL ?>/visit_list.php" class="btn_admin w-6 h-6 justify-center text-xs bg-red-500 hover:bg-red-600 rounded-lg flex items-center self-center"><i class="fa fa-cog fa-fw"></i><span class="sound_only">관리자</span></a><?php } ?>
    </div>
    <div class="grid grid-rows-2 grid-cols-2 mx-3 my-2 text-gray-500 text-sm">
        <dt><span></span> 오늘</dt>
        <dd class="text-right"><strong><?php echo number_format($visit[1]) ?></strong></dd>
        <dt><span></span> 어제</dt>
        <dd class="text-right"><strong><?php echo number_format($visit[2]) ?></strong></dd>
        <dt><span></span> 최대</dt>
        <dd class="text-right"><strong><?php echo number_format($visit[3]) ?></strong></dd>
        <dt><span></span> 전체</dt>
        <dd class="text-right"><strong><?php echo number_format($visit[4]) ?></strong></dd>
    </div>
    
</section>
<!-- } 접속자집계 끝 -->