<template>
  <div id="app" class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'theme-dark': dark }">
    <gnu-header> </gnu-header>
    <div class="flex flex-col flex-1" style="min-height:100vh">
      <gnu-top> </gnu-top>
      <router-view ref="body"></router-view>
    </div>
    <button style="display:none" id="themeChange" aria-label="Toggle color mode" @click="dark = !dark"> </button>
    <!--<gnu-footer> </gnu-footer>-->
  </div>
</template>

<script>
import head from './head.vue';
import Top from './top.vue';
//import tail from './tail.vue';
export default {
  name: 'app',
  components: {
    'gnu-header' : head,
    'gnu-top' : Top,
    //'gnu-footer' : tail,
  },
  data: function () {
    return {
      dark: !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
    }
  },
}
</script>

<style>
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
html, body {font-family: "Noto Sans KR", sans-serif !important;}
/* 캡챠 자동등록(입력)방지 기본 -pc */
#captcha {display:inline-block;position:relative}
#captcha legend {position:absolute;margin:0;padding:0;font-size:0;line-height:0;text-indent:-9999em;overflow:hidden}
#captcha #captcha_img {height:40px;border:1px solid #898989;vertical-align:top;padding:0;margin:0}
#captcha #captcha_mp3 {margin:0;padding:0;width:40px;height:40px;border:0;background:transparent;vertical-align:middle;overflow:hidden;cursor:pointer;text-indent:-999px;border-radius:3px}
#captcha #captcha_reload {margin:0;padding:0;width:40px;height:40px;border:0;background:transparent;vertical-align:middle;overflow:hidden;cursor:pointer;text-indent:-999px;border-radius:3px}
#captcha #captcha_key {margin:0 0 0 3px;padding:0 5px;width:90px;height:40px;border:1px solid #ccc;background:#fff;font-size:1.333em;font-weight:bold;text-align:center;border-radius:3px;vertical-align:top}
#captcha #captcha_info {display:block;margin:5px 0 0;font-size:0.95em;letter-spacing:-0.1em}

/* 캡챠 자동등록(입력)방지 기본 - mobile */
#captcha.m_captcha audio {display:block;margin:0 0 5px;width:187px}
#captcha.m_captcha #captcha_img {width:160px;height:60px;border:1px solid #e9e9e9;margin-bottom:3px;margin-top:5px;display:block}
#captcha.m_captcha #captcha_reload {position:static;margin:0;padding:0;width:40px;height:40px;border:0;background:transparent;vertical-align:middle;overflow:hidden;cursor:pointer;text-indent:-999px}
#captcha.m_captcha #captcha_reload span {display:none}
#captcha.m_captcha #captcha_key {margin:0;padding:0 5px;width:115px;height:29px;border:1px solid #b8c9c2;background:#f7f7f7;font-size:1.333em;font-weight:bold;text-align:center;line-height:29px;margin-left:3px}
#captcha.m_captcha #captcha_info {display:block;margin:5px 0 0;font-size:0.95em;letter-spacing:-0.1em}
#captcha.m_captcha #captcha_mp3 {width:31px;height:31px;vertical-align:top;overflow:hidden;cursor:pointer;text-indent:-9999px;border:none}
</style>
