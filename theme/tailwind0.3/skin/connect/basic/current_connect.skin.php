<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>

<!-- 현재접속자 목록 시작 { -->
<div id="current_connect" class="mx-3">
    <ul>
    <?php
    for ($i=0; $i<count($list); $i++) {
        //$location = conv_content($list[$i]['lo_location'], 0);
        $location = $list[$i]['lo_location'];
        // 최고관리자에게만 허용
        // 이 조건문은 가능한 변경하지 마십시오.
        if ($list[$i]['lo_url'] && $is_admin == 'super') $display_location = "<a href=\"".$list[$i]['lo_url']."\">".$location."</a>";
        else $display_location = $location;
    ?>
        <li class="shadow my-3 px-3 bg-white flex">
            <div class="flex items-center mr-3" ><?php echo $list[$i]['num'] ?></div>
            <div class="flex items-center"><?php echo get_member_profile_img($list[$i]['mb_id']); ?></div>
            <div class="flex items-center flex-wrap w-full">
            	<div class="w-full mx-3"><?php echo $list[$i]['name'] ?></div>
            	<div class="w-full mx-3"><?php echo $display_location ?></div>  
            </div>
        </li>
    <?php
    }
    if ($i == 0)
        echo "<div class=\"flex mx-3 my-3 h-32 justify-center items-center bg-white shadow\">현재 접속자가 없습니다.</div>";
    ?>
    </ul>
</div>
<!-- } 현재접속자 목록 끝 -->