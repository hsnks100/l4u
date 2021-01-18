<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
$write_pages = get_tailwind_paging( 1, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$search_query.'&amp;gr_id='.$gr_id.'&amp;srows='.$srows.'&amp;onetable='.$onetable.'&amp;page=');
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
$group_select = '<label for="gr_id" class="sound_only">게시판 그룹선택</label><select name="gr_id" id="gr_id" class="select block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"><option value="">전체 분류';
$sql = " select gr_id, gr_subject from {$g5['group_table']} order by gr_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
    $group_select .= "<option value=\"".$row['gr_id']."\"".get_selected($_GET['gr_id'], $row['gr_id']).">".$row['gr_subject']."</option>";
$group_select .= '</select>';
?>
<style>
#sch_res_board{
    overflow:hidden;
    display:flex;
    --text-opacity: 1;
    color: #f7fafc;
    color: rgba(247,250,252,var(--text-opacity));
    padding-left: .75rem;
    padding-right: .75rem;
    padding-top: .5rem;
    padding-bottom: .5rem;
    white-space:nowrap;
}
span.cnt_cmt{
    margin-left:.285rem;
    border-radius:.25rem;
    padding:0.25rem;
    background-color: rgba(56,178,172,var(--bg-opacity));
}
#sch_res_board li a{
    --bg-opacity: 1;
    background-color: #718096;
    background-color: rgba(113,128,150,var(--bg-opacity));
    --text-opacity: 1;
    color: #f7fafc;
    color: rgba(247,250,252,var(--text-opacity));
    margin-right: .25rem;
    font-weight: 600;
    margin-right: .25rem;
    border-radius: .25rem;
    padding-left: .75rem;
    padding-right: .75rem;
    padding-top: .5rem;
    padding-bottom: .5rem;
}
#sch_res_board li:nth-child(1) a{
    --bg-opacity: 1;
    background-color: #38b2ac;
    background-color: rgba(56,178,172,var(--bg-opacity));
    --text-opacity: 1;
    color: #f7fafc;
    color: rgba(247,250,252,var(--text-opacity));
    margin-right: .25rem;
    font-weight: 600;
    border-radius: .25rem;
}
</style>
<!-- 전체검색 시작 { -->
<form name="fsearch" onsubmit="return fsearch_submit(this);" method="get" class="border-b my-8">
<input type="hidden" name="srows" value="<?php echo $srows ?>">
<fieldset id="sch_res_detail" class="flex mx-3">
    <legend class="block uppercase tracking-wide text-gray-700 text-normal font-bold mb-2">상세검색</legend>
    <div class="block w-full md:flex justify-center mb-3">
        <div class="relative block w-full md:w-auto md:flex border-r">
        <?php echo $group_select ?>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path></svg></div>
        </div>
        <script>document.getElementById("gr_id").value = "<?php echo $gr_id ?>";</script>
        <div class="relative py-2 md:py-0">
        <label for="sfl" class="sound_only">검색조건</label>
        <select name="sfl" id="sfl" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
            <option value="wr_subject||wr_content"<?php echo get_selected($_GET['sfl'], "wr_subject||wr_content") ?>>제목+내용</option>
            <option value="wr_subject"<?php echo get_selected($_GET['sfl'], "wr_subject") ?>>제목</option>
            <option value="wr_content"<?php echo get_selected($_GET['sfl'], "wr_content") ?>>내용</option>
            <option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id") ?>>회원아이디</option>
            <option value="wr_name"<?php echo get_selected($_GET['sfl'], "wr_name") ?>>이름</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path></svg></div>
        </div>
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <span class="sch_wr flex">
            <input type="text" name="stx" value="<?php echo $text_stx ?>" id="stx" required class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" size="40">
            <button type="submit" class="btn_submit px-3 bg-teal-400 text-gray-100 hover:bg-teal-500 rounded border"><i class="fa fa-search" aria-hidden="true"></i></button>
        </span>
        <script>
        function fsearch_submit(f)
        {
            if (f.stx.value.length < 2) {
                alert("검색어는 두글자 이상 입력하십시오.");
                f.stx.select();
                f.stx.focus();
                return false;
            }

            // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
            var cnt = 0;
            for (var i=0; i<f.stx.value.length; i++) {
                if (f.stx.value.charAt(i) == ' ')
                    cnt++;
            }

            if (cnt > 1) {
                alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                f.stx.select();
                f.stx.focus();
                return false;
            }

            f.action = "";
            return true;
        }
        </script>

        <div class="switch_field flex items-center self-center md:py-0 py-2 mx-3">
            <input type="radio" value="and" <?php echo ($sop == "and") ? "checked" : ""; ?> id="sop_and" name="sop">
            <label for="sop_and" class="mr-3">AND</label>
            <input type="radio" value="or" <?php echo ($sop == "or") ? "checked" : ""; ?> id="sop_or" name="sop" >
            <label for="sop_or">OR</label>
        </div>
    </div>
</fieldset>
</form>

<div id="sch_result">
    <?php
    if ($stx) {
        if ($board_count) {
    ?>
    <section id="sch_res_ov" class="mx-3 p-3 my-3 border border-blue-300 bg-blue-100 md:flex block justify-between">
        <span class="block md:flex text-white rounded-full bg-indigo-500 uppercase px-2 py-1 font-bold mr-3 text-center"> 전체검색 결과 <strong class="text-red-500 px-1"> <?php echo $stx ?> </strong> </span> 
        <ul class="block w-full py-2 md:py-0 text-right md:w-auto md:flex items-center justify-end text-sm text-gray-700 divide-x divide-gray-700">
            <li class="inline-block px-2">게시판 <?php echo $board_count ?>개</li>
            <li class="inline-block px-2">게시물 <?php echo number_format($total_count) ?>개</li>
        	<li class="inline-block px-2"><?php echo number_format($page) ?>/<?php echo number_format($total_page) ?> 페이지 열람 중</li>
        </ul>
    </section>
    <?php
        }
    }
    ?>

    <?php
    if ($stx) {
        if ($board_count) {
     ?>
    <ul id="sch_res_board">
        <li><a href="?<?php echo $search_query ?>&amp;gr_id=<?php echo $gr_id ?>" <?php echo $sch_all ?>>전체게시판</a></li>
        <?php echo $str_board_list; ?>
    </ul>
    <?php
        } else {
     ?>
    <div class="h-32 flex items-center justify-center">검색된 자료가 하나도 없습니다.</div>
    <?php } }  ?>

    <hr>

    <?php if ($stx && $board_count) { ?><section class="sch_res_list"><?php }  ?>
    <?php
    $k=0;
    for ($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) {
     ?>
		<div class="search_board_result py-3">
        <div class="border-b flex justify-between">
        <div class="py-3 mx-3 font-bold flex text-gray-700"><a href="<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>"><?php echo $bo_subject[$idx] ?> 게시판 내 결과</a></div>
		<a href="<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>" class="sch_more flex items-center mx-3 text-xs text-blue-600 hover:text-blue-900">더보기</a>
        </div>
        <ul class="py-3">
        <?php
        for ($i=0; $i<count($list[$idx]) && $k<$rows; $i++, $k++) {
            if ($list[$idx][$i]['wr_is_comment'])
            {
                $comment_def = '<span class="cmt_def"><i class="far fa-comment-dots"></i><span class="sound_only">댓글</span></span> ';
                $comment_href = '#c_'.$list[$idx][$i]['wr_id'];
            }
            else
            {
                $comment_def = '';
                $comment_href = '';
            }
         ?>

            <li class="border-b">
                <div class="sch_tit mx-3 pt-2 text-xl text-gray-700">
                    <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" class="sch_res_title"><?php echo $comment_def ?><?php echo $list[$idx][$i]['subject'] ?></a>
                    <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" target="_blank" class="pop_a"><i class="fa fa-window-restore" aria-hidden="true"></i><span class="sound_only">새창</span></a>
                </div>
                <p class="mx-3 text-gray-700 py-2 px-2"><?php echo $list[$idx][$i]['content'] ?></p>
                <div class="sch_info mx-3 py-2 text-xs text-gray-700">
                    <?php echo $list[$idx][$i]['name'] ?>
                    <span class="sch_datetime"><i class="far fa-clock"></i> <?php echo $list[$idx][$i]['wr_datetime'] ?></span>
                </div>
            </li>
        <?php }  ?>
        </ul>
		</div>
    <?php }		//end for?>
    <?php if ($stx && $board_count) {  ?></section><?php }  ?>

    <?php echo $write_pages ?>

</div>
<!-- } 전체검색 끝 -->