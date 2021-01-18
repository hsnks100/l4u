<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->

<article id="bo_v" class="w-full mt-3">
    <section class="mx-3 border bg-white mb-3 px-3 rounded"> <!-- 여백 및 본문 내용 -->
    <header class="py-3 border-b">
        <h2 id="bo_v_title">
            <?php if ($category_name) { ?>
            <span class="bo_v_cate bg-gray-800 p-2 rounded text-gray-100"><?php echo $view['ca_name']; // 분류 출력 끝 ?></span> 
            <?php } ?>
            <span class="bo_v_tit">
              <?php echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력 ?>
            </span>
        </h2>
    </header>

    <section id="bo_v_info" class="border-b flex">
        <h2 class="sound_only">페이지 정보</h2>
        <div class="profile_info flex items-center w-full py-1">
        	<div class="profile_info_ct items-center flex w-full">
        		<span class="sound_only">작성자</span> <span class="whitespace-no-wrap md:mr-0 mr-3"> <?php echo $view['name'] ?> </span> <?php if ($is_ip_view) { echo "<span class='text-xs'> ($ip)</span>"; } ?>
            </div>
            <div class="flex ml-2 w-full justify-end text-xs whitespace-no-wrap flex-wrap">
       		 	<span class="sound_only">댓글</span><span class="px-1 text-gray-600"><a href="#bo_vc"> <i class="far fa-comment-dots"></i> <?php echo number_format($view['wr_comment']) ?>건</a></span>
        		<span class="sound_only">조회</span><span class="px-1 text-gray-600"><i class="far fa-eye"></i> <?php echo number_format($view['wr_hit']) ?>회</span>
        		<span class="if_date px-1 text-gray-600"><span class="sound_only">작성일</span><i class="far fa-clock"></i> <?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></span>
    		</div>
    	</div>

    	<!-- 게시물 상단 버튼 시작 { -->
	    <div id="bo_v_top">
	        
	    </div>
	    <!-- } 게시물 상단 버튼 끝 -->
    </section>
    <?php ob_start(); ?>
	<ul class="flex py-3 border-b justify-end whitespace-no-wrap">
		<li class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a href="<?php echo $list_href ?>" title="목록"> <i class="fa fa-list" aria-hidden="true"></i> <span class="hidden md:inline-block">목록</span></a></li>
	    <?php if ($reply_href) { ?><li class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a href="<?php echo $reply_href ?>" title="답변"><i class="fas fa-reply"></i></i> <span class="hidden md:inline-block">답변</span></a></li><?php } ?>
	    <?php if ($write_href) { ?><li class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a href="<?php echo $write_href ?>" title="글쓰기"><i class="fas fa-pencil-alt"></i><span class="hidden md:inline-block"> 글쓰기</span></a></li><?php } ?>
		<?php if($update_href || $delete_href || $copy_href || $move_href || $search_href) { ?>
	    <?php if ($update_href) { ?><li class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a href="<?php echo $update_href ?>"><i class="far fa-edit"></i> <span class="hidden md:inline-block">수정</span></a></li><?php } ?>
	    <?php if ($delete_href) { ?><li class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;"><i class="fa fa-trash-alt"></i> <span class="hidden md:inline-block">삭제</span></a></li><?php } ?>
	    <?php if ($copy_href) { ?><li class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;"><i class="far fa-copy"></i> <span class="hidden md:inline-block">복사</span></a></li><?php } ?>
	    <?php if ($move_href) { ?><li class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;"><i class="fas fa-arrows-alt"></i> <span class="hidden md:inline-block">이동</span></a></li><?php } ?>
	    <?php if ($search_href) { ?><li class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a href="<?php echo $search_href ?>"><i class="fas fa-search"></i> <span class="hidden md:inline-block">검색</span></a></li><?php } ?>
		<?php } ?>
	</ul>
	<?php
	$link_buttons = ob_get_contents();
	ob_end_flush();
	?>
    <section id="bo_v_atc" class="pb-3">
        <h2 id="bo_v_atc_title" class="sound_only">본문</h2>
        <div id="bo_v_share" class="flex py-3 justify-end whitespace-no-wrap">
        	<?php include_once(G5_THEME_SNS_PATH."/view.sns.skin.php"); ?>
	        <?php if ($scrap_href) { ?><a href="<?php echo $scrap_href;  ?>" target="_blank" class="px-2 py-1 bg-gray-200 mx-2 rounded hover:bg-gray-400" onclick="win_scrap(this.href); return false;"><i class="fa fa-bookmark" aria-hidden="true"></i> 스크랩</a><?php } ?>
	    </div>

        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->        
        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <!--  추천 비추천 시작 { -->
        <?php if ( $good_href || $nogood_href) { ?>
        <div id="bo_v_act" class="flex justify-center w-full">
            <?php if ($good_href) { ?>
            <div class="border rounded-full h-12 w-12 flex items-center justify-center hover:border-green-300 hover:text-green-300 mr-3">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="bo_v_good"><i class="far fa-thumbs-up"></i><span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good"></b>
            </div>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="border rounded-full h-12 w-12 flex items-center justify-center hover:border-red-300 hover:text-red-300">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="bo_v_nogood"><i class="far fa-thumbs-down"></i><span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act" class="flex justify-center w-full">
            <?php if($board['bo_use_good']) { ?><span class="border rounded-full h-12 w-12 flex items-center justify-center hover:border-green-300 hover:text-green-300 mr-3 cursor-not-allowed	bo_v_good"><i class="far fa-thumbs-up"></i></i><span class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span class="border rounded-full h-12 w-12 flex items-center justify-center hover:border-red-300 hover:text-red-300 cursor-not-allowed bo_v_nogood"><i class="far fa-thumbs-down"></i><span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <!-- }  추천 비추천 끝 -->
    </section>

    <?php
    $cnt = 0;
    if ($view['file']['count']) {
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
	?>

    <?php if($cnt) { ?>
     <!-- 첨부파일 시작 { -->
    <section id="bo_v_file" class="border w-full my-2 px-2 py-1">
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <p>
                    <i class="fa fa-folder-open" aria-hidden="true"></i>
                    <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download hover:text-teal-800" download>
                        <strong><?php echo $view['file'][$i]['source'] ?></strong> <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                    </a>
                </p>
                <p class="text-right">
                    <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드 | DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
                </p>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php if(isset($view['link'][1]) && $view['link'][1]) { ?>
    <!-- 관련링크 시작 { -->
    <section id="bo_v_link">
        <h2>관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
            ?>
            <li>
                <i class="fa fa-link" aria-hidden="true"></i>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <strong><?php echo $link ?></strong>
                </a>
                <br>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
            <?php
            }
        }
        ?>
        </ul>
    </section>
    <!-- } 관련링크 끝 -->
    <?php } ?>
    </section> <!-- 여백 및 본문 내용 테두리-->
    <?php if ($prev_href || $next_href) { ?>
    <div class="mx-3">
    <ul class="w-full border rounded bg-white">
        <?php if ($prev_href) { ?><li class="btn_prv hover:bg-gray-300 py-3 px-4 border-b"><span class="nb_tit mr-3"><i class="fa fa-chevron-up" aria-hidden="true"></i> 이전글</span><a href="<?php echo $prev_href ?>"><?php echo $prev_wr_subject;?></a> <span class="nb_date float-right"><?php echo str_replace('-', '.', substr($prev_wr_date, '2', '8')); ?></span></li><?php } ?>
        <?php if ($next_href) { ?><li class="btn_next hover:bg-gray-300 py-3 px-4"><span class="nb_tit mr-3"><i class="fa fa-chevron-down" aria-hidden="true"></i> 다음글</span><a href="<?php echo $next_href ?>"><?php echo $next_wr_subject;?></a>  <span class="nb_date float-right"><?php echo str_replace('-', '.', substr($next_wr_date, '2', '8')); ?></span></li><?php } ?>
    </ul>
    </div>
    <?php } ?>

    <?php
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
	?>
</article>
<!-- } 게시판 읽기 끝 -->

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            Swal_Ko.fire({
                title: '경고',
                html: '다운로드 권한이 없습니다.<br>회원이시라면 로그인 후 이용해 보십시오."',
            });
            return false;
        }
        var _this = $(this);
        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.<br>포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.<br>그래도 다운로드 하시겠습니까?";
        Swal_Ko.fire({
            title: '경고',
            html: msg,
            showCancelButton: true,
        }).then((result) => {
            if (result.value) {
                var href = _this.attr("href")+"&js=on";
                _this.attr("href", href);
                return true;
            }else{
                return false;
            }
        });
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        Swal.fire({
            imageUrl: $(this).find('img').attr('src'),
            showCancelButton : false,
            showConfirmButton : false,
        });
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                Swal_Ko.fire({
                    title: '경고',
                    text: data.error,
                });
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    Toast.fire({
                        icon: 'success',
                        title: '이 글을 비추천하셨습니다.'
                    });
                } else {
                    Toast.fire({
                        icon: 'success',
                        title: '이 글을 추천하셨습니다.'
                    });
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->