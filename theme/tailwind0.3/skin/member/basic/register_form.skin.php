<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
?>
<!-- 회원정보 입력/수정 시작 { -->
<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
<?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
<script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>

<form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="url" value="<?php echo $urlencode ?>">
<input type="hidden" name="agree" value="<?php echo $agree ?>">
<input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
<input type="hidden" name="cert_no" value="">
<?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
<?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
<input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
<input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
<?php }  ?>

<div role="register" class="mx-3 mt-3">
  <div class="bg-indigo-500 text-gray-100 border-t border-l border-r bordr-b font-bold rounded-t px-4 py-2">
    사이트 이용정보 입력
  </div>
  <div class="px-4 py-3 rounded-b border-b border-r border-l">
	<div class="md:flex md:items-center">
		<div class="md:w-32"> <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reg_mb_id">아이디<strong class="sound_only">필수</strong></label></div>
		<div class="md:w-full">
		<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500" type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> minlength="3" maxlength="20" placeholder="아이디">
		</div>		
	</div>
	<div class="md:ml-32 mt-9 tooltip h6 text-orange-500 text-sm">영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.</div>
	<span id="msg_mb_id"></span>
	<div class="md:flex md:items-center mb-6">
		<div class="md:w-32"> <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reg_mb_password">비밀번호<strong class="sound_only">필수</strong></label></div>
		<div class="md:w-full">
		<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500" type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> minlength="3" maxlength="20" placeholder="비밀번호">
		</div>
	</div>
	<div class="md:flex md:items-center mb-6">
		<div class="md:w-32"> <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reg_mb_password_re">비밀번호<strong class="sound_only">필수</strong></label></div>
		<div class="md:w-full">
		<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500" type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> minlength="3" maxlength="20" placeholder="비밀번호 확인">
		</div>
	</div>
  </div>
