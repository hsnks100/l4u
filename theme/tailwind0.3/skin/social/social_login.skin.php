<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if( ! $config['cf_social_login_use']) {     //소셜 로그인을 사용하지 않으면
    return;
}

$social_pop_once = false;

$self_url = G5_BBS_URL."/login.php";

//새창을 사용한다면
if( G5_SOCIAL_USE_POPUP ) {
    $self_url = G5_SOCIAL_LOGIN_URL.'/popup.php';
}
$social_skin_url = str_replace(G5_PATH, G5_URL , get_social_skin_path());
?>

<div class="login-sns sns-wrap-32 sns-wrap-over my-1" id="sns_login">
    <div class="sns-wrap flex justify-center">
        <?php if( social_service_check('naver') ) {     //네이버 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=naver&amp;url=<?php echo $urlencode;?>" class="social_link mx-1" title="네이버">
            <img src="<?php echo $social_skin_url;?>/img/sns_naver_s.png">
        </a>
        <?php }     //end if ?>
        <?php if( social_service_check('kakao') ) {     //카카오 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=naver&amp;url=<?php echo $urlencode;?>" class="social_link mx-1" title="카카오">
            <img src="<?php echo $social_skin_url;?>/img/sns_kakao_s.png">
        </a>
        <?php }     //end if ?>
        <?php if( social_service_check('facebook') ) {     //페이스북 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=naver&amp;url=<?php echo $urlencode;?>" class="social_link mx-1" title="페이스북">
            <img src="<?php echo $social_skin_url;?>/img/sns_fb_s.png">
        </a>
        <?php }     //end if ?>
        <?php if( social_service_check('google') ) {     //구글 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=naver&amp;url=<?php echo $urlencode;?>" class="social_link mx-1" title="구글">
            <img src="<?php echo $social_skin_url;?>/img/sns_gp_s.png">
        </a>
        <?php }     //end if ?>
        <?php if( social_service_check('twitter') ) {     //트위터 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=naver&amp;url=<?php echo $urlencode;?>" class="social_link mx-1" title="트위터">
            <img src="<?php echo $social_skin_url;?>/img/sns_twitter_s.png">
        </a>
        <?php }     //end if ?>
        <?php if( social_service_check('payco') ) {     //페이코 로그인을 사용한다면 ?>
        <a href="<?php echo $self_url;?>?provider=naver&amp;url=<?php echo $urlencode;?>" class="social_link mx-1" title="페이코">
            <img src="<?php echo $social_skin_url;?>/img/sns_payco_s.png">
        </a>
        <?php }     //end if ?>

        <?php if( G5_SOCIAL_USE_POPUP && !$social_pop_once ){
        $social_pop_once = true;
        ?>
        <script>
            jQuery(function($){
                $(".sns-wrap").on("click", "a.social_link", function(e){
                    e.preventDefault();

                    var pop_url = $(this).attr("href");
                    var newWin = window.open(
                        pop_url, 
                        "social_sing_on", 
                        "location=0,status=0,scrollbars=1,width=600,height=500"
                    );

                    if(!newWin || newWin.closed || typeof newWin.closed=='undefined')
                         alert('브라우저에서 팝업이 차단되어 있습니다. 팝업 활성화 후 다시 시도해 주세요.');

                    return false;
                });
            });
        </script>
        <?php } ?>

    </div>
</div>