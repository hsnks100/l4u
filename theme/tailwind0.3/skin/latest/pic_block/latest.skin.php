<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
$thumb_width = 210;
$thumb_height = 150;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="m-2 w-full mb-3 mx-3">
    <h2 class="bg-blue-800 p-2 shadow text-white text-base"><a class="hover:text-pink-500 truncate" href="<?php echo get_pretty_url($bo_table); ?>"><?php echo $bo_subject ?></a><a href="<?php echo get_pretty_url($bo_table);?>" class="float-right text-sm p-1 hover:text-pink-500 truncate"> <i class="fa fa-plus"></i> </a></h2>
    <div class="grid md:grid-cols-4 grid-cols-1 text-cetner">
    <?php
    for ($i=0; $i<$list_count; $i++) {
    $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

    if($thumb['src']) {
        $img = $thumb['src'];
    } else {
        $img = G5_IMG_URL.'/no_img.png';
        $thumb['alt'] = '이미지가 없습니다.';
    }
    $img_content = '<img class="w-full" src="'.$img.'" alt="'.$thumb['alt'].'" >';
    ?>
        <div class="w-full block text-center px-2 text-sm py-1 shadow">
            <a href="<?php echo $list[$i]['href'] ?>" class="lt_img flex justify-center"><?php echo $img_content; ?></a>
            <div class="text-left px-1 w-full truncate">
            <?php
            echo "<a href=\"".$list[$i]['href']."\" class=\"py-1 mr-1 hover:text-blue-500\"> ";
            if ($list[$i]['is_notice'])
                echo "<strong>".$list[$i]['subject']."</strong>";
            else
                echo $list[$i]['subject'];
            echo "</a>";
			
			if ($list[$i]['icon_new']) echo '<span class="bg-green-500 text-white rounded w-4 text-center h-auto text-xs inline-block">N</span>';
            if ($list[$i]['icon_hot']) echo '<i class="ml-1 text-red-700 fab fa-hotjar"></i>';
            //if ($list[$i]['icon_file']) echo '<i class="ml-1 text-gray-700 fas fa-download"></i>';
            //if (isset($list[$i]['icon_link'])) echo '<i class="ml-1 text-gray-700 fas fa-link"></i>';
            if ($list[$i]['icon_secret']) echo '<i class="ml-1 text-gray-700 fas fa-lock"></i>';

            if ($list[$i]['comment_cnt'])  echo "
            <span class=\"lt_cmt ml-1 bg-blue-500 text-white text-sm rounded w-4 text-center h-auto inline-block\">".$list[$i]['wr_comment']."</span>";

            ?>
            </div>
            <div class="text-right">
				<span class="text-xs"><?php echo $list[$i]['name'] ?></span>
            	<span class="text-xs text-gray-600"><?php echo $list[$i]['datetime2'] ?></span>              
            </div>
        </div>
    <?php }  ?>
    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
    <li class="text-center py-3 border-b text-sm">게시물이 없습니다.</li>
    <?php }  ?>
    </div>

</div>
