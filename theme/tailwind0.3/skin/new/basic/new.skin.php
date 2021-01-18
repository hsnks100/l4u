<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 선택삭제으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;
$write_pages = get_tailwind_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, get_pretty_url($bo_table, '', $qstr.'&amp;page='));

if ($is_admin) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$new_skin_url.'/style.css">', 0);
?>
<?php
$col = ["4rem", "8rem", "auto", "8rem", "4rem"];
if($is_admin) { $col = insert_array($col, 0, "2rem"); };
$group_select = '<label for="gr_id" class="sound_only">그룹</label><div class="relative"><select name="gr_id" id="gr_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"><option value="">전체그룹';
$sql = " select gr_id, gr_subject from {$g5['group_table']} order by gr_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $group_select .= "<option value=\"".$row['gr_id']."\">".$row['gr_subject'];
}
$group_select .= '</select><div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
<svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
</div></div>';
?>
<style>
/*.grid-rows-<?php echo $colspan?> {grid-template-rows: repeat(<?php echo $colspan?>, minmax(0, 1fr));}*/
.v-list{grid-template-columns: <?php echo implode(" ", $col)?>}
</style>
<!-- 전체게시물 검색 시작 { -->
<fieldset id="new_sch" class="mx-3 my-3">
    <div class="py-2 px-1 bg-purple-500 text-white rounded inline-block mb-3">상세검색</div>
    <form name="fnew" method="get" class="block md:flex justify-center">
    <?php echo $group_select ?>
    <label for="view" class="sound_only">검색대상</label>
    <div class="relative">
    <select name="view" id="view" class="w-full my-2 md:my-0 md:w-auto block appearance-none bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        <option value="">전체게시물
        <option value="w">원글만
        <option value="c">코멘트만
    </select>
    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
    </div>
    </div>
    <label for="mb_id" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <div class="relative">
        <input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" required class="w-full h-full md:w-auto bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" size="40">
        <button type="submit" class="btn_submit bg-purple-500 hover:bg-purple-600 text-white px-3 h-full rounded absolute top-0 right-0 "><i class="fas fa-search" aria-hidden="true"></i></button>
    </div>
    </form>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-3" role="alert">
    <span class="block sm:inline">회원 아이디만 검색 가능.</span>
    </div>
    <script>
    /* 셀렉트 박스에서 자동 이동 해제
    function select_change()
    {
        document.fnew.submit();
    }
    */
    document.getElementById("gr_id").value = "<?php echo $gr_id ?>";
    document.getElementById("view").value = "<?php echo $view ?>";
    </script>
</fieldset>
<!-- } 전체게시물 검색 끝 -->

