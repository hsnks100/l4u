<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');

add_javascript('<script src="'.G5_THEME_JS_URL.'/unslider.min.js"></script>', 10);
function get_web_page($url) {
    echo $url;
    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
            
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);

    curl_close($ch);

    return $content;
    
}
?>

<link href="theme/community/nbattle.css" rel="stylesheet" type="text/css">

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<div id="app">

    <table class="type11" width="100%">
    <thead>
    <tr>
    <th scope="cols">ID</th>
    <th scope="cols">ELO</th>
    <th scope="cols">승</th>
    <th scope="cols">패</th>
    <th scope="cols">승률</th>
    <th scope="cols">그래프 보기</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="rank in ranks">
    <td>{{rank.mb_nick}}</td>
    <td>{{rank.mb_1}}</td>
    <td>{{rank.wins}}</td>
    <td>{{rank.loses}}</td>
    <td>{{rank.rate}} %</td>
    <td>준비중</td>
    </tr>
    </tbody>

    </table>

</div>
<script>
var app = new Vue({
        el: '#app',
        created: function() {
            var thiz = this;
            axios.get(`/api/get_elo_rank.php`)
                 .then(function(response) {
                     for(var i=0; i<response.data.length; i++) {
                         response.data[i].wins *= 1;
                         response.data[i].loses *= 1;
                         response.data[i].rate = response.data[i].wins / (response.data[i].wins + response.data[i].loses) * 100.0;
                     }
                     thiz.ranks = response.data;
                 }).catch(function(err) {

                 });

            
        },
        data: {
            message: '안녕하세요 Vue!',
            ranks: [],
              
        }
        
    });

</script>
<!--메인배너 {-->
<!--
<div id="main_bn_box">
    <div id="main_bn">
        <ul class="bn_ul">
            <li class="bn_bg1">
                <div class="bn_wr"><a href="#none"><img src="<?php echo G5_THEME_IMG_URL ?>/main_banner.png" alt="메인베너" /></a></div>
            </li>
            <li class="bn_bg1">
                <div class="bn_wr"><a href="#none"><img src="<?php echo G5_THEME_IMG_URL ?>/main_banner.png" alt="메인베너" /></a></div>
            </li>
            <li class="bn_bg1">
                <div class="bn_wr"><a href="#none"><img src="<?php echo G5_THEME_IMG_URL ?>/main_banner.png" alt="메인베너" /></a></div>
            </li>
            <li class="bn_bg1">
                <div class="bn_wr"><a href="#none"><img src="<?php echo G5_THEME_IMG_URL ?>/main_banner.png" alt="메인베너" /></a></div>
            </li>
        </ul>
    </div>
</div>
-->
<!--} 메인배너-->
<script>
$(function() {
    $("#main_bn").unslider({
        speed: 700,               //  The speed to animate each slide (in milliseconds)
        delay: 3000,              //  The delay between slide animations (in milliseconds)
        keys: true,               //  Enable keyboard (left, right) arrow shortcuts
        dots: true,               //  Display dot navigation
        fluid: false              //  Support responsive design. May break non-responsive designs
    });
    $('.unslider-arrow').click(function() {
        var fn = this.className.split(' ')[1];

        //  Either do unslider.data('unslider').next() or .prev() depending on the className
        unslider.data('unslider')[fn]();
        });
    });
</script>


<section class="idx_cnt">
	
</section>
<?php
// include_once(G5_PATH . "/api/get_elo_rank.php");
// echo $mytemp;
// $rr = get_web_page("https://localhost:8890" . "/api/get_elo_rank.php");
echo $rr ;

$resArr = json_decode($rr);

include_once(G5_SKIN_PATH . '/content/custom/content.skin.php');
?>





<?php
include_once(G5_THEME_PATH.'/tail.php');
?>
