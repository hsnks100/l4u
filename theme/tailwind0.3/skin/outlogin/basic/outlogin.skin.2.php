<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<ul class="flex text-xs items-center">
    <!--<li class="px-1 h-10 w-10 -my-2 hover:bg-gray-600 flex justify-center items-center"><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php"><i class="fas fa-user-edit text-base"></i></a></li>-->
    <li class="px-1 h-10 w-10 -my-2 hover:bg-gray-600 flex justify-center items-center"><a href="<?php echo G5_BBS_URL ?>/logout.php"><i class="fas fa-sign-out-alt text-base"></i></a></li>
    <?php if($is_admin){ ?><li class="px-1 px-1 h-10 w-10 -my-2 hover:bg-gray-600 flex justify-center items-center text-red-500"><a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>"><i class="fa fa-cog text-base"></i></a></li> <?php }?>
</ul>