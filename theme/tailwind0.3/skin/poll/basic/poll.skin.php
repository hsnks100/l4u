<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>

<!-- 설문조사 시작 { -->
<form name="fpoll" action="<?php echo G5_BBS_URL ?>/poll_update.php" onsubmit="return fpoll_submit(this);" method="post" class="block py-3 border-b border-gray-700">
<input type="hidden" name="po_id" value="<?php echo $po_id ?>">
<input type="hidden" name="skin_dir" value="<?php echo urlencode($skin_dir); ?>">
<section id="poll" class="mx-3 block text-gray-200">
    <header class="flex justify-between">
        <span class="rounded-full bg-pink-500 uppercase px-2 py-1 text-xs font-bold text-normal">설문조사</span>
		<?php if ($is_admin == "super") {  ?><a href="<?php echo G5_ADMIN_URL ?>/poll_form.php?w=u&amp;po_id=<?php echo $po_id ?>" class="btn_admin w-6 h-6 justify-center text-xs bg-red-500 hover:bg-red-600 rounded-lg flex items-center self-center" title="설문관리"><i class="fa fa-cog fa-fw"></i><span class="sound_only">설문관리</span></a><?php }  ?>
    </header>
    <div class="poll_con">
        <p><?php echo $po['po_subject'] ?></p>
        <ul>
            <?php for ($i=1; $i<=9 && $po["po_poll{$i}"]; $i++) {  ?>
            <li class="chk_box">
	        	<input type="radio" name="gb_poll" value="<?php echo $i ?>" id="gb_poll_<?php echo $i ?>">
	        	<label for="gb_poll_<?php echo $i ?>">
	        		<span></span>
	        		<?php echo $po['po_poll'.$i] ?>
	        	</label>
	        </li>
            <?php }  ?>
        </ul>
        <div id="poll_btn">
            <button type="submit" class="btn_poll bg-teal-500 hover:bg-teal-600 py-1 px-1 w-full rounded my-2 text-sm">투표하기</button>
        </div>
    </div>
    <a href="<?php echo G5_BBS_URL."/poll_result.php?po_id=$po_id&amp;skin_dir=".urlencode($skin_dir); ?>" onclick="poll_result(this.href); return false;" class="popup_href btn_result block bg-purple-500 hover:bg-purple-600 py-1 text-sm px-1 w-full rounded my-2 text-center">결과보기</a>
</section>
</form>

<script>
function fpoll_submit(f)
{
    <?php
    if ($member['mb_level'] < $po['po_level']){?>
        Swal_Ko.fire({
            title: '경고',
            html: '권한 <?php echo $po['po_level']?> 이상의 회원만 결과를 보실 수 있습니다.',
            showCancelButton: false,
        });
    <?php }?>

    var chk = false;
    for (i=0; i<f.gb_poll.length;i ++) {
        if (f.gb_poll[i].checked == true) {
            chk = f.gb_poll[i].value;
            break;
        }
    }

    if (!chk) {
        Swal_Ko.fire({
            title: '경고',
            html: '투표하실 항목을 선택하세요',
            showCancelButton: false,
        });
        return false;
    }
    Swal.fire({
        customClass: {
            popup : 'bg-gray-900',
            container : 'p-0'
        },
        html : '<iframe class="w-full m-0 p-0" id="swal_popup" name="swal_poup" src="'+g5_theme_url+'/form.php?name='+f.name.toString()+'" style="height:50vh"> </iframe>',
        showCancelButton : false,
        showConfirmButton : false,
    });
    return false;
    //var new_win = window.open("about:blank", "win_poll", "width=616,height=500,scrollbars=yes,resizable=yes");
    //f.target = "swal_popup";

    return true;
}

function poll_result(url)
{
    <?php
    if ($member['mb_level'] < $po['po_level']){?>
        Swal_Ko.fire({
            title: '경고',
            html: '권한 <?php echo $po['po_level']?> 이상의 회원만 결과를 보실 수 있습니다.',
            showCancelButton: false,
        });
    <?php }?>
    //win_poll(url);
}
</script>
<!-- } 설문조사 끝 -->