</div>
<div role="register" class="mx-3 mt-3">
  <div class="bg-indigo-500 text-gray-100 border-t border-l border-r bordr-b font-bold rounded-t px-4 py-2">
    개인정보 입력
  </div>
  <div class="px-4 py-3 rounded-b border-b border-r border-l">
  	<div class="md:flex md:items-center mb-6">
		<div class="md:w-32"> <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reg_mb_name">이름<strong class="sound_only">필수</strong></label></div>
		<div class="md:w-full">
		<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500" type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> size="10" placeholder="이름">
		</div>
		<?php
	    if($config['cf_cert_use']) {
	        if($config['cf_cert_ipin'])
	            echo '<button type="button" id="win_ipin_cert" class="btn_frmline">아이핀 본인확인</button>'.PHP_EOL;
	        if($config['cf_cert_hp'])
	            echo '<button type="button" id="win_hp_cert" class="btn_frmline">휴대폰 본인확인</button>'.PHP_EOL;
	        echo '<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>'.PHP_EOL;
	    }
	    ?>
	    <?php
	    if ($config['cf_cert_use'] && $member['mb_certify']) {
	        if($member['mb_certify'] == 'ipin')
	            $mb_cert = '아이핀';
	        else
	            $mb_cert = '휴대폰';
	    ?>
	    <div id="msg_certify">
	        <strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
	    </div>
	    <?php } ?>
	    <?php if ($config['cf_cert_use']) { ?>
	    <button type="button" class="tooltip_icon"><i class="far fa-question-circle"></i><span class="sound_only">설명보기</span></button>
	    <span class="tooltip">아이핀 본인확인 후에는 이름이 자동 입력되고 휴대폰 본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.</span>
	    <?php } ?>
	</div>
	<?php if($req_nick){?>
	<div class="md:flex md:items-center mb-6">
		<div class="md:w-32"> <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reg_mb_nick">닉네임 <button type="button" aria-label="공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상) 닉네임을 바꾸시면 앞으로 <?php echo (int)$config['cf_nick_modify'] ?>일 이내에는 변경 할 수 없습니다." data-balloon-pos="down-left" data-balloon-length="xlarge"><i class="far fa-question-circle"></i><span class="sound_only">설명보기</span></button><strong class="sound_only">필수</strong></label></div>
		<div class="md:w-full">
		<input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
        <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500" type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="frm_input required nospace full_input" size="10" maxlength="20" placeholder="닉네임">
		</div>
	</div>
	<span class="tooltip"></span>
	<span id="msg_mb_nick"></span>
 	<?php }?>
	<div class="md:flex md:items-center mb-6">
		<div class="md:w-32"> <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reg_mb_email">
			E-mail
			<?php if ($config['cf_use_email_certify']) {  ?>
			<button type="button" aria-label="<?php echo $w=='' ? "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다." : "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."?>" data-balloon-pos="down-left"><i class="far fa-question-circle"></i><span class="sound_only">설명보기</span></button>	
			<?php }?>
		<strong class="sound_only">필수</strong></label></div>
		<div class="md:w-full">
	    <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
	    <input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500" size="70" maxlength="100" placeholder="E-mail">
		</div>
	</div>
	<?php if ($config['cf_use_homepage']) {  ?>
	<div class="md:flex md:items-center mb-6">
		<div class="md:w-32"> <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reg_mb_homepage">홈페이지<strong class="sound_only">필수</strong></label></div>
		<div class="md:w-full">
			<input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500" type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage']?"required":""; ?> <?php echo $config['cf_req_homepage']?"required":""; ?>" size="70" maxlength="255" placeholder="홈페이지">
		</div>
	</div>
	<?php }  ?>
	<?php if ($config['cf_use_tel']) {  ?>
	<div class="md:flex md:items-center mb-6">
		<div class="md:w-32"> <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reg_mb_tel">전화번호<?php if ($config['cf_req_tel']) { ?><strong class="sound_only">필수</strong><?php } ?></label> </div>
		<div class="md:w-full">
		<input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel']?"required":""; ?> class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 <?php echo $conf['cf_req_tel']?"required":""; ?>" maxlength="20" placeholder="전화번호">
		</div>
	</div>
	<?php }  ?>
	<?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
	<div class="md:flex md:items-center mb-6">
		<div class="md:w-32"> <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reg_mb_hp">휴대폰번호<?php if ($config['cf_req_hp']) { ?><strong class="sound_only">필수</strong><?php } ?></label></div>
		<div class="md:w-full">
		<input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 <?php echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20" placeholder="휴대폰번호">
	    <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
	    <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
	    <?php } ?>
		</div>
	</div>
	<?php }?>
	<?php if ($config['cf_use_addr']) { ?>
	<div class="md:flex md:items-center mb-6 relative">
	    <div class="md:w-32"> <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">주소</label> </div>
		<?php if ($config['cf_req_addr']) { ?><strong class="sound_only">필수</strong><?php }  ?>
		<div class="md:w-full">
	    <label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
	    <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6"  placeholder="우편번호">
		</div>
		<div class="w-32 absolute top-0 md:mt-0 mt-8 right-0"> <button type="button" class="bg-indigo-700 hover:bg-indigo-500 text-white text-sm py-2 w-full" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button> </div>
	</div>
	<div class="md:flex md:items-center mb-6">
		<div class="md:w-32"> <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="reg_mb_addr1" class="sound_only">기본주소<?php echo $config['cf_req_addr']?'<strong> 필수</strong>':''; ?></label> </div>
		<div class="md:w-full">
	    <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 full_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="50"  placeholder="기본주소">
	    </div>
	</div>
	<div class="md:flex md:items-center mb-6">
		<div class="w-32"> <label for="reg_mb_addr2" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">상세주소</label> </div>
		<div class="md:w-full">
		<input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 full_input" size="50" placeholder="상세주소">
	    </div>
	</div>
	<div class="md:flex md:items-center mb-6">
	    <div class="w-32"> <label for="reg_mb_addr3" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">참고항목</label> </div>
	    <div class="md:w-full">
		<input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500 full_input" size="50" readonly="readonly" placeholder="참고항목">
		</div>
	    <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
	</div>
	<?php }  ?>
  </div>
