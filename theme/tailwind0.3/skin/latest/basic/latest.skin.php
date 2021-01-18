<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="block md:w-full mb-3 px-3">
    <h2 class="bg-blue-800 p-2 shadow text-white text-base"><a class="hover:text-pink-500 truncate" href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?></a><a href="<?php echo get_pretty_url($bo_table);?>" class="float-right text-sm p-1 hover:text-pink-500 truncate"> <i class="fa fa-plus"></i> </a></h2>
    <ul class="w-full md:block px-1">
    <?php for ($i=0; $i<$list_count; $i++) {  ?>
        <li class="flex justify-between text-base ml-1 md:ml-0 border-b">
            <div class="flex items-center truncate mr-1 text-sm">
            <?php
            echo "<a class='hover:text-blue-500 truncate' href=\"".$list[$i]['href']."\"> ";
            if ($list[$i]['is_notice'])
                echo "<strong>".$list[$i]['subject']."</strong>";
            else
                echo $list[$i]['subject'];

            echo "</a>";
			
            if ($list[$i]['icon_new']) echo '<span class="ml-1 bg-green-500 text-white text-xs font-bold rounded w-4 text-center h-auto inline-block">N</span>';
            if ($list[$i]['icon_hot']) echo '<i class="ml-1 text-red-700 fab fa-hotjar"></i>';
            if ($list[$i]['icon_file']) echo '<i class="ml-1 text-gray-700 fas fa-download"></i>';
            //if (isset($list[$i]['icon_link'])) echo '<i class="ml-1 text-gray-700 fas fa-link"></i>';
            if ($list[$i]['icon_secret']) echo '<i class="ml-1 text-gray-700 fas fa-lock"></i>';
            
            if ($list[$i]['comment_cnt'])  echo "
            <span class=\"ml-1 bg-blue-500 text-white text-xs font-bold rounded w-4 text-center h-auto inline-block\">".$list[$i]['wr_comment']."</span>";
            ?>
            </div>
            <div class="flex py-2 mr-2 md:mr-1">
				<span class="text-xs mr-1 truncate"><?php echo $list[$i]['name'] ?></span>
            	<span class="text-xs text-gray-600 whitespace-no-wrap"><?php echo $list[$i]['datetime2'] ?></span>              
            </div>
        </li>
    <?php }  ?>
    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
    <li class="text-center py-3 border-b text-sm">게시물이 없습니다.</li>
    <?php }  ?>
    </ul>
</div>
