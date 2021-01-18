<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

$g5['title'] = strip_tags($g5['title']);
$g5_head_title = strip_tags($g5_head_title);

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">'.PHP_EOL;
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">'.PHP_EOL;
}

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<title><?php echo $g5_head_title; ?></title>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<link rel="stylesheet" href="<?php echo run_replace('head_css_url', G5_THEME_CSS_URL.'/'.(G5_IS_MOBILE ? 'tailwind.min' : 'tailwind.min').'.css?ver='.G5_CSS_VER, G5_THEME_URL); ?>">
<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_theme_url = "<?php echo G5_THEME_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
</script>
<?php
add_javascript('<script src="'.G5_JS_URL.'/jquery-1.12.4.min.js"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/jquery-migrate-1.4.1.min.js"></script>', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/jquery.menu.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/common.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/sweetalert2.min.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/wrest.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_THEME_JS_URL.'/common.js?ver='.G5_JS_VER.'"></script>', 1);
add_javascript('<script src="'.G5_JS_URL.'/placeholders.min.js"></script>', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/balloon.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/dark.css">', 0);
add_stylesheet('<link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/notosanskr.css">', 0);

if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>
<style>
body, html{font-family: "Noto Sans KR", sans-serif !important;}
.swal2-popup{border:1px solid #888 !important}
/* 사이드뷰 */
.sv_wrap {display:inline-block;position:relative;font-weight:normal;line-height:20px}
.sv_wrap .sv {z-index:1000;width:110px;display:none;margin:5px 0 0;font-size:0.92em;background:#333;text-align:left;white-space:normal;
-webkit-box-shadow:2px 2px 3px 0px rgba(0,0,0,0.2);
-moz-box-shadow:2px 2px 3px 0px rgba(0,0,0,0.2);
box-shadow:2px 2px 3px 0px rgba(0,0,0,0.2)}
.sv_wrap .sv:before {content:"";position:absolute;top:-6px;left:15px;width:0;height:0;border-style:solid;border-width:0 6px 6px 6px;border-color:transparent transparent #333 transparent}
.sv_wrap .sv a {display:inline-block;width:110px;margin:0;padding:0 10px;line-height:30px;font-weight:normal;color:#bbb;vertical-align:middle;white-space:nowrap;}
.sv_wrap .sv a:hover {background:#000;color:#fff}
.sv_wrap .profile_img{float:left;}
.sv_member {color:#333;font-weight:bold}
.sv_on {display:block !important;position:fixed;top:23px;left:0px;width:auto;height:auto}
.sv_nojs .sv {display:block}
.sound_only{display:none}
</style>
</head>
<body class="md:bg-gray-900 bg-gray-100 font-sans leading-normal tracking-normal min-h-screen" <?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>