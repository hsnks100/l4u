<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_THEME_PATH.'/lib/tailwind.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>
<!--메뉴-->
<nav class="bg-gray-900 pt-2 pb-2 px-1 mt-0 h-12 fixed w-full z-20 top-0">
    <div class="flex flex-wrap items-center justify-between">
        <div class="flex flex-shrink justify-center md:justify-start text-white font-bold text-gray-200">
            <a href="<?php echo G5_URL?>" class="flex items-center">
                <img src="<?php echo G5_PLUGIN_URL?>/pwa/images/icons/icon-72x72.png" class="w-8"><span class="text-lg pl-2"><?php echo $config['cf_title'];?></span>
            </a>
        </div>
        <div class="flex flex-end justify-center md:justify-start text-white pr-3 text-sm items-center">
            <?php echo outlogin('theme/basic');?>
            <button class="h-10 w-10 -my-2 hover:bg-gray-600" id="Search-btn"> <i class="fa fa-search"></i> </button>
            <button class="h-10 w-10 -my-2 -mr-3 hover:bg-gray-600" id="RightMenu-btn"> <i class="fa fa-bars"></i> </button>
        </div>
    </div>
</nav>
<?php
$menu_color = ['red', 'orange', 'green', 'yellow', 'teal', 'blue', 'indigo', 'purple', 'pink', 'gray'];
$menu_color2 = array_reverse(['red', 'orange', 'green', 'yellow', 'teal', 'blue', 'indigo', 'purple', 'pink', 'gray']);
?>
<div class="flex flex-col md:flex-row">
<div class="bg-gray-900 shadow-lg h-16 fixed bottom-0 md:relative md:h-screen z-50 w-full md:w-48 md:z-10">
    <div id="top_menu" class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between md:overflow-hidden overflow-auto h-full md:overflow-y-auto overflow-y-hidden">
        <ul class="h-full md:h-auto list-reset md:flex-col md:flex whitespace-no-wrap py-0 md:py-3 md:px-1 md:px-2 text-center md:text-left z-20 flex-no-wrap flex items-center self-center">
            <?php
			$menu_datas = get_menu_db(0, true);
            $i = 0;
            foreach( $menu_datas as $row ){
                if( empty($row) ) continue;
                $add_class = (isset($row['sub']) && $row['sub']) ? '<button class="hidden md:flex menu_sub px-2 py-1"> <i class="md:hidden fa fa-caret-down fa-caret-up"></i> <i class="hidden md:block fa fa-caret-down fa-caret-down"></i> </button>' : '';
                $add_mobile_class = (isset($row['sub']) && $row['sub']) ? '<button class="block md:hidden absolute mobile_menu_sub right-0 top-0 h-full flex items-center w-8 justify-center z-20"> <i class="md:hidden fa fa-caret-up"></i> </button> ' : '';
            ?>
            <li class="md:mr-3 md:flex-1 flex-none h-16 md:h-auto justify-center items-center md:w-full w-1/4 relative h-full">
                <div id="<?php echo "parent_menu_".$i?>" class="h-16 md:h-auto flex items-center md:flex justify-center md:w-full md:justify-between menu block md:py-3 md:pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-<?php echo $menu_color[$i]?>-500 md:mt-0" > 
                <a href="<?php echo $row['me_link']; ?>" data-mcolor = "border-<?php echo $menu_color[$i]?>-500" data-menunum="<?php echo $i;?>" data-parentnum="<?php echo $i;?>" target="_<?php echo $row['me_target']; ?>"> <span class="rounded bg-<?php echo $menu_color[$i]?>-500 text-xs md:p-1 md:h-auto p-1 md:w-auto font-bold"><?php echo mb_substr($row['me_name'],0,1) ?></span> <span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block md:mt-0 mt-1"> <?php echo $row['me_name'] ?> </span> </a> <?php echo $add_class?> </div>
                <?php
                $k = 0;
                foreach( (array) $row['sub'] as $row2 ){
                    if( empty($row2) ) continue; 
                    if($k == 0)
                        echo '<span class="bg hidden">하위분류</span><ul class="gnb_2dul_box hidden bottom-0 left-0 md:w-auto w-full z-10">'.PHP_EOL;
                ?>
                    <li class="md:bg-gray-900 bg-gray-800 md:w-auto w-full md:ml-2 py-1 md:py-1 pl-1 align-middle text-white no-underline hover:text-white border-b-2 md:border-gray-800 border-gray-700 hover:border-<?php echo $menu_color2[$k]?>-500 text-sm"><a data-menuNum="<?php echo $i;?>" href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="md:w-full"><?php echo $row2['me_name'] ?></a></li>
                <?php
                $k++;
                }   //end foreach $row2
                if($k > 0)
                    echo '</ul>'.PHP_EOL;
                ?>
            </li>
            <?php
            $i++;
            }   //end foreach $row
            if ($i == 0) {  ?>
                <li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="main-content flex-1 bg-gray-100 mt-12 relative md:mb-0 mb-16 overflow-auto">
<?php if (!defined("_INDEX_")) { ?>
<div class="bg-blue-800 p-2 shadow text-xl text-white">
    <h2 id="container_title" class="font-bold pl-2"><span title="<?php echo get_text($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></span></h2>
</div>
<?php } ?>