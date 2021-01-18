<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$mobile_sns_icon = '';
if (G5_IS_MOBILE) $sns_mc_icon = '';
else $sns_mc_icon = '_cmt';

if (!$board['bo_use_sns']) return;
?>
<?php if ($list[$i]['wr_facebook_user']) { ?>
<a href="https://www.facebook.com/profile.php?id=<?php echo $list[$i]['wr_facebook_user']; ?>" target="_blank"><i aria-label="페이스북에도 등록됨" data-balloon-pos="down" class="fab fa-facebook-square text-3xl text-blue-600"></i></a>
<?php } ?>
<?php if ($list[$i]['wr_twitter_user']) { ?>
<a href="https://www.twitter.com/<?php echo $list[$i]['wr_twitter_user']; ?>" target="_blank"><i aria-label="트위터에도 등록됨" data-balloon-pos="down" class="fab fa-twitter-square text-3xl text-blue-300"></i></a>
<?php } ?>
