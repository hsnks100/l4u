<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
#autosave_wrapper {position:relative}
#autosave_pop {display:none;z-index:10;position:absolute !important;top:34px;right:0;width:350px;height:auto !important;height:180px;max-height:180px;border:1px solid #565656;background:#fff;
-webkit-box-shadow:2px 2px 3px 0px rgba(0,0,0,0.2);
-moz-box-shadow:2px 2px 3px 0px rgba(0,0,0,0.2);
box-shadow:2px 2px 3px 0px rgba(0,0,0,0.2)}
#autosave_pop:before {content:"";position:absolute;top:-8px;right:45px;width:0;height:0;border-style:solid;border-width:0 6px 8px 6px;border-color:transparent transparent #000 transparent}
#autosave_pop:after {content:"";position:absolute;top:-7px;right:45px;width:0;height:0;border-style:solid;border-width:0 6px 8px 6px;border-color:transparent transparent #fff transparent}
html.no-overflowscrolling #autosave_pop {height:auto;max-height:10000px !important} /* overflow 미지원 기기 대응 */
#autosave_pop strong {position:absolute;font-size:0;line-height:0;overflow:hidden}
#autosave_pop div {text-align:center;margin:0 !important}
#autosave_pop button {margin:0;padding:0;border:0}
#autosave_pop ul {padding:15px;border-top:1px solid #e9e9e9;list-style:none;overflow-y:scroll;height:130px;border-bottom:1px solid #e8e8e8}
#autosave_pop li {padding:8px 5px;border-bottom:1px solid #fff;background:#eee;zoom:1}
#autosave_pop li:after {display:block;visibility:hidden;clear:both;content:""}
#autosave_pop a {display:block;float:left}
#autosave_pop span {display:block;float:right;font-size:0.92em;font-style:italic;color:#999}
.autosave_close {cursor:pointer;width:100%;height:30px;background:none;color:#888;font-weight:bold;font-size:0.92em}
.autosave_close:hover {background:#f3f3f3;color:#3597d9}
.autosave_content {display:none}
.autosave_del {background:url(./img/close_btn.png) no-repeat 50% 50%;text-indent:-999px;overflow:hidden;height:20px;width:20px}
</style>
<section id="bo_w" class="w-full mt-3">
    <h2 class="sound_only"><?php echo $g5['title'] ?></h2>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" class="flex flex-wrap" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) { 
        $option = '';
        if ($is_notice) {
            $option .= PHP_EOL.'<li class="inline-flex items-center mt-3 ml-3"><input type="checkbox" id="notice" name="notice"  class="selec_chk form-checkbox h-5 w-5 text-blue-600" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice" class="ml-2 text-gray-700"><span></span>공지</label></li>';
        }
        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= PHP_EOL.'<li class="inline-flex items-center mt-3 ml-3"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" class="selec_chk form-checkbox h-5 w-5 text-blue-600" value="'.$html_value.'" '.$html_checked.'>'.PHP_EOL.'<label class="ml-2 text-gray-700" for="html"><span></span>html</label></li>';
            }
        }
        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= PHP_EOL.'<li class="inline-flex items-center mt-3 ml-3"><input type="checkbox" id="secret" name="secret"  class="selec_chk form-checkbox h-5 w-5 text-blue-600" value="secret" '.$secret_checked.'>'.PHP_EOL.'<label class="ml-2 text-gray-700" for="secret"><span></span>비밀글</label></li>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }
        if ($is_mail) {
            $option .= PHP_EOL.'<li class="inline-flex items-center mt-3 ml-3"><input type="checkbox" id="mail" name="mail"  class="selec_chk form-checkbox h-5 w-5 text-blue-600" value="mail" '.$recv_email_checked.'>'.PHP_EOL.'<label class="ml-2 text-gray-700" for="mail"><span></span>답변메일받기</label></li>';
        }
    }
    echo $option_hidden;
    ?>

    <?php if ($is_category) { ?>
    <div class="bo_w_select bo_w_info w-full px-3 mb-6 md:mb-0">
        <label for="ca_name" class="sound_only">분류<strong>필수</strong></label>
        <div class="relative">
        <select name="ca_name" id="ca_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" required>
            <option value="">분류를 선택하세요</option>
            <?php echo $category_option ?>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
        </div>
        </div>
    </div>
    <?php } ?>

	    <?php if ($is_name) { ?>
            <div class="bo_w_info w-full md:w-1/2 px-3 mb-6 md:mb-0">
	        <label for="wr_name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">이름</label>
	        <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" placeholder="이름">
            </div>
	    <?php } ?>
	
	    <?php if ($is_password) { ?>
            <div class="bo_w_info w-full md:w-1/2 px-3 mb-6 md:mb-0">
	        <label for="wr_password" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">비밀번호</label>
	        <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 <?php echo $password_required ?>" placeholder="비밀번호">
            </div>
	    <?php } ?>
	
	    <?php if ($is_email) { ?>
            <div class="bo_w_info w-full md:w-1/2 px-3 mb-6 md:mb-0">
			<label for="wr_email" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">이메일</label>
			<input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 email " placeholder="이메일">
            </div>
	    <?php } ?>
	    
	
	    <?php if ($is_homepage) { ?>
            <div class="bo_w_info w-full md:w-1/2 px-3 mb-6 md:mb-0">
	        <label for="wr_homepage" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">홈페이지</label>
	        <input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" size="50" placeholder="홈페이지">
            </div>
	    <?php } ?>
	
    <?php if ($option) { ?>
    <div class="write_div">
        <span class="sound_only">옵션</span>
        <ul class="bo_v_option">
        <?php echo $option ?>
        </ul>
    </div>
    <?php } ?>

    <div class="bo_w_tit w-full px-3 mb-6 md:mb-4">
        <div class="flex justify-between">
        <label for="wr_subject" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">제목</label>
        <div id="autosave_wrapper" class="w-auto whitespace-no-wrap text-xs mr-3 relative">
            <?php if ($is_member) { // 임시 저장된 글 기능 ?>
            <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
            <?php if($editor_content_js) echo $editor_content_js; ?>
                <button type="button" id="btn_autosave" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-2 rounded">임시 저장된 글 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
                <div id="autosave_pop" class="absolute z-10 top-0 mt-5 right-0 hidden bg-white border px-3 py-2 leading-8">
                    <ul></ul>
                    <div><button type="button" class="autosave_close">닫기</button></div>
                </div>
            <?php } ?>
        </div>
        </div>
        <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" size="50" maxlength="255" placeholder="제목">
        
    </div>

    <div class="w-full px-3 mb-6 md:mb-4">
        <label for="wr_content" class="sound_only">내용<strong>필수</strong></label>
        <div class="wr_content <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
            <?php if($write_min || $write_max) { ?>
            <!-- 최소/최대 글자 수 사용 시 -->
            <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
            <?php } ?>
            <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
            <?php if($write_min || $write_max) { ?>
            <!-- 최소/최대 글자 수 사용 시 -->
            <div id="char_count_wrap"><span id="char_count"></span>글자</div>
            <?php } ?>
        </div>
        
    </div>

    <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
    <div class="bo_w_link write_div w-full px-3 mb-6 md:mb-4 flex">
        <label class="appearance-none py-3 px-4" for="wr_link<?php echo $i ?>"><i class="fa fa-link" aria-hidden="true"></i><span class="sound_only"> 링크  #<?php echo $i ?></span></label>
        <input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){ echo $write['wr_link'.$i]; } ?>" id="wr_link<?php echo $i ?>" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" size="50">
    </div>
    <?php } ?>

    <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
    <div class="bo_w_flie write_div w-full px-3 mb-6 md:mb-4 flex relative">
        <label for="bf_file_<?php echo $i+1 ?>" class="appearance-none py-3 px-4"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sound_only"> 파일 #<?php echo $i+1 ?></span></label>
        <input type="file" name="bf_file[]" id="bf_file_<?php echo $i+1 ?>" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        <?php if ($is_file_content) { ?>
        <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="border-l appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" size="50" placeholder="파일 설명을 입력해주세요.">
        <?php } ?>

        <?php if($w == 'u' && $file[$i]['file']) { ?>
        <span class="file_del absolute top-0 right-0 mr-5 py-3 text-xs flex items-center h-full">
            <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
        </span>
        <?php } ?>
        
    </div>
    <?php } ?>


    <?php if ($is_use_captcha) { //자동등록방지  ?>
    <div class="write_div mx-3 md:mx-8">
        <?php echo tailwind_captcha_html() ?>
    </div>
    <?php } ?>

    <div class="btn_confirm float-right text-right clearfix w-full px-3 text-sm">
        <a href="<?php echo get_pretty_url($bo_table); ?>" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">취소</a>
        <button type="submit" id="btn_submit" accesskey="s" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">작성완료</button>
    </div>
    </form>

    <script>
    <?php if($write_min || $write_max) { ?>
    // 글자수 제한
    var char_min = parseInt(<?php echo $write_min; ?>); // 최소
    var char_max = parseInt(<?php echo $write_max; ?>); // 최대
    check_byte("wr_content", "char_count");

    $(function() {
        $("#wr_content").on("keyup", function() {
            check_byte("wr_content", "char_count");
        });
    });

    <?php } ?>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            Swal_Ko.fire({
                title: '줄바꿈',
                html : '자동 줄바꿈을 하시겠습니까?<br>자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.',
                showCancelButton: true,
                }).then((result) => {
                if (result.value) {
                    obj.value = "html2";
                }else{
                    obj.value = "html1";    
                }
            });
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            Swal_Ko.fire({text : "제목에 금지단어('"+subject+"')가 포함되어있습니다"});;
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            Swal_Ko.fire({text : "내용에 금지단어('"+content+"')가 포함되어있습니다"});;
            if (typeof(ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));
                if (char_min > 0 && char_min > cnt) {
                    Swal_Ko.fire({text : "내용은 "+char_min+"글자 이상 쓰셔야 합니다."});;
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    Swal_Ko.fire({text : "내용은 "+char_max+"글자 이하로 쓰셔야 합니다."});;
                    return false;
                }
            }
        }

        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>
</section>
<!-- } 게시물 작성/수정 끝 -->