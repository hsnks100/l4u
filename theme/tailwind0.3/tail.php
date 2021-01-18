<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}
?>
<script>
$(document).on('click', '#RightMenu-btn, #RightMenu-close', function (e) {
    e.preventDefault();
    $("#RightMenu").toggle();
});
</script>
<!--오른쪽 사이드 메뉴 {-->
<div class="fixed h-screen h-full md:w-64 w-2/3 bg-gray-900 top-0 right-0 z-20 hidden" id="RightMenu">
    <div class="h-full w-full pt-3 text-gray-100 overflow-y-auto pb-16 md:pb-0">
        <button class="absolute top-0 left-0 -mx-12 w-12 h-12 z-50 text-gray-100 hover:bg-gray-700 bg-gray-900" id="RightMenu-close"> <i class="fas fa-times"> </i> </button>
        <?php echo outlogin('theme/side');?>
        <?php if($is_member){?>
            <div class="mx-3 text-xs"> <button id="push-subscription-button" class="block w-full bg-indigo-600 hover:bg-indigo-700 py-1 mt-2 rounded">구독하기</button> </div>
        <?php }else{?>
            <button id="push-subscription-button" class="hidden">구독하기</button>
        <?php }?>
        <?php echo poll('theme/basic'); // 설문조사, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>
        <?php echo visit('theme/basic'); // 접속자집계, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>
    </div>
</div>
<!-- } 오른쪽 사이드 메뉴 -->
<div class="h-12 overflow-hidden w-full"></div>
<footer class="block md:fixed bottom-0 left-0 w-full h-9 bg-gray-900 overflow-hidden">
    <div class="md:grid md:grid-cols-2 w-full md:pl-48 pl-0">
    <div class="text-xs text-gray-700 w-full px-3 bg-gray-300 border-t border-gray-500 h-full">
        <a href="<?php echo get_pretty_url('content', 'company'); ?>">회사소개</a>
        <a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보처리방침</a>
        <a href="<?php echo get_pretty_url('content', 'provision'); ?>">서비스이용약관</a>
    </div>
    <div id="ft_copy" class="px-3 text-xs text-gray-700 w-full text-right bg-gray-300 border-t border-gray-500 h-full">Copyright &copy; <b><?php echo G5_URL?></b> <span class="md:inline-block hidden"> All rights reserved.</div>
    </div>
</footer>
</div>
<?php
include_once(G5_THEME_PATH."/tail.sub.php");
?>