<!-- 전체게시물 목록 시작 { -->
<form name="fnewlist" id="fnewlist" method="post" action="#" onsubmit="return fnew_submit(this);">
<input type="hidden" name="sw"       value="move">
<input type="hidden" name="view"     value="<?php echo $view; ?>">
<input type="hidden" name="sfl"      value="<?php echo $sfl; ?>">
<input type="hidden" name="stx"      value="<?php echo $stx; ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
<input type="hidden" name="page"     value="<?php echo $page; ?>">
<input type="hidden" name="pressed"  value="">

<?php if ($is_admin) { ?>
<div class="flex mx-3 my-3 justify-end">
    <button type="submit" onclick="document.pressed=this.title" title="선택삭제" class="text-gray-100 px-3 py-2 bg-red-500 rounded hover:bg-red-600"><i class="far fa-trash-alt"></i><span class="sound_only">선택삭제</span></button>
</div>
<?php } ?>
<div class="w-full">
    <div class="border-t border-r border-l mx-3 rounded bg-white block md:grid grid-cols-<?php echo $colspan?> gap-0 v-list">
        <?php if ($is_admin) { ?>
        <div class="hidden md:flex border-b border-r chk_box py-2 px-1 items-center">
        	<input type="checkbox" id="all_chk" class="selec_chk form-checkbox h-5 w-5 text-blue-600">
        </div>
        <?php } ?>
        <div class="hidden md:flex border-b border-r px-2 py-1 items-center">그룹</div>
        <div class="hidden md:flex border-b border-r px-2 py-1 items-center">게시판</div>
        <div class="hidden md:flex border-b border-r px-2 py-1 items-center">제목</div>
        <div class="hidden md:flex border-b border-r px-2 py-1 items-center">이름</div>
        <div class="hidden md:flex border-b border-r px-2 py-1 items-center">일시</div>
    <tbody>
    <?php
    for ($i=0; $i<count($list); $i++)
    {
        $num = $total_count - ($page - 1) * $config['cf_page_rows'] - $i;
        $gr_subject = cut_str($list[$i]['gr_subject'], 20);
        $bo_subject = cut_str($list[$i]['bo_subject'], 20);
        $wr_subject = get_text(cut_str($list[$i]['wr_subject'], 80));
    ?>
        <?php if ($is_admin) { ?>
        <div class="py-2 whitespace-no-wrap truncate md:border-b float-left md:float-none clear-both md:border-r px-1 md:flex items-center" class="td_chk chk_box">
            <input type="checkbox" name="chk_bn_id[]" value="<?php echo $i; ?>" id="chk_bn_id_<?php echo $i; ?>" class="selec_chk form-checkbox h-5 w-5 text-blue-600">
            <label for="chk_bn_id_<?php echo $i; ?>">
            	<span></span>
            	<b class="sound_only"><?php echo $num?>번</b>
            </label>
            <input type="hidden" name="bo_table[<?php echo $i; ?>]" value="<?php echo $list[$i]['bo_table']; ?>">
            <input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['wr_id']; ?>">
        </div>
        <?php } ?>
        <div class="py-2 whitespace-no-wrap truncate md:border-b float-left md:float-none md:border-r px-1 md:flex items-center text-xs hover:text-blue-400 text-gray-600" class="td_group"><a href="./new.php?gr_id=<?php echo $list[$i]['gr_id'] ?>"><?php echo $gr_subject ?></a></div>
        <div class="py-2 whitespace-no-wrap truncate md:border-b float-left md:float-none md:border-r px-1 md:flex items-center text-xs hover:text-blue-400 text-gray-600" class="td_board"><a href="<?php echo get_pretty_url($list[$i]['bo_table']); ?>"><?php echo $bo_subject ?></a></div>
        <div class="py-2 whitespace-no-wrap truncate md:border-b float-left md:float-none md:border-r px-1 md:flex items-center text-xs hover:text-blue-400 text-gray-600"><a href="<?php echo $list[$i]['href'] ?>" ><?php echo $list[$i]['comment'] ?><?php echo $wr_subject ?></a></div>
        <div class="py-2 whitespace-no-wrap truncate md:border-b clear-both float-left md:float-none md:border-r px-3 md:flex items-center text-xs text-gray-600" class="td_name"><?php echo $list[$i]['name'] ?></div>
        <div class="py-2 whitespace-no-wrap truncate md:border-b float-right md:float-none md:border-r px-3 md:flex items-center text-xs justify-end text-gray-600" class="td_date"><?php echo $list[$i]['datetime2'] ?></div>
        <div class="md:hidden w-full clearfix border-b"></div>
    <?php } ?>

    <?php if ($i == 0)
        echo '<div style="text-align:center;grid-column: span '.$colspan.'" class="empty_table py-3 border-b">게시물이 없습니다.</div>';
    ?>
    </div>
</div>

<?php echo $write_pages ?>

<?php if ($is_admin) { ?>
<div class="admin_new_btn">
    <button type="submit" onclick="document.pressed=this.title" title="선택삭제" class="btn_b01 btn"><i class="fa fa-trash-o" aria-hidden="true"></i><span class="sound_only">선택삭제</span></button>
</div>
<?php } ?>
</form>

<?php if ($is_admin) { ?>
<script>
$(function(){
    $('#all_chk').click(function(){
        $('[name="chk_bn_id[]"]').attr('checked', this.checked);
    });
});

function fnew_submit(f)
{
    f.pressed.value = document.pressed;

    var cnt = 0;
    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
            cnt++;
    }

    if (!cnt) {
        alert(document.pressed+"할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if (!confirm("선택한 게시물을 정말 "+document.pressed+" 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
        return false;
    }

    f.action = "./new_delete.php";

    return true;
}
</script>
<?php } ?>
<!-- } 전체게시물 목록 끝 -->