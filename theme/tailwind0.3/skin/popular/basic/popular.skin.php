<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<!-- 인기검색어 시작 { -->
<section id="popular" class="block w-full">
    <div class="inline-block rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3 text-gray-200 whitespace-no-wrap mb-2">인기검색어</div>
    <div class="popular_inner break-words inline-block">
	    <ul class="break-words">
        <?php if(!isset($list)){?>
            최근 검색어가 없습니다.
        <?php }?>
	    <?php
	    if( isset($list) && is_array($list) ){
	        for ($i=0; $i<count($list); $i++) {
	        ?>
	        <li class="inline-block mb-2 rounded-full bg-teal-500 uppercase px-2 py-1 text-xs font-bold mr-3 text-gray-200 mb-2"># <a href="<?php echo G5_BBS_URL ?>/search.php?sfl=wr_subject&amp;sop=and&amp;stx=<?php echo urlencode($list[$i]['pp_word']) ?>"><?php echo get_text($list[$i]['pp_word']); ?></a></li>
	        <?php
	        }   //end for
	    }   //end if
	    ?>
	    </ul>
    </div>
</section>
<!-- } 인기검색어 끝 -->