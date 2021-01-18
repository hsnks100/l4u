<template>
  <div class="m-3" v-if="$store.state.isLogin == false && agree == false && c">
    <t-alert variant="danger" show :dismissible="false">
      <i class="fa fa-check-circle" aria-hidden="true"></i> 회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.
    </t-alert>
    <t-card class="border my-2">
      SNS 계정으로 가입(지원예정)
    </t-card>
    <t-card class="border my-2">
      <template v-slot:header>
        <div class="flex"> 
          <label class="ml-2 flex items-center flex justify-between w-full">
            <div> 회원가입 약관 </div>
            <t-checkbox name="agree" ref="agree" value="1" />
          </label>
        </div>
      </template>
      <textarea class="w-full h-20 p-3 text-sm" v-text="c.config.cf_stipulation"> </textarea>
    </t-card>
    <t-card class="border my-2">
      <template v-slot:header>
        <div class="flex"> 
          <label class="ml-2 flex items-center flex justify-between w-full">
            <div> 개인정보처리방침 안내 </div>
            <t-checkbox name="agree2" ref="agree2" value="1" />
          </label>
        </div>
      </template>
      <t-table class="my-1"
        :headers="['목적', '항목', '보유기간']"
        :data="[
          ['이용자 식별 및 본인여부 확인', '아이디, 이름, 비밀번호', '회원 탈퇴 시까지'],
          ['고객서비스 이용에 관한 통지,\r\n CS대응을 위한 이용자 식별', '연락처(이메일, 휴대전화번호)', '회원 탈퇴 시까지']
        ]"
      >
      </t-table>
      <textarea class="w-full h-20 p-3 text-sm" v-text="c.config.cf_privacy"> </textarea>
    </t-card>
    <div class="border my-2 rounded mx-auto shadow bg-white p-4">
      <label class="flex items-center flex justify-center w-full" @click="chkall">
        <div class="text-center flex justify-around mr-3"> 회원약관에 모두 동의 합니다</div>
        <t-checkbox name="chk_all" ref="chk_all" value="1" />
      </label>
    </div>
    <div class="w-full">
      <t-button class="w-1/2 text-center"> 취소 </t-button>
      <t-button class="w-1/2 text-center" variant="primary" @click="register"> 회원가입 </t-button>
    </div>
  </div>
  <div v-else-if="agree==true && r">
    <form id="fregisterform" ref="fregisterform" name="fregisterform"  @submit.prevent="fregisterform_submit" class="m-3" method="post" enctype="multipart/form-data" autocomplete="off">
      <input type="hidden" name="w" :value="r.w">
      <input type="hidden" name="url" :value="r.urlencod">
      <input type="hidden" name="agree" :value="r.agree">
      <input type="hidden" name="agree2" :value="r.agree2">
      <input type="hidden" name="cert_type" :value="r.member.mb_certify">
      <input type="hidden" name="cert_no">
      <input type="hidden" v-if="r.member.mb_sex" name="mb_sex" :value="r.member_sex">
      <div v-if="r.member.mb_nick_date && r.member.mb_nick_date">
        <input type="hidden" name="mb_nick_default" :value="r.member.mb_nick">
        <input type="hidden" name="mb_nick" :value="r.member.mb_nick">
      </div>
      <t-card header="사이트 이용정보 입력" class="my-4">
        <t-input-group label="아이디" feedback="영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.">
          <t-input name="mb_id" id="reg_mb_id" :value="r.member.mb_id" type="text"/>
        </t-input-group>
        <div class="flex">
        <t-input-group label="비밀번호" class="w-1/2 pr-2">
          <t-input name="mb_password" required placeholder="비밀번호" type="password"/>
        </t-input-group>
        <t-input-group label="비밀번호 확인" class="w-1/2 pl-2">
          <t-input name="mb_password_re" placeholder="비밀번호 확인" type="password"/>
        </t-input-group>
        </div>
      </t-card>
      <t-card header="개인정보 입력" class="my-4">
        <t-input-group label="이름"> <t-input name="mb_name" size="10" :value="c.member.mb_name" :readonly="c.readonly" type="text"/> </t-input-group>
        <t-input-group v-if="r.req_nick" label="닉네임"> <t-input :value="c.member.mb_nick" id="reg_mb_nick" name="mb_nick" @change="reg_mb_nick_check" type="text"/> </t-input-group>
        <t-input-group v-if="r.config.cf_use_email_certify" label="E-mail"> 
          <input type="hidden" name="old_email" :value="c.member.mb_email">
          <t-input :value="c.member.mb_email" name="mb_email" id="reg_mb_email" @change="reg_mb_email_check" size="70" maxlength="100" type="text"/> 
        </t-input-group>
        <t-input-group v-if="r.config.cf_use_homepage" label="홈페이지">
          <t-input type="text" name="mb_homepage" :value="c.member.mb_homepage" size="70" maxlength="255" /> 
        </t-input-group>
        <t-input-group v-if="r.config.cf_use_tel" label="전화번호"> <t-input :value="c.member.mb_tel" name="mb_tel" type="text"/> </t-input-group>
        <t-input-group v-if="r.config.cf_use_hp" label="휴대폰번호"> <t-input :value="c.member.mb_hp" type="text"/> </t-input-group>
        <div v-if="r.config.cf_use_addr">
          <div v-append="r.POSTCODE"> </div>
          <t-input-group label="주소"> <t-input :value="c.member.mb_id" type="text"/> </t-input-group>
          <t-input-group> <t-input :value="c.member.mb_addr1" size="50" name="mb_addr1" placeholder="기본주소" type="text"/> </t-input-group>
          <t-input-group> <t-input :value="c.member.mb_addr2" size="50" name="mb_addr2" placeholder="상세주소" type="text"/> </t-input-group>
          <t-input-group> <t-input :value="c.member.mb_addr3" size="50" name="mb_addr3" placeholder="참고항목" type="text"/> </t-input-group>
          <input type="hidden" name="mb_addr_jibeon" :value="c.member.mb_addr_jibeon">
        </div>
      </t-card>
      <t-card header="기타 개인설정" class="my-4">
        <t-input-group v-if="r.config.cf_use_signature" label="서명"> <t-textarea name="mb_signature" placeholder="서명" type="text" class="w-full bg-gray-100 border h-20 rounded p-3"> {{c.member.mb_signature}} </t-textarea> </t-input-group>
        <t-input-group v-if="r.config.cf_use_profile" label="자기소개"> <t-textarea name="mb_profile" placeholder="자기소개" type="text" class="w-full bg-gray-100 border h-20 rounded p-3"> {{c.member.mb_profile}} </t-textarea> </t-input-group>
        <t-input-group v-if="r.config.cf_use_member_icon" label="회원아이콘" :feedback="r.config.cf_member_icon_height + '. gif, jpg, png파일만 가능하며 용량 '+ r.config.cf_member_icon_size + '바이트 이하'">
          <t-input name="mb_icon" type="file"/>
        </t-input-group>
        <t-input-group v-if="r.member.mb_level >= r.config.cf_icon_level && r.config.cf_member_img_size && r.config.cf_member_img_width && r.config.cf_member_img_height" label="회원이미지" feedback="60x60. gif, jpg, png파일만 가능하며 용량 5,0000바이트 이하">
          <t-input name="mb_img" type="file"/>
        </t-input-group>
        <label class="flex items-center my-1">
          <t-checkbox name="mb_mailling" value="a" />
          <span class="ml-2 text-sm">정보 메일을 받겠습니다.</span>
        </label>
        <label class="flex items-center my-1" v-if="r.config.cf_use_hp">
          <t-checkbox name="mb_sms" value="a" />
          <span class="ml-2 text-sm">휴대폰 문자메세지를 받겠습니다.</span>
        </label>
        <label class="flex items-center my-1">
          <t-checkbox name="mb_open" value="a" />
          <span class="ml-2 text-sm">다른분들이 나의 정보를 볼 수 있도록 합니다.</span>
        </label>
        <t-input-group v-if="r.w == '' && r.config.cf_use_recommend" class="w-48"> <t-input :value="c.member.mb_id" id="reg_mb_recommend" name="mb_recommend" @change="reg_mb_recommend_check" placeholder="추천인 아이디" type="text"/> </t-input-group>
        <t-input-group v-if="r.config.cf_use_member_icon" label="캡차">
          <div ref="captcha" class="flex"> </div>
        </t-input-group>
      </t-card>
      <div v-append="r.captcha_html"> </div>
      <div class="w-full">
        <t-button class="w-1/2 text-center" type="button"> 취소 </t-button>
        <t-button class="w-1/2 text-center" type="submit" variant="primary"> 회원가입 </t-button>
      </div>
    </form>
  </div>