</div>
<div role="register" class="mx-3 mt-3">
  <div class="bg-indigo-500 text-gray-100 border-t border-l border-r bordr-b font-bold rounded-t px-4 py-2">
    기타 개인설정
  </div>
  <div class="px-4 py-3 rounded-b border-b border-r border-l">
  	<?php if ($config['cf_use_signature']) {  ?>
  	<div class="md:flex md:items-center mb-6">
		<div class="w-32"> <label for="reg_mb_signature" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">서명<?php if ($config['cf_req_signature']){ ?><strong class="sound_only">필수</strong><?php } ?></label> </div>
		<div class="md:w-full">
	    <textarea name="mb_signature" id="reg_mb_signature" <?php echo $config['cf_req_signature']?"required":""; ?> class="<?php echo $config['cf_req_signature']?"required":""; ?> bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500"   placeholder="서명"><?php echo $member['mb_signature'] ?></textarea>
	    </div>
	</div>
	<?php }?>
	<?php if ($config['cf_use_profile']) {  ?>
	<div class="md:flex md:items-center mb-6">
	    <div class="w-32"> <label for="reg_mb_profile" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">자기소개</label> </div>
	    <div class="md:w-full">
		<textarea name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile']?"required":""; ?> class="<?php echo $config['cf_req_profile']?"required":""; ?> bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500" placeholder="자기소개"><?php echo $member['mb_profile'] ?></textarea>
		</div>
	</div>
	<?php }  ?>
	<?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) {  ?>
	<div class="md:flex md:items-center mb-6">
	<div>
		<label for="reg_mb_icon" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"> 회원아이콘
			<button type="button" class="tooltip_icon" data-balloon-pos="down-left" data-balloon-length="xlarge" aria-label="이미지 크기는 가로 <?php echo $config['cf_member_icon_width'] ?>픽셀, 세로 <?php echo $config['cf_member_icon_height'] ?>픽셀 이하로 해주세요.
			gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_icon_size']) ?>바이트 이하만 등록됩니다."><i class="far fa-question-circle" ></i><span class="sound_only">설명보기</span></button>
		</label>
	</div>
	<div>
		<input type="file" name="mb_icon" id="reg_mb_icon">
	</div>
	</div>
	<?php }?>
	<?php if ($member['mb_level'] >= $config['cf_icon_level'] && $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height']) {  ?>
	<div class="md:flex md:items-center mb-6">
		<div>
	    <label for="reg_mb_img" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
	    	회원이미지
	    	<button type="button" class="tooltip_icon" data-balloon-pos="down-left" data-balloon-length="xlarge" aria-label="이미지 크기는 가로 <?php echo $config['cf_member_img_width'] ?>픽셀, 세로 <?php echo $config['cf_member_img_height'] ?>픽셀 이하로 해주세요.
	        gif, jpg, png파일만 가능하며 용량 <?php echo number_format($config['cf_member_img_size']) ?>바이트 이하만 등록됩니다."><i class="far fa-question-circle"></i><span class="sound_only">설명보기</span></button>
	    </label>
		</div>
		<div>
			<input type="file" name="mb_img" id="reg_mb_img">
			<?php if ($w == 'u' && file_exists($mb_img_path)) {  ?>
			<img src="<?php echo $mb_img_url ?>" alt="회원이미지">
			<input type="checkbox" class="form-checkbox h-5 w-5" name="del_mb_img" value="1" id="del_mb_img">
			<label for="del_mb_img">삭제</label>
			<?php }  ?>
		</div>
	</div>
	<?php } ?>
	<div class="mb-6">
		<div class="w-full py-1">
		<input type="checkbox" class="form-checkbox h-5 w-5" name="mb_mailling" value="1" id="reg_mb_mailling" <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?> class="selec_chk">
		<label class="text-gray-500 font-bold" for="reg_mb_mailling">
			정보 메일을 받겠습니다.
			<b class="sound_only">메일링서비스</b>
		</label>
		</div>
		<?php if ($config['cf_use_hp']) { ?>
		<div class="w-full py-1">
		<input type="checkbox" class="form-checkbox h-5 w-5" name="mb_sms" value="1" id="reg_mb_sms" <?php echo ($w=='' || $member['mb_sms'])?'checked':''; ?> class="selec_chk">
		<label class="text-gray-500 font-bold" for="reg_mb_sms">
			휴대폰 문자메세지를 받겠습니다.
			<b class="sound_only">SMS 수신여부</b>
		</label>        
		</div>
		<?php } ?>
		<?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정가능 ?>
			<div class="w-full py-1">
		    <input type="checkbox" class="form-checkbox h-5 w-5" name="mb_open" value="1" id="reg_mb_open" <?php echo ($w=='' || $member['mb_open'])?'checked':''; ?> class="selec_chk">
			<label class="text-gray-500 font-bold" for="reg_mb_open">
				다른분들이 나의 정보를 볼 수 있도록 합니다.<button type="button" class="tooltip_icon" aria-label="다른분들이 나의 정보를 볼 수 있도록 합니다. 정보공개를 바꾸시면 앞으로 <?php echo (int)$config['cf_open_modify'] ?>일 이내에는 변경이 안됩니다." data-balloon-pos="down-left" data-balloon-length="xlarge"><i class="far fa-question-circle"></i><span class="sound_only">설명보기</span></button>
				<b class="sound_only">정보공개</b>
			</label>      
		    <input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>"> 
			</div>
		<?php } else { ?>
			<div class="w-full py-1">
	        정보공개
	        <input type="hidden" name="mb_open" value="<?php echo $member['mb_open'] ?>">
	        <button type="button" class="tooltip_icon"><i class="far fa-question-circle"></i><span class="sound_only">설명보기</span></button>
	        <span class="tooltip">
	            정보공개는 수정후 <?php echo (int)$config['cf_open_modify'] ?>일 이내, <?php echo date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G5_SERVER_TIME+$config['cf_open_modify']*86400); ?> 까지는 변경이 안됩니다.<br>
	            이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는 경우를 막기 위해서 입니다.
	        </span>
	        </div>
	    <?php }  ?>
	</div>
	<div class="md:flex md:items-center mb-6">
		<?php
	    //회원정보 수정인 경우 소셜 계정 출력
	    if( $w == 'u' && function_exists('social_member_provider_manage') ){
	        social_member_provider_manage();
	    }
	    ?>
	</div>
	<?php if ($w == "" && $config['cf_use_recommend']) {  ?>
	<div class="md:flex md:items-center mb-6">
	    <div class="w-32"> <label for="reg_mb_recommend" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">추천인아이디</label> </div>
		<div class="md:w-full">
	    <input type="text" name="mb_recommend" id="reg_mb_recommend" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-indigo-500" placeholder="추천인아이디">
		</div>
	</div>
	<?php }  ?>
	<div class="is_captcha_use md:flex md:items-center mb-6">
		<div class="w-32"> <label for="reg_mb_recommend" class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">자동등록방지</label> </div>
		<div class="md:w-full">
	    <?php echo tailwind_captcha_html(); ?>
		</div>
	</div>
  	</div>
</div>
<div class="register mx-3 mt-3 flex justify-end mb-4">
<div class="btn_confirm flex whitespace-no-wrap self-center items-center">
    <a href="<?php echo G5_URL?>" class="block bg-red-700 hover:bg-red-500 text-white rounded py-2 px-3 mr-3">취소</a>
    <button type="submit" id="btn_submit" class="btn_submit block bg-green-700 hover:bg-green-500 text-white rounded py-2 px-3" accesskey="s"><?php echo $w==''?'회원가입':'정보수정'; ?></button>
</div>
</div>
</form>
<script>
$(function() {
    $("#reg_zip_find").css("display", "inline-block");

    <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
    // 아이핀인증
    $("#win_ipin_cert").click(function() {
        if(!cert_confirm())
            return false;

        var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
        certify_win_open('kcb-ipin', url);
        return;
    });

    <?php } ?>
    <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
    // 휴대폰인증
    $("#win_hp_cert").click(function() {
        if(!cert_confirm())
            return false;

        <?php
        switch($config['cf_cert_hp']) {
            case 'kcb':
                $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                $cert_type = 'kcb-hp';
                break;
            case 'kcp':
                $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                $cert_type = 'kcp-hp';
                break;
            case 'lg':
                $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                $cert_type = 'lg-hp';
                break;
            default:
                echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                echo 'return false;';
                break;
        }
        ?>

        certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
        return;
    });
    <?php } ?>
});

// submit 최종 폼체크
function fregisterform_submit(f)
{
    // 회원아이디 검사
    if (f.w.value == "") {
        var msg = reg_mb_id_check();
        if (msg) {
            alert(msg);
            f.mb_id.select();
            return false;
        }
    }

    if (f.w.value == "") {
        if (f.mb_password.value.length < 3) {
            alert("비밀번호를 3글자 이상 입력하십시오.");
            f.mb_password.focus();
            return false;
        }
    }

    if (f.mb_password.value != f.mb_password_re.value) {
        alert("비밀번호가 같지 않습니다.");
        f.mb_password_re.focus();
        return false;
    }

    if (f.mb_password.value.length > 0) {
        if (f.mb_password_re.value.length < 3) {
            alert("비밀번호를 3글자 이상 입력하십시오.");
            f.mb_password_re.focus();
            return false;
        }
    }

    // 이름 검사
    if (f.w.value=="") {
        if (f.mb_name.value.length < 1) {
            alert("이름을 입력하십시오.");
            f.mb_name.focus();
            return false;
        }

        /*
        var pattern = /([^가-힣\x20])/i;
        if (pattern.test(f.mb_name.value)) {
            alert("이름은 한글로 입력하십시오.");
            f.mb_name.select();
            return false;
        }
        */
    }

    <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
    // 본인확인 체크
    if(f.cert_no.value=="") {
        alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
        return false;
    }
    <?php } ?>

    // 닉네임 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
        var msg = reg_mb_nick_check();
        if (msg) {
            alert(msg);
            f.reg_mb_nick.select();
            return false;
        }
    }

    // E-mail 검사
    if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
        var msg = reg_mb_email_check();
        if (msg) {
            alert(msg);
            f.reg_mb_email.select();
            return false;
        }
    }

    <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
    // 휴대폰번호 체크
    var msg = reg_mb_hp_check();
    if (msg) {
        alert(msg);
        f.reg_mb_hp.select();
        return false;
    }
    <?php } ?>

    if (typeof f.mb_icon != "undefined") {
        if (f.mb_icon.value) {
            if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원아이콘이 이미지 파일이 아닙니다.");
                f.mb_icon.focus();
                return false;
            }
        }
    }

    if (typeof f.mb_img != "undefined") {
        if (f.mb_img.value) {
            if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원이미지가 이미지 파일이 아닙니다.");
                f.mb_img.focus();
                return false;
            }
        }
    }

    if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
        if (f.mb_id.value == f.mb_recommend.value) {
            alert("본인을 추천할 수 없습니다.");
            f.mb_recommend.focus();
            return false;
        }

        var msg = reg_mb_recommend_check();
        if (msg) {
            alert(msg);
            f.mb_recommend.select();
            return false;
        }
    }

    <?php echo chk_captcha_js();  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

jQuery(function($){
	//tooltip
    $(document).on("click", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeIn(400).css("display","inline-block");
    }).on("mouseout", ".tooltip_icon", function(e){
        $(this).next(".tooltip").fadeOut();
    });
});

</script>

<!-- } 회원정보 입력/수정 끝 -->