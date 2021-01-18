<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css">', 0);
?>

<!-- FAQ 시작 { -->
<?php
if ($himg_src)
    echo '<div id="faq_himg" class="faq_img"><img src="'.$himg_src.'" alt=""></div>';

// 상단 HTML
echo '<div id="faq_hhtml" class="mx-3">'.conv_content($fm['fm_head_html'], 1).'</div>';
?>
<div class="inline-block sch_tit w-auto text-white mt-3 mx-3 rounded-full bg-indigo-500 uppercase px-4 py-2 text-xl font-bold mr-3">FAQ 검색</div>
<fieldset id="faq_sch" class="my-3 mx-3 relative">
    <legend class="sound_only">FAQ 검색</legend>
    <form name="faq_search_form" method="get">
    <input type="hidden" name="fm_id" value="<?php echo $fm_id;?>">
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <div class="relative">
    <input type="text" name="stx" value="<?php echo $stx;?>" required id="stx" class="flex w-full bg-gray-200 appearance-none border-2 border-gray-400 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" size="15" maxlength="15">
    <button type="submit" value="검색" class="absolute right-0 top-0 btn_submit py-2 px-4 bg-purple-500 text-gray-100 hover:bg-purple-400 rounded"><i class="fas fa-search" aria-hidden="true"></i> 검색</button>
    </div>
    </form>
</fieldset>
<?php
if( count($faq_master_list) ){
?>
<nav id="bo_cate" class="mx-3 my-3">
    <h2 class="sound_only">자주하시는질문 분류</h2>
    <ul id="bo_cate_ul" class="flex">
        <?php
        foreach( $faq_master_list as $v ){
            $category_msg = '';
            $category_option = '';
            if($v['fm_id'] == $fm_id){ // 현재 선택된 카테고리라면
                $category_option = ' id="bo_cate_on" class="bg-blue-800 p-2 rounded-lg text-gray-100 mx-1 block"';
                $category_msg = '<span class="sound_only">열린 분류 </span>';
            }else{
                $category_option = ' class="bg-gray-800 p-2 rounded-lg text-gray-100 mx-1 block"';
            }
        ?>
        <li><a href="<?php echo $category_href;?>?fm_id=<?php echo $v['fm_id'];?>" <?php echo $category_option;?> ><?php echo $category_msg.$v['fm_subject'];?></a></li>
        <?php
        }
        ?>
    </ul>
</nav>
<?php } ?>

<div id="faq_wrap" class="faq_<?php echo $fm_id; ?> mx-3">
    <?php // FAQ 내용
    if( count($faq_list) ){
    ?>
    <section id="faq_con" class="border rounded">
        <h2 class="bg-blue-800 px-3 py-1 shadow text-xl text-white"><?php echo $g5['title']; ?> 목록</h2>
        <ol>
            <?php
            foreach($faq_list as $key=>$v){
                if(empty($v))
                    continue;
            ?>
            <li class="border-b">
                <h3 class="bg-white hover:bg-gray-200 px-3 py-3">
                	<span class="tit_bg">Q</span><a href="#none" onclick="return faq_open(this);"><?php echo conv_content($v['fa_subject'], 1); ?></a>
                	<button class="tit_btn" onclick="return faq_open(this);"><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only">열기</span></button>
                </h3>
                <div class="con_inner hidden pl-5 pr-3 py-3 bg-gray-200 border-t text-sm">
                    <?php echo conv_content($v['fa_content'], 1); ?>
                    <button type="button" class="closer_btn"><i class="fa fa-minus" aria-hidden="true"></i><span class="sound_only">닫기</span></button>
                </div>
            </li>
            <?php
            }
            ?>
        </ol>
    </section>
    <?php

    } else {
        if($stx){
            echo '<p class="empty_list">검색된 게시물이 없습니다.</p>';
        } else {
            echo '<div class="empty_list">등록된 FAQ가 없습니다.';
            if($is_admin)
                echo '<br><a href="'.G5_ADMIN_URL.'/faqmasterlist.php">FAQ를 새로 등록하시려면 FAQ관리</a> 메뉴를 이용하십시오.';
            echo '</div>';
        }
    }
    ?>
</div>

<?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

<?php
// 하단 HTML
echo '<div id="faq_thtml">'.conv_content($fm['fm_tail_html'], 1).'</div>';

if ($timg_src)
    echo '<div id="faq_timg" class="faq_img"><img src="'.$timg_src.'" alt=""></div>';
?>


<!-- } FAQ 끝 -->

<?php
if ($admin_href)
    echo '<div class="faq_admin mx-3 text-right"><a href="'.$admin_href.'" class="inline-block px-3 py-2 bg-red-500 text-white rounded" title="FAQ 수정"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">FAQ 수정</span></a></div>';
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script>
jQuery(function() {
    $(".closer_btn").on("click", function() {
        $(this).closest(".con_inner").slideToggle('slow', function() {
			var $h3 = $(this).closest("li").find("h3");

			$("#faq_con li h3").removeClass("faq_li_open");
			if($(this).is(":visible")) {
				$h3.addClass("faq_li_open");
			}
		});
    });
});

function faq_open(el)
{	
    var $con = $(el).closest("li").find(".con_inner"),
		$h3 = $(el).closest("li").find("h3");

    if($con.is(":visible")) {
        $con.slideUp();
		$h3.removeClass("faq_li_open");
    } else {
        $("#faq_con .con_inner:visible").css("display", "none");

        $con.slideDown(
            function() {
                // 이미지 리사이즈
                $con.viewimageresize2();
				$("#faq_con li h3").removeClass("faq_li_open");

				$h3.addClass("faq_li_open");
            }
        );
    }

    return false;
}
</script>