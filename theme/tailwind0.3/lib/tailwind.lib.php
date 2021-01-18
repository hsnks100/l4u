<?php
define('G5_THEME_SNS_PATH', G5_THEME_PATH.'/skin/sns');
// 한페이지에 보여줄 행, 현재페이지, 총페이지수, URL
function get_tailwind_paging($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&page=[0-9]*(&page=)$#', '$1', $url);
    $url = preg_replace('#&page=[0-9]*#', '', $url) . '&page=';
    $str = '';
    if ($cur_page > 1) {
        $str .= '<a href="'.$url.'1'.$add.'"><button type="button" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-700 md:bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Previous">
        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
        </svg>
      </button></a>'.PHP_EOL;
    }
    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;
    if ($end_page >= $total_page) $end_page = $total_page;
    if ($start_page > 1) $str .= '<a href="'.$url.($start_page-1).$add.'"><button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-700 md:bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">이전</button></a>'.PHP_EOL;
    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= '<a href="'.$url.$k.$add.'"><button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-700 md:bg-white text-sm leading-5 font-medium text-gray-200 md:text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">'.$k.'</button></a>'.PHP_EOL;
            else
                $str .= '<span class="-ml-px relative inline-flex items-center px-4 py-2 md:bg-teal-500 bg-teal-700 text-white border border-gray-300 text-sm leading-5 font-medium">'.$k.'</span>'.PHP_EOL;
        }
    }
    if ($total_page > $end_page) $str .= '<a href="'.$url.($end_page+1).$add.'"><button type="button" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-700 md:bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">다음</button></a>'.PHP_EOL;
    if ($cur_page < $total_page) {
        $str .= '<a href="'.$url.$total_page.$add.'"><button type="button" class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-700 md:bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" aria-label="Next">
        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
        </svg>
      </button></a>'.PHP_EOL;
    }
    if ($str)
        return "<div class='flex justify-center my-3'><nav class=\"relative z-0 inline-flex shadow-sm\">{$str}</nav></div>";
    else
        return "";
}
function get_tailwind_category(){
  global $board, $bo_table, $category, $sca; 
  if ($board['bo_use_category']) {
    $is_category = true;
    $category_href = get_pretty_url($bo_table);

    $category_option .= '<li><a href="'.$category_href.'"';
    if ($sca=='')
      $category_option .= ' id="bo_cate_on" class="px-3 py-2 bg-teal-500 hover:bg-teal-700 text-gray-100 font-semibold rounded mr-1"';
    else
      $category_option .= ' id="bo_cate_on" class="px-3 py-2 bg-gray-600 hover:bg-teal-500 text-gray-100 font-semibold rounded mr-1"';
    $category_option .= '>전체</a></li>';

    $categories = explode('|', $board['bo_category_list']); // 구분자가 , 로 되어 있음
    for ($i=0; $i<count($categories); $i++) {
        $category = trim($categories[$i]);
        if ($category=='') continue;
        $category_option .= '<li><a href="'.(get_pretty_url($bo_table,'','sca='.urlencode($category))).'"';
        $category_msg = '';
        if ($category==$sca) { // 현재 선택된 카테고리라면
            $category_option .= ' id="bo_cate_on" class="px-3 py-2 bg-teal-500 hover:bg-teal-500 text-gray-100 font-semibold rounded mr-1"';
            $category_msg = '<span class="sound_only">열린 분류 </span>';
        }else{
            $category_option .= ' id="bo_cate_on" class="px-3 py-2 bg-gray-600 hover:bg-teal-500 text-gray-100 font-semibold rounded mr-1"';
        }
        $category_option .= '>'.$category_msg.$category.'</a></li>';
    }
  }
  return $category_option;
}
function insert_array( $arr , $idx , $add ){       
  $arr_front = array_slice ( $arr , 0, $idx ); //처음부터 해당 인덱스까지 자름
  $arr_end = array_slice ( $arr , $idx ); //해당인덱스 부터 마지막까지 자름
  $arr_front [] = $add ; //새 값 추가
  return array_merge ( $arr_front , $arr_end );
}
// 캡챠 HTML 코드 출력
function tailwind_captcha_html($class="captcha")
{
  global $config;
  if($config['cf_captcha'] == "kcaptcha"){
    $html .= "\n".'<script>var g5_captcha_url  = "'.G5_CAPTCHA_URL.'";</script>';
    //$html .= "\n".'<script>var g5_captcha_path = "'.G5_CAPTCHA_PATH.'";</script>';
    $html .= "\n".'<script src="'.G5_CAPTCHA_URL.'/kcaptcha.js"></script>';
    $html .= "\n".'<div class="block text-left overflow-hidden">';
    $html .= "\n".'<div id="captcha" class="flex md:inline-block float-left mt-3 items-center h-16">';
    //$html .= "\n".'<legend><label for="captcha_key">자동등록방지</label></legend>';
    //if (is_mobile()) $html .= '<audio id="captcha_audio" controls></audio>';
    //$html .= "\n".'<img src="#" alt="" id="captcha_img">';
    $html .= "\n".'<img src="'.G5_CAPTCHA_URL.'/img/dot.gif" alt="" id="captcha_img" class="rounded border float-left">';
    $html .= "\n".'<div class="h-full float-left text-left">';
    $html .= "\n".'<button type="button" id="captcha_mp3" class="md:h-8 md:bg-gray-200 bg-gray-800 broder border-gray-800 hover:bg-gray-700 h-8 w-10 md:w-8 md:hover:bg-gray-300 text-gray-200 md:text-gray-800 block"><i class="fas fa-music"></i><span class="sound_only">숫자음성듣기</span></button>';
    $html .= "\n".'<button type="button" id="captcha_reload" class="md:h-8 md:bg-gray-200 bg-gray-800 broder border-gray-800 hover:bg-gray-700 w-10 h-8 md:p-0 p-1 md:w-8 md:hover:bg-gray-300 text-gray-200 md:text-gray-800 block"><i class="fas fa-sync-alt"></i><span class="sound_only">새로고침</span></button>';
    $html .= "\n".'</div>';
    $html .= "\n".'</div>';
    $html .= "\n".'<div class="float-left mt-1 clearfix mt-3 md:h-16">';
    $html .= "\n".'<input type="text" name="captcha_key" id="captcha_key" placeholder="capthca here.." required class="h-16 captcha_box required bg-gray-200 appearance-none border-2 border-gray-200 rounded md:py-1 md:px-4 px-3 py-1 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" size="6" maxlength="6">';
    $html .= "\n".'</div>';
    $html .= "\n".'</div>';
    $html .= "\n".'<div id="captcha_info" class="text-left clearfix font-bold text-xs">자동등록방지 숫자를 순서대로 입력하세요.</div>';
    return $html;
  }else if($config['cf_captcha'] == "recaptcha"){
    global $config;

    $html = '<fieldset id="captcha" class="captcha recaptcha mt-2">';
    $html .= '<script src="https://www.google.com/recaptcha/api.js?hl=ko"></script>';
    $html .= '<script src="'.G5_CAPTCHA_URL.'/recaptcha.js"></script>';
    $html .= '<div class="g-recaptcha" data-sitekey="'.$config['cf_recaptcha_site_key'].'"></div>';
    $html .= '</fieldset>';

	  return $html;
  }else if($config['cf_captcha'] == "recaptcha_inv"){
    global $config;

    $html = '<fieldset id="captcha" class="captcha mt-2">';
    $html .= '<script src="https://www.google.com/recaptcha/api.js?hl=ko"></script>';
    $html .= '<script src="'.G5_CAPTCHA_URL.'/recaptcha.js"></script>';
    $html .= '<div id="recaptcha" class="g-recaptcha" data-sitekey="' . $config['cf_recaptcha_site_key'] . '" data-callback="recaptcha_validate" data-badge="inline" data-size="invisible"></div>';
    $html .= '<script>jQuery("#recaptcha").hide().parent(".invisible_recaptcha").hide().closest(".is_captcha_use").hide();</script>';
    $html .= '</fieldset>';

	return $html;
  }
}
function get_yt_id($input){
  $input = preg_match('/```youtube(([\s\S]+?[\s\S]))```/i', $input, $match);
  $youtube_url = $match[1];
  $regExp = '~https?://(?:[0-9A-Z-]+\.)?(?:youtu\.be/|youtube(?:-nocookie)?\.com\S*[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:[\'"][^<>]*>|</a>))[?=&+%\w.-]*~ix';
  preg_match($regExp, $youtube_url, $matches);
  $youtube_id = $matches[1];
  $match[1] = $youtube_id ? $youtube_id : $match[1];
  $result['ori'] = "https://img.youtube.com/vi/$match[1]/maxresdefault.jpg";
  if($match[1]) return $result;
  else return '';
}
// 에디터 이미지 얻기
function get_markdown_image($contents)
{
    if(!$contents)
        return false;
    //![!\[image\]](https://allthatnba.com/data/editor/2005/2106571035_1590930277.3077.png)
    
    $pattern = '/\!\[(.+)\]\((.*?)\"(.+?)\"\)/i';
    $pattern = '/!\[.*\](\((.+)\))/i';
    preg_match_all($pattern, $contents, $matchs);    
    return $matchs;
}

// 게시글보기 썸네일 생성
function get_markdown_thumbnail($contents, $thumb_width=0)
{
    global $board, $config;
    if (!$thumb_width)
        $thumb_width = $board['bo_image_width'];
    
    // $contents 중 img 태그 추출
    $matches = get_markdown_image($contents);
    if(empty($matches))
        return $contents;
    $content = array();
    $content['ori'] = $matches[2][0];
    $content['alt'] = get_text($matches[1][0]);
    return $content;
}
// 게시글보기 최신글 썸네일 생성
function get_markdown_latest_thumbnail($bo_table, $wr_id, $latest = false)
{
    global $g5, $board, $config;
    if (!$thumb_width)
        $thumb_width = $board['bo_image_width'];
    if($latest == true) {
        $sql = "SELECT wr_content FROM ".$g5['write_prefix'].$bo_table." WHERE wr_id = '{$wr_id}'";
        $row = sql_fetch($sql);
        $contents = $row['wr_content'];
    }
    // $contents 중 img 태그 추출
    $matches = get_markdown_image($contents);
    
    if(empty($matches))
        return $contents;
    $content = array();
    $content['ori'] = $matches[2][0];
    $content['alt'] = get_text($matches[1][0]);
    return $content;
}
?>