</template>

<script>
import captcha from '../../mixin/captcha.js'
export default {
  mixins: [captcha],
  name : 'register',
  data () {
    return {
      agree : false,
      c : null,
      r : null,
      valid : false,
    }
  },
  created () {
    let self = this;
    window.req_api({
      register : true,
    }).then(function(json){
      self.c = json;
      document.title = json.g5.title;
      console.log('c', json);
    });
  },
  methods : {
    chkall() {
      if(this.$refs.chk_all.$el.checked) {
        this.$refs.agree.$el.checked = true;
        this.$refs.agree2.$el.checked = true;
      }else{
        this.$refs.agree.$el.checked = false;
        this.$refs.agree2.$el.checked = false;
      }
    },
    register() {
      var agree = this.$refs.agree.$el.checked;
      var agree2 = this.$refs.agree2.$el.checked;
      let self = this;
      if(agree && agree2) {
        this.agree = true;
        window.req_api({
          register_form : true,
          agree : "1",
          agree2 : "1",
        }).then(function(json){
          self.r = json;
          document.title = json.g5.title;
          self.cf_captcha = json.config.cf_captcha;
          self.cf_captcha_text = json.captcha;
          self.captcha();
          console.log(json);
        });
      } else{
        alert('회원가입 약관에 동의해주십시오');
      }
    },
    async reg_mb_id_check () { //회원 ID 검사
      let self = this;
      var f = this.$refs.fregisterform;
      if (f.w.value == "none") {
        return window.req_api({
          register_form_valid : true,
          reg_mb_id_check : true,
          "reg_mb_id": encodeURIComponent(document.querySelector("#reg_mb_id").value)
        }).then(function(json){
          if(json.msg){
            alert(json.msg);
            f.mb_id.select();
            self.valid = false;
          }else{
            self.valid = true;
          }
        });
      }
    },
    async reg_mb_nick_check () {
      let self = this;
      var f = this.$refs.fregisterform;
      if ((f.w.value == "none") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
        window.req_api({
          register_form_valid : true,
          reg_mb_nick_check : true,
          "reg_mb_nick": (document.querySelector("#reg_mb_nick").value),
          "reg_mb_id": encodeURIComponent(document.querySelector("#reg_mb_id").value)
        }).then(function(json){
          if(json.msg){
            alert(json.msg);
            f.reg_mb_nick.select();
            self.valid = false;
          }else{
            self.valid = true;
          }
        })
      }
    },
    async reg_mb_email_check () {
      let self = this;
      var f = this.$refs.fregisterform;
      if ((f.w.value == "none") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
        window.req_api({
          register_form_valid : true,
          reg_mb_email_check : true,
          "reg_mb_email": (document.querySelector("#reg_mb_email").value),
          "reg_mb_id": encodeURIComponent(document.querySelector("#reg_mb_id").value)
        }).then(function(json){
          if(json.msg){
            alert(json.msg);
            f.reg_mb_email.select();
            self.valid = false;
          }else{
            self.valid = true;
          }
        })
      }
    },
    async reg_mb_hp_check () {
      let self = this;
      var f = this.$refs.fregisterform;
      window.req_api({
        register_form_valid : true,
        reg_mb_hp_check : true,
        "reg_mb_hp": (document.querySelector("#reg_mb_hp").value),
        "reg_mb_id": encodeURIComponent(document.querySelector("#reg_mb_id").value)
      }).then(function(json){
        if(json.msg){
          alert(json.msg);
          f.reg_mb_hp.select();
          self.valid = false;
        }else{
          self.valid = true;
        }
      })
    },
    async reg_mb_recommend_check () {
      let self = this;
      var f = this.$refs.fregisterform;
      if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
        if (f.mb_id.value == f.mb_recommend.value) {
          alert("본인을 추천할 수 없습니다.");
          f.mb_recommend.focus();
          self.valid = false;
        }
        window.req_api({
          register_form_valid : true,
          reg_mb_recommend_check : true,
          "reg_mb_recommend": encodeURIComponent(document.querySelector("#reg_mb_recommend").value)
        }).then(function(json){
          if(json.msg){
            alert(json.msg);
            f.mb_recommend.select();
            self.valid = false;
          }
        })
      }
    },
    async fregisterform_submit () {
      let self = this;
      var f = this.$refs.fregisterform;
      var formData = new FormData(f);
      await this.reg_mb_id_check();
      await this.reg_mb_nick_check();
      await this.reg_mb_email_check();
      //await this.reg_mb_recommend_check();
      if (f.w.value == "") {
        if (f.mb_password.value.length < 3) {
          alert("비밀번호를 3글자 이상 입력하십시오.");
          f.mb_password.focus();
          self.valid = false;
        }
      }
      if (f.mb_password.value != f.mb_password_re.value) {
        alert("비밀번호가 같지 않습니다.");
        f.mb_password_re.focus();
        self.valid = false;
      }
      if (f.mb_password.value.length > 0) {
        if (f.mb_password_re.value.length < 3) {
          alert("비밀번호를 3글자 이상 입력하십시오.");
          f.mb_password_re.focus();
          self.valid = false;
        }
      }
      // 이름 검사
      if (f.w.value=="") {
        if (f.mb_name.value.length < 1) {
          alert("이름을 입력하십시오.");
          f.mb_name.focus();
          self.valid = false;
        }
      }        
      if (typeof f.mb_icon != "undefined") {
        if (f.mb_icon.value) {
            if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원아이콘이 이미지 파일이 아닙니다.");
                f.mb_icon.focus();
                self.valid = false;
            }
        }
      }
      if (typeof f.mb_img != "undefined") {
        if (f.mb_img.value) {
          if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
            alert("회원이미지가 이미지 파일이 아닙니다.");
            f.mb_img.focus();
            self.valid = false;
          }
        }
      }
      
      formData.append('register_form_update', true);
      await fetch(window.url, {
        method: "post",
        body: formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(data){
        if(data.msg) {
          alert(data.msg);
        }else{
          console.log(self);
          //self.$route.push('/');
        }
      });
    },
  }
}
</script>

<style lang="scss" scoped>

</style>