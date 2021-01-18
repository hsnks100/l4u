<template>
  <section id="bo_w" class="w-full mt-3">
    <!-- 게시물 작성/수정 시작 { -->
    <t-alert variant="danger" show v-if="v.msg" :dismissible="false">
      {{v.msg}}
    </t-alert>
    <form v-else name="fwrite" ref="fwrite" class="flex flex-wrap mb-4" id="fwrite" :action="v.action_url" v-on:submit.prevent="fwrite_submit" method="post" enctype="multipart/form-data" autocomplete="off" :style="{width : v.width}" >
      <input type="hidden" name="uid" :value="v.get_uniqid">
      <input type="hidden" name="w" :value="v.w">
      <input type="hidden" name="bo_table" :value="v.bo_table">
      <input type="hidden" name="wr_id" :value="v.wr_id">
      <input type="hidden" name="sca" :value="v.sca">
      <input type="hidden" name="sfl" :value="v.sfl">
      <input type="hidden" name="stx" :value="v.stx">
      <input type="hidden" name="spt" :value="v.spt">
      <input type="hidden" name="sst" :value="v.sst">
      <input type="hidden" name="sod" :value="v.sod">
      <input type="hidden" name="page" :value="v.page">
      <li v-if="v.is_notice" class="inline-flex items-center mt-3 ml-3"><input type="checkbox" id="notice" name="notice"  class="selec_chk form-checkbox h-5 w-5 text-blue-600" :value="'1'+v.notice_checked"><label for="notice" class="ml-2 text-gray-700"><span></span>공지</label></li>
      <input v-if="v.is_dhtml_editor" type="hidden" value="html1" name="html">
      <li v-else class="inline-flex items-center mt-3 ml-3"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" class="selec_chk form-checkbox h-5 w-5 text-blue-600" :value="v.$html_value + v.html_checked"><label class="ml-2 text-gray-700" for="html"><span></span>html</label></li>
      <li v-if="v.is_admin || v.is_secret == 1" class="inline-flex items-center mt-3 ml-3"><input type="checkbox" id="secret" name="secret"  class="selec_chk form-checkbox h-5 w-5 text-blue-600" :value="'secret'+v.secret_checked"><label class="ml-2 text-gray-700" for="secret"><span></span>비밀글</label></li>
      <input v-if="v.is_secret" type="hidden" name="secret" value="secret">
      <li v-if="v.is_mail" class="inline-flex items-center mt-3 ml-3"><input type="checkbox" id="mail" name="mail"  class="selec_chk form-checkbox h-5 w-5 text-blue-600" :value="'mail'+v.recv_email_checked"><label class="ml-2 text-gray-700" for="mail"><span></span>답변메일받기</label></li>

      <div v-if="v.is_category" class="bo_w_select bo_w_info w-full px-3 mb-6 md:mb-0">
          <label for="ca_name" class="sound_only">분류<strong>필수</strong></label>
          <div class="relative">
          <select name="ca_name" v-html="'<option>분류를 선택하세요</option>'+ v.category_option" id="ca_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" required>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
          </div>
          </div>
      </div>
      <div class="bo_w_info w-full md:w-1/2 px-3 mb-6 md:mb-0" v-if="v.is_name">
        <label for="wr_name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">이름</label>
        <input type="text" name="wr_name" :value="v.name" id="wr_name" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" placeholder="이름">
      </div>

      <div class="bo_w_info w-full md:w-1/2 px-3 mb-6 md:mb-0" v-if="v.is_password">
        <label for="wr_password" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">비밀번호</label>
        <input type="password" name="wr_password" id="wr_password" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="비밀번호">
      </div>
	
      <div class="bo_w_info w-full md:w-1/2 px-3 mb-6 md:mb-0" v-if="v.is_email">
        <label for="wr_email" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">이메일</label>
        <input type="text" name="wr_email" :value="v.email" id="wr_email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 email " placeholder="이메일">
      </div>

      <div class="bo_w_info w-full md:w-1/2 px-3 mb-6 md:mb-0" v-if="v.is_homepage">
        <label for="wr_homepage" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">홈페이지</label>
        <input type="text" name="wr_homepage" :value="v.homepage" id="wr_homepage" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" size="50" placeholder="홈페이지">
      </div>
	
      <div class="write_div" v-if="v.option">
        <span class="sound_only">옵션</span>
        <ul class="bo_v_option" v-html="v.option"></ul>
      </div>

      <div class="bo_w_tit w-full px-3 mb-6 md:mb-4">
        <div class="flex justify-between">
          <label for="wr_subject" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">제목</label>
          <div id="autosave_wrapper" class="w-auto whitespace-no-wrap text-xs mr-3 relative" v-if="v.is_member">
            <div v-if="v.editor_content_js" v-append="v.editor_content_js"></div> 
            <button type="button" id="btn_autosave" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-2 rounded">임시 저장된 글 (<span id="autosave_count">{{v.autosave_count}}</span>)</button>
            <div id="autosave_pop" class="absolute z-10 top-0 mt-5 right-0 hidden bg-white border px-3 py-2 leading-8">
              <ul></ul>
              <div><button type="button" class="autosave_close">닫기</button></div>
            </div>
          </div>
        </div>
        <input type="text" name="wr_subject" :value="v.subject" id="wr_subject" required class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" size="50" maxlength="255" placeholder="제목">
      </div>

      <div class="w-full px-3 mb-6 md:mb-4">
        <label for="wr_content" class="sound_only">내용<strong>필수</strong></label>
        <div class="wr_content smarteditor2">
            <!-- 최소/최대 글자 수 사용 시 -->
            <p id="char_count_desc" v-if="v.write_min || v.write_max">이 게시판은 최소 <strong>{{v.write_min}}</strong>글자 이상, 최대 <strong>{{v.write_max}}</strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
            <div v-html="v.editor_html"> </div>
            <!-- 최소/최대 글자 수 사용 시 -->
            <div id="char_count_wrap" v-if="v.write_min || v.write_max"><span id="char_count"></span>글자</div>
        </div>
      </div>
      <div v-for="(n, i) in v.file_count" :key = i class='bo_w_flie write_div w-full px-3 mb-6 md:mb-4 flex relative'>
        <label :for="'bf_file_'+i" class="appearance-none py-3 px-4"><i class="fa fa-folder-open" aria-hidden="true"></i><span class="sound_only"> 파일 #{{i}}</span></label>
        <input type="file" name="bf_file[]" :id="'bf_file_'+i" :title="'파일첨부'+i+': 용량 '+v.upload_max_filesize+' 이하만 업로드 가능'" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        <input v-if="v.is_file_content" type="text" name="bf_content[]" title="파일 설명을 입력해주세요." class="border-l appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" size="50" placeholder="파일 설명을 입력해주세요.">
        <span class="file_del absolute top-0 right-0 mr-5 py-3 text-xs flex items-center h-full" v-if="v.w=='u'">
          <input type="checkbox" :id="'bf_file_del'+i" :name="'bf_file_del['+i+']'" value="1"> <label :for="'bf_file_del'+i">  파일 삭제</label>
        </span>
      </div>
      <div v-if="v.is_use_captcha=='1'">
        <div ref="captcha" class="flex"> </div>
      </div>
      <div class="btn_confirm float-right text-right clearfix w-full px-3 text-sm">
        <router-link v-if="v.cancel_url" :to="v.cancel_url" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mx-2">취소</router-link>
        <button type="submit" id="btn_submit" accesskey="s" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">작성완료</button>
      </div>
    </form>
  </section>
</template>

<script>
import captcha from '../mixin/captcha.js'
export default {
  mixins: [captcha],
  data () {
    return {
      v : {list : []},
    }
  },
  methods : {
    update () {
      let self = this;
      window.req_api({
        write : true,
        bo_table : this.$route.params.bo_table,
        parameter : this.$route.params
      }).then(function(json){
        self.v = json;
        self.$store.state.connect = json.connect;
        document.title = json.title;
        console.log(json);
      });
    },
    fwrite_submit() {
      var f = this.$refs.fwrite;
      let self = this;
      var formData = new FormData(f);
      {{this.v.editor_js}}
      if(this.v.captcha_js){
        // eslint-disable-next-line no-undef
        //if (!chk_captcha()) return false;
      }
      window.req_api({
        write_token : true,
        bo_table : this.$route.params.bo_table,
      }).then(function(data){
        if(data.error) {
          alert(data.error);
          if(data.url)
            document.location.href = data.url;
          return false;
        }
        var token = data.token;
        if(!token) {
            alert("토큰 정보가 올바르지 않습니다.");
            return false;
        }
        formData.append('token', token);
        formData.append('write_update', true);
        let url = "../../api/";
        fetch(url, {
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
            self.$router.push(data.redirect_url);
          }
        });
      });
    }
  },
  created () {
    let self = this;
    var data = this.$route.query;
    var postData = new Object();
    for (const [key, value] of Object.entries(data)) {
      postData[key] = value;
    }
    postData.write = true;
    postData.bo_table = this.$route.params.bo_table;
    postData.parameter = JSON.stringify(this.$route.params);
    console.log(postData);
    window.req_api(postData).then(function(json){
      self.v = json;
      self.cf_captcha = json.config.cf_captcha;
      self.cf_captcha_text = json.captcha;
      self.$store.state.connect = json.connect;
      document.title = json.title;
      self.captcha();
    });
  },
}
</script>

<style scoped>
#wr_content{min-height:300px;}
</style>