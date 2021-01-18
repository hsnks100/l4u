<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_THEME_PATH.'/lib/tailwind.lib.php');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<script src="<?php echo $member_skin_url?>/js/popup.resize.js"></script>
<div id="point" class="new_win popup-body">

    <div class="new_win_con2">
        <ul class="point_all h-12 flex shadow border border-blue-300 items-center bg-blue-800">
        	<li class="full_li p-3 flex justify-between w-full">
        		<div class="flex text-xl font-bold text-gray-300"> 보유포인트 </div>
        		<div class="flex text-xl font-bold text-gray-400"><?php echo number_format($member['mb_point']); ?></div>
        	</li>
		</ul>
        <ul class="point_list border-t border-gray-600">
            <?php
            $sum_point1 = $sum_point2 = $sum_point3 = 0;

            $sql = " select *
                        {$sql_common}
                        {$sql_order}
                        limit {$from_record}, {$rows} ";
            $result = sql_query($sql);
            for ($i=0; $row=sql_fetch_array($result); $i++) {
                $point1 = $point2 = 0;
                $point_use_class = '';
                if ($row['po_point'] > 0) {
                    $point1 = '+' .number_format($row['po_point']);
                    $sum_point1 += $row['po_point'];
                } else {
                    $point2 = number_format($row['po_point']);
                    $sum_point2 += $row['po_point'];
                    $point_use_class = 'point_use';
                }

                $po_content = $row['po_content'];

                $expr = '';
                if($row['po_expired'] == 1)
                    $expr = ' txt_expired';
            ?>
            <li class="<?php echo $point_use_class; ?> border-b border-gray-600 px-5 py-2 flex justify-between">
                <div class="point_top">
                    <p class="point_tit font-bold text-sm text-gray-300"><?php echo $po_content; ?></p>
                    <p class="point_date1 text-gray-600 text-xs tezt-gray-400"><i class="far fa-clock"></i> <?php echo $row['po_datetime']; ?></p>
                </div>
                <div class="flex items-center">
                <span class="point_date text-red-700 font-semibold px-3<?php echo $expr; ?>">
                    <?php if ($row['po_expired'] == 1) { ?>
                    만료 <?php echo substr(str_replace('-', '', $row['po_expire_date']), 2); ?>
                    <?php } else echo $row['po_expire_date'] == '9999-12-31' ? '&nbsp;' : $row['po_expire_date']; ?>
                </span>
                <span class="point_num text-blue-500 font-bold"><?php if ($point1) echo $point1; else echo $point2; ?></span>
                
                </div>
            </li>
            <?php
            }

            if ($i == 0)
                echo '<li class="empty_li border-b border-gray-600 h-10 p-3 flex items-center justify-center text-3xl font-bold text-gray-600">자료가 없습니다.</li>';
            else {
                if ($sum_point1 > 0)
                    $sum_point1 = "+" . number_format($sum_point1);
                $sum_point2 = number_format($sum_point2);
            }
            ?>

            <li class="point_status bg-gray-700 py-2 text-normal font-bold flex justify-between text-gray-300 px-5">
                <div> 소계 </div>
                <div>
                    <span class="mr-3"><?php echo $sum_point2; ?></span>
                    <span><?php echo $sum_point1; ?></span>
                </div>
            </li>
        </ul>
    </div>

    <?php echo get_tailwind_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
    <div class="flex justify-center mt-2">
        <button class="bg-blue-700 text-gray-200 py-2 px-3 hover:bg-blue-800 border border-blue-900 text-sm" onclick="popup_close()"> 닫기 </button>
    </div>
</div>
