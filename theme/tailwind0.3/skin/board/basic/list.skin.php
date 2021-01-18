<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$write_pages = get_tailwind_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, get_pretty_url($bo_table, '', $qstr.'&amp;page='));
$category_option = get_tailwind_category();
// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;
$col = ["2.5rem", "auto", "8rem", "4rem", "4rem"];
if($is_checkbox) { $col = insert_array($col, 0, "2rem"); };
if($is_good) { $col = insert_array($col, $colspan, "4rem"); };
if($is_nogood) { $col = insert_array($col, $colspan, "4rem"); };
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<style>
/*.grid-rows-<?php echo $colspan?> {grid-template-rows: repeat(<?php echo $colspan?>, minmax(0, 1fr));}*/
.v-list{grid-template-columns: <?php echo implode(" ", $col)?>}
</style>
<!-- 게시판 목록 시작 { -->
    <div id="bo_list" class="w-full">

    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
    <nav id="bo_cate" class="my-3">
        <h2 class="sound_only"><?php echo $board['bo_subject'] ?> 카테고리</h2>
        <ul id="bo_cate_ul" class="flex mx-3">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <?php } ?>
    <!-- } 게시판 카테고리 끝 -->
    
    <form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div id="bo_btn_top">
        <div id="bo_list_total" class="flex m-3 justify-end md:text-sm text-xs">
            <div class="border-gray-800 bg-gray-300 p-2 rounded">
            <span>Total <?php echo number_format($total_count) ?>건 </span>
            <?php echo $page ?> 페이지
            </div>
        </div>

        <ul class="flex mx-3 my-3 justify-end">
        	<?php if ($admin_href) { ?><li class=""><a class='hover:bg-red-700 bg-red-500 text-white py-2 px-2 mx-1 rounded text-sm block' href="<?php echo $admin_href ?>" data-balloon-pos="down-right" aria-label="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li><?php } ?>
            <?php if ($rss_href) { ?><li class=""><a class="hover:bg-indigo-700 bg-indigo-500 text-white py-2 px-2 mx-1 rounded text-sm block" href="<?php echo $rss_href ?>" data-balloon-pos="down-right" aria-label="RSS"><i class="fas fa-rss"></i></i><span class="sound_only">RSS</span></a></li><?php } ?>
            <li>
            	<button type="button" class="hover:bg-purple-700 bg-purple-500 text-white py-2 px-2 mx-1 rounded text-sm board-search" data-balloon-pos="down-right" aria-label="게시판 검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">게시판 검색</span></button>
            </li>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="block hover:bg-teal-700 bg-teal-500 text-white py-2 px-2 mx-1 rounded text-sm" data-balloon-pos="down-right" aria-label="글쓰기"><i class="fas fa-pencil-alt"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
        	<?php if ($is_admin == 'super' || $is_auth) {  ?>
        	<li>
        		<?php if ($is_checkbox) { ?>	
		        <ul class="more_opt flex justify-start">  
		            <li> <button class="board-opt border hover:bg-red-700 bg-red-500 text-white py-2 px-3 mx-1 rounded text-sm" type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"><i class="fas fa-trash-alt"></i></i> <span class="md:inline-block hidden"> 선택삭제 </span> </button></li>
		            <li> <button class="board-opt border hover:bg-green-700 bg-green-500 text-white py-2 px-3 mx-1 rounded text-sm" type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"><i class="far fa-file-alt"></i> <span class="md:inline-block hidden"> 선택복사 </span> </button></li>
		            <li> <button class="board-opt border hover:bg-indigo-700 bg-indigo-500 text-white py-2 px-3 mx-1 rounded text-sm" type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"><i class="fas fa-arrows-alt"></i> <span class="md:inline-block hidden"> 선택이동 </span> </button></li>
		        </ul>
		        <?php } ?>
        	</li>
        	<?php }  ?>
        </ul>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->
    <div class="sound_only"><?php echo $board['bo_subject'] ?> 목록</div>
    <div class="border-t border-r border-l mx-3 rounded bg-white block md:grid grid-cols-<?php echo $colspan?> gap-0 v-list">
        <?php if ($is_checkbox) { ?>
        <div class="hidden md:inline-flex items-center border-b border-r justify-center">
        	<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk form-checkbox h-5 w-5 text-blue-600">
            <b class="sound_only">현재 페이지 게시물  전체선택</b>
        </div>
        <?php } ?>
        <div class="hidden md:block py-2 border-r border-b whitespace-no-wrap text-center">번호</div>
        <div class="hidden md:block py-2 border-r border-b pl-2">제목</div>
        <div class="hidden md:block py-2 border-r border-b pl-2 text-center">글쓴이</div>
        <div class="hidden md:block py-2 border-r border-b text-center"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회 </a></div>
        <?php if ($is_good) { ?><div class="hidden md:block py-2 border-r border-b text-center"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천 </a></div><?php } ?>
        <?php if ($is_nogood) { ?><div class="hidden md:block py-2 border-r border-b text-center"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천 </a></div><?php } ?>
        <div class="hidden md:block py-2 border-b text-center"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜  </a></div>
        <?php
        for ($i=0; $i<count($list); $i++) {
        	if ($i%2==0) $lt_class = "even";
            else $lt_class = "";
            if($list[$i]['is_notice']) $notice = "bg-blue-100";
            else $notice = '';
		?>
        <?php if ($is_checkbox) { ?>
        <div class="float-right absolute md:relative md:float-none md:inline-flex items-center md:py-0 py-1 md:px-0 px-1 md:border-b md:border-r justify-center py-2 md:py-0 <?php echo $notice?>">
            <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="selec_chk form-checkbox h-5 w-5 text-blue-600 mt-1 md:mt-0">
            <b class="sound_only">현재 페이지 게시물  전체선택</b>
        </div>
        <?php } ?>
        <div class="hidden md:block md:float-none text-center md:h-auto py-2 md:border-r md:border-b text-gray-700 text-sm <?php echo $notice?>">
            <?php 
            if ($list[$i]['is_notice']) // 공지사항
                echo '<strong class="notice_icon">공지</strong>';
            else if ($wr_id == $list[$i]['wr_id'])
                echo "<span class=\"bo_current\">열람중</span>";
            else
                echo "<span class=''>".$list[$i]['num']."</span>";
            ?>
        </div>
        <a href="<?php echo $list[$i]['href']?>" class="<?php if($is_checkbox){?> pl-8 md:pl-2 <?php }?>float-left md:float-none md:inline-block hover:bg-gray-200 py-2 pl-2 md:border-r md:border-b whitespace-no-wrap truncate w-full <?php echo $notice?>"> 
            <span>
                <?php echo ($list[$i]['icon_reply']) ? '<i class="fas fa-reply transform rotate-180"></i>' : '' ?>
            <?php
            if ($is_category && $list[$i]['ca_name']) {
			?>
                <span class="bo_v_cate bg-gray-800 inline-block p-1 text-xs justify-center rounded text-gray-100"> <?php echo $list[$i]['ca_name'] ?> </span>
            <?php } ?>
                <?php echo $list[$i]['subject']?>
            </span>
            <?php
            if ($list[$i]['icon_new']) echo '<span class="bg-green-400 px-2 py-1 rounded text-white text-xs">N</span>';
            if ($list[$i]['icon_hot']) echo '<i class="ml-1 text-red-700 fab fa-hotjar"></i>';
            if ($list[$i]['icon_file']) echo '<i class="ml-1 text-gray-700 fas fa-download"></i>';
            if ($list[$i]['icon_link']) echo '<i class="ml-1 text-gray-700 fas fa-link"></i>';
            if ($list[$i]['icon_secret']) echo '<i class="ml-1 text-gray-700 fas fa-lock"></i>';
			?>
            <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><span class="bg-blue-500 text-white text-xs py-1 px-2 rounded"><?php echo $list[$i]['wr_comment']; ?></span><span class="sound_only">개</span><?php } ?>
        </a>
        <div class="md:flex md:items-center clear-both float-left whitespace-no-wrap truncate md:border-b py-1 pl-2 md:border-r text-gray-600 md:mr-0 mr-2 md:text-gray-700 text-sm md:mr-0 <?php echo $notice?>"><?php echo $list[$i]['name']?></div>
        <div class="md:flex md:items-center md:justify-end float-left md:float-none py-1 pr-2 md:border-r md:border-b text-right text-gray-600 md:mr-0 mr-2 md:text-gray-700 md:text-sm text-xs <?php echo $notice?>"><i class="md:hidden far fa-eye"></i> <?php echo $list[$i]['wr_hit']?></div>
        <?php if ($is_good) { ?><div class="md:flex md:items-center md:justify-end float-left md:float-none py-1 pr-2 text-right md:border-r md:border-b text-gray-600 md:mr-0 mr-2 md:text-gray-700 md:text-sm text-xs <?php echo $notice?>"><i class="md:hidden far fa-thumbs-up"></i> <?php echo $list[$i]['wr_good']?> </div><?php } ?>
        <?php if ($is_nogood) { ?><div class="md:flex md:items-center md:justify-end float-left md:float-none py-1 pr-2 text-right md:border-r md:border-b text-gray-600 md:mr-0 mr-2 md:text-gray-700 md:text-sm text-xs <?php echo $notice?>"><i class="md:hidden far fa-thumbs-down"></i> <?php echo $list[$i]['wr_nogood']?> </div><?php } ?>
        <div class="md:flex md:items-center md:justify-end md:float-none float-right py-1 pl-1 text-sm md:border-b text-right pr-2 whitespace-no-wrap text-gray-600 md:mr-0 md:text-gray-700 <?php echo $notice?>"><?php echo $list[$i]['datetime2'] ?></div>
        <div class="md:flex md:items-center md:justify-end md:hidden clearfix border-b border-t w-full -mt-px <?php echo $notice?>"></div>
        <?php }?>
        <?php echo count($list) == 0 ? '<div class="text-center border-b py-1" style="grid-column: span '.$colspan.';"> 게시물이 없습니다. </div>' : ''; ?>
    </div>
	<!-- 페이지 -->
	<?php echo $write_pages; ?>
	<!-- 페이지 -->
	
    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($list_href || $write_href) { ?>
        <ul class="flex mx-3 my-3 justify-end">
            <?php if ($admin_href) { ?><li class=""><a class='hover:bg-red-700 bg-red-500 text-white py-2 px-2 mx-1 rounded text-sm block' href="<?php echo $admin_href ?>" data-balloon-pos="up-right" aria-label="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li><?php } ?>
            <?php if ($rss_href) { ?><li class=""><a class="hover:bg-indigo-700 bg-indigo-500 text-white py-2 px-2 mx-1 rounded text-sm block" href="<?php echo $rss_href ?>" data-balloon-pos="up-right" aria-label="RSS"><i class="fas fa-rss"></i></i><span class="sound_only">RSS</span></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="block hover:bg-teal-700 bg-teal-500 text-white py-2 px-2 mx-1 rounded text-sm" data-balloon-pos="up-right" aria-label="글쓰기"><i class="fas fa-pencil-alt"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
        </ul>	
        <?php } ?>
    </div>
    <?php } ?>   
    </form>

    <!-- 게시판 검색 시작 { -->
    <script>
    var search = [
            '<form name="fsearch" class="w-full" method="get">',
            '<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">',
            '<input type="hidden" name="sca" value="<?php echo $sca ?>">',
            '<input type="hidden" name="sop" value="and">',
            '<label for="sfl" class="sound_only">검색대상</label>',
            '<div class="relative">',
            '<select name="sfl" class="block appearance-none w-full bg-gray-600 border border-gray-200 text-gray-100 py-3 px-4 pr-8 rounded leading-tight focus:outline-none" id="sfl">',
                '<?php echo get_board_sfl_select_options($sfl); ?>',
            '</select>',
            '<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-200">',
                '<svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>',
            '</div>',
            '</div>',
            '<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>',
            '<div class="mt-2 flex relative">',
                '<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="appearance-none block w-full bg-gray-600 text-gray-100 border-l rounded-l border-gray-100 py-3 px-4 leading-tight focus:outline-none" id="grid-first-name" size="25" maxlength="20" placeholder=" 검색어를 입력해주세요">',
                '<button type="submit" value="검색" class="sch_btn py-1 px-4 bg-gray-600 rounded-r border-l border-gray-500"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>',
            '</div>',
            '</form>',
        ].join('');
    $(function(){
        $('.board-search').click(function (e) { 
            e.preventDefault();
            Swal.fire({
                footer: search,
                html: '검색',
                showCloseButton: false,
                showCancelButton: false,
                showConfirmButton: false,
            })
        });
    })
    </script>
    <!-- } 게시판 검색 끝 --> 
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        Swal_Ko.fire({text : document.pressed + " 할 게시물을 하나 이상 선택하세요."});
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        Swal_Ko.fire({
            title: document.pressed,
            html : '선택한 게시물을 정말 삭제하시겠습니까?<br>한번 삭제한 자료는 복구할 수 없습니다<br>답변글이 있는 게시글을 선택하신 경우<br>답변글도 선택하셔야 게시글이 삭제됩니다.',
            showCancelButton: true,
        }).then((result) => {
            if (result.value) {
                f.removeAttribute("target");
                f.action = g5_bbs_url+"/board_list_update.php";
                $(f).prepend('<input type="hidden" name="btn_submit" value="'+document.pressed+'">');
                f.submit();
                return false;
            }else{
                return false;   
            }
        });
    }
    return false;
}
// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = g5_bbs_url+"/move.php";
    f.submit();
}

// 게시판 리스트 관리자 옵션
jQuery(function($){
    $(document).on("click", function (e) {
        if(!$(e.target).closest('.is_list_btn').length) {
            $(".more_opt.is_list_btn").hide();
        }
    });
});
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
