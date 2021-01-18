<?php
function login_check($mb, $link, $is_social_login) {
  global $g5, $config;
  unset($mb['mb_password']);
  echo json_encode($mb, JSON_UNESCAPED_UNICODE);
  exit;
}
function password_wrong($login, $mb) {
  echo '{ "msg" : "가입된 회원아이디가 아니거나 비밀번호가 틀립니다.\\n비밀번호는 대소문자를 구분합니다."}';
  exit;
}
function logout($link) {
  echo '{ "msg" : "로그아웃에 성공하였습니다."}';
  exit;
}
function vue_alert($msg='', $url='', $error=true, $post=false) {
  global $g5, $config, $member;
  global $is_admin;
  $msg = strip_tags($msg, '<br>');
  $msg = str_replace("<br>", "\\n", $msg);
  echo '{"msg" : "'.$msg.'"}';
  exit;
}
function vue_alert_close($msg, $error=true) {
  global $g5;
  $msg = strip_tags($msg, '<br>');
  $msg = str_replace("<br>", "\\n", $msg);
  echo '{"msg" : "'.$msg.'"}';
  exit;
}
// confirm 창
function vue_confirm($msg, $url1='', $url2='', $url3='') {
  global $g5;
  if (!$msg) {
    $msg = '올바른 방법으로 이용해 주십시오.';
    alert($msg);
  }
  if(!trim($url1) || !trim($url2)) {
    $msg = $url1.' 과 '.$url2.' 를 지정해 주세요.';
    alert($msg);
  }
  $msg = strip_tags($msg, '<br>');
  $msg = str_replace("<br>", "\\n", $msg);
  if (!$url3) $url3 = clean_xss_tags($_SERVER['HTTP_REFERER']);
  echo '{"msg" : "'.$msg.'"}';
  exit;
}
add_event('alert', 'vue_alert',10,2); 
add_event('alert_close', 'vue_alert_close',10,2); 
add_event('confirm', 'vue_confirm',10,2); 
//글쓰기
function write_update($board, $wr_id, $w, $qstr, $redirect_url) {
  echo '{"redirect_url" : "'.str_replace(G5_URL, '', $redirect_url).'"}';
  exit;
}
function write_comment_update($board, $wr_id, $w, $qstr, $redirect_url, $comment_id, $reply_array) {
  echo '{"redirect_url" : "'.str_replace(G5_URL, '', $redirect_url).'"}';
  exit;
}
function unset_data($data) {
  unset($data['cf_icode_id']);
  unset($data['cf_icode_pw']);
  unset($data['cf_googl_shorturl_apikey']);
  unset($data['cf_google_clientid']);
  unset($data['cf_google_secret']);
  unset($data['cf_icode_server_ip']);
  unset($data['cf_icode_server_port']);
  unset($data['cf_icode_token_key']);
  unset($data['cf_icode_token_key']);
  unset($data['member']['mb_password']);
  unset($data['sql']);
  unset($data['sql2']);
  unset($data['sql3']);
  unset($data['sql_search']);
  unset($data['sql_common']);
  unset($data['sql_order']);
  unset($data['write']['wr_password']);
  unset($data['result']);
  unset($data['config']['cf_recaptcha_secret_key']);
  unset($data['config']['cf_recaptcha_site_key']);
  if(is_array($data['list'])){
    for ($i=0; $i < count($data['list']); $i++) { 
      unset($data['list'][$i]['wr_ip']);
      unset($data['list'][$i]['wr_password']);
    }
  }
  unset($data['view']['wr_password']);
  unset($data['view']['wr_ip']);
  return $data;
}
function delete_all($tmp_array, $board) {
  global $bo_table, $page, $qstr;
  $redirect_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&page='.$page.$qstr);
  echo '{"redirect_url" : "'.str_replace(G5_URL, '', $redirect_url).'"}';
  exit;
}
function delete($write, $board) {
  global $bo_table, $page, $qstr;
  $redirect_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&page='.$page.$qstr);
  echo '{"redirect_url" : "'.str_replace(G5_URL, '', $redirect_url).'"}';
  exit;
}
function delete_comment($comment_id, $board) {
  global $bo_table, $page, $qstr,$write;
  $redirect_url = short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$_POST['wr_id'].'&amp;page='.$page. $qstr);
  echo '{"redirect_url" : "'.str_replace(G5_URL, '', $redirect_url).'"}';
  exit;
}
function VueCaptcha(){
  global $config;
  if($config['cf_captcha'] == "kcaptcha") {
    include_once(G5_PLUGIN_PATH.'/kcaptcha/kcaptcha_config.php');
    while(true){
      $keystring='';
      for($i=0;$i<$length;$i++){
          $keystring.=$allowed_symbols[mt_rand(0,strlen($allowed_symbols)-1)];
      }
      if(!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $keystring)) break;
    }
    set_session("ss_captcha_count", 0);
    set_session("ss_captcha_key", $keystring);
    return $keystring;
  }
}
?>