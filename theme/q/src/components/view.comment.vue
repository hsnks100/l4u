<template>
  <div>
    <div class="felx mx-3">
      <button type="button" class="cmt_btn hover:bg-gray-200 font-bold py-2 px-4 rounded my-3 w-full border rounded shadow bg-white" ref="cmt_toggle" @click="cmtToggle"><span class="total"><b>댓글</b> {{v.view.comment}}</span> <i class="fa fa-chevron-down"> </i></button>
    </div>
    <!-- 댓글 시작 { -->
    <p v-if="c.list.length == 0" id="bo_vc_empty" class="mx-3 border py-6 rounded bg-white px-3 text-center">등록된 댓글이 없습니다.</p>
    <section id="bo_vc" v-if="c.list.length > 0 && c.list" class="mx-3" ref="bo_vc">
      <article :id="'c_'+row.wr_id" class="flex bg-white border rounded-lg mx-4 mt-2" v-for="(row, i) in c.list" :key="row.wr_id" :style="'margin-left:'+row.wr_comment_reply.length * 15">
        <div class="flex items-start pb-4 w-full">
          <div class="w-full">
            <div class="flex items-center justify-between flex-wrap border-b pb-2 comment-header pt-4 px-4 rounded-t-lg cmt" :data-idx="i" @mouseover="cmtover(i)" @mouseout="cmtout(i)">
              <h2 class="md:text-base text-sm font-semibold text-gray-900 -mt-1 whitespace-no-wrap cmt-title">
                <div class="flex" >
                  <div v-html="row.name"> </div>
                  <span class="font-normal text-sm" v-if="v.is_ip_view == 1">
                    <span class="sound_only">아이피</span>
                    <span class="md:text-base text-xs truncate">({{row.ip}})</span>
                  </span>
                </div>
              </h2>
              <ul class="flex items-center justify-end c-edit">
                <div class="flex reply_edit cmt-hover hidden" ref="cmt_edit">
                  <div class="flex text-gray-700 text-sm mr-1 md:mr-2 px-2 hover:bg-gray-300 rounded cursor-pointer" v-if="row.is_reply">                                          
                    <a :href="row.c_reply_href" v-on:click.prevent.stop="comment_box(row.wr_id, 'c'); return false;">
                      <i class="fa fa-reply w-4 h-4 p-1 mr-1"> </i> <span class="hidden md:inline-block"> 답변 </span>
                    </a>
                  </div>                  
                  <div class="flex text-gray-700 text-sm mr-1 md:mr-2 px-2 hover:bg-gray-300 rounded cursor-pointer" v-if="row.is_edit">
                    <a :href="row.c_edit_href" v-on:click.prevent.stop="comment_box(row.wr_id, 'cu'); return false;">
                      <i class="fa fa-edit w-4 h-4 mr-1 p-1"> </i> <span class="hidden md:inline-block"> 수정 </span>
                    </a>
                  </div>
                  <div class="flex text-gray-700 text-sm mr-1 md:mr-2 px-2 hover:bg-gray-300 rounded cursor-pointer" v-if="row.is_del">
                    <a :href="row.del_link" v-on:click.prevent.stop="comment_delete(row.del_link)">
                        <i class="fa fa-trash-alt w-4 h-4 mr-1 p-1"> </i> <span class="hidden md:inline-block"> 삭제 </span>
                    </a>
                  </div>
                </div>
                <small class="text-sm whitespace-no-wrap truncate text-gray-700 datetime" ref="cmt_title" :data-leave="'leave'+i"><i class="fa fa-clock-o" aria-hidden="true"></i> <time datetime="">{{row.datetime}}</time></small>
              </ul>
            </div>
	
           <!-- 댓글 출력 -->
          <div class="text-gray-700 p-1 px-4">
              <i v-if="row.wr_option=='secret'" class="fas fa-lock mr-2"> </i>
              <span v-html="row.content"></span>
            </div>

            <span :id="'edit_' + row.wr_id" class="bo_vc_w"></span><!-- 수정 -->
            <span :id="'reply_' + row.wr_id" class="bo_vc_w"></span><!-- 답변 -->
            <input type="hidden" :value="row.wr_option" :id="'secret_comment_'+row.wr_id">
            <textarea :id="'save_comment_'+row.wr_id" style="display:none;" v-text="row.content1"></textarea>
          </div>
        </div>
      </article>
    </section>
    <!-- } 댓글 끝 -->
    <aside id="bo_vc_w" class="flex items-center justify-center mx-3 mb-4">
      <form name="fviewcomment" ref="fviewcomment" id="fviewcomment" :action="c.comment_action_url" v-on:submit.prevent="fviewcomment_submit" method="post" autocomplete="off" class="w-full my-1">
        <input type="hidden" name="w" value="c" id="w">
        <input type="hidden" name="bo_table" :value="c.bo_table">
        <input type="hidden" name="wr_id" :value="v.wr_id">
        <input type="hidden" name="comment_id" id="comment_id">
        <input type="hidden" name="sca" :value="$route.params.sca">
        <input type="hidden" name="sfl" :value="$route.params.sfl">
        <input type="hidden" name="stx" :value="$route.params.stx">
        <input type="hidden" name="spt" :value="$route.params.spt">
        <input type="hidden" name="page" :value="$route.params.page">
        <input type="hidden" name="is_good" value="">
        <h2 class="px-4 pb-2 text-gray-800 text-sm sound_only">댓글쓰기</h2>
        <span class="sound_only">내용</span>
        <strong id="char_cnt" v-if="c.comment_min || c.comment_max"><span id="char_count"></span>글자</strong>
        <textarea id="wr_content" name="wr_content" ref="wr_content" maxlength="10000" required class="bg-white rounded border-2 leading-tight appearance-none border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 mt-3 font-medium placeholder-gray-700 focus:outline-none focus:border-gray-500" title="내용" placeholder="댓글내용을 입력해주세요"></textarea>
        <div class="flex flex-wrap mb-6">
            <div class="bo_vc_w_info flex">
              <div v-if="c.is_guest">
                <label for="wr_name" class="sound_only">이름<strong> 필수</strong></label>
                <input type="text" name="wr_name" :value="c.ck_sns_name" id="wr_name" required class="mr-3 sm:w-auto w-1/2 bg-gray-100 rounded border border-gray-400 leading-normal resize-none py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white" size="25" placeholder="이름">
                <label for="wr_password" class="sound_only">비밀번호<strong> 필수</strong></label>
                <input type="password" name="wr_password" id="wr_password" required class="sm:w-auto w-1/2 bg-gray-100 rounded border border-gray-400 leading-normal resize-none py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white" size="25" placeholder="비밀번호">
              </div>
              <span v-if="v.board.bo_use_sns && v.config.cf_fackbook_appid && v.config.cf_twitter_key" class="sound_only">SNS 동시등록</span>
              <span v-if="v.board.bo_use_sns && v.config.cf_fackbook_appid && v.config.cf_twitter_key" id="bo_vc_send_sns"></span>
            </div>
            <div class="text-right w-full">
              <div v-if="c.is_guest=='1'">
                <div ref="captcha" class="flex"> </div>
              </div>
              <div class="inline-flex items-center mt-3 ml-3">
                  <input type="checkbox" name="wr_secret" value="secret" id="wr_secret" class="selec_chk form-checkbox h-5 w-5 text-blue-600">
                  <label for="wr_secret" class="ml-2 text-gray-700 select-none text-sm">비밀글</label>
                </div>
                <button type="submit" id="btn_submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">댓글등록</button>
            </div>
        </div>
        </form>
    </aside>
  </div>
</template>

<script>
import captcha from '../mixin/captcha.js'
export default {
  mixins: [captcha],
  name: "viewcomment",
  props : ['v'],
  data () {
    return {
      c : {
        list : {
          content1 : null,
        }
      },
    }
  },
  methods : {
    cmtToggle(){
      if(this.$refs.bo_vc){
        if(this.$refs.bo_vc.classList.contains('hidden'))
          this.$refs.bo_vc.classList.remove('hidden');
        else
          this.$refs.bo_vc.classList.add('hidden');
      }
    },
    update(){
      let self = this;
      window.req_api({
        view_comment : true,
        bo_table : this.$route.params.bo_table,
        wr_seo_title : this.$route.params.seo,
      }).then(function(json){
        self.c = json;
      });
    },
    cmtover(e){
      this.$refs.cmt_edit[e].classList.remove('hidden');
      this.$refs.cmt_title[e].classList.add('hidden');
      return false;
    },
    cmtout(e){
      this.$refs.cmt_edit[e].classList.add('hidden');
      this.$refs.cmt_title[e].classList.remove('hidden');
    },
    fviewcomment_submit() {
      var f = this.$refs.fviewcomment;
      let self = this;
      var formData = new FormData(f);
      window.req_api({
        write_comment_token : true,
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
        formData.append('write_comment_update', true);
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
            self.$refs.wr_content.value = '';
            self.update();
            self.comment_from_restore();
            //self.$router.push(data.redirect_url);
          }
        });
      });
    },
    comment_box(comment_id, work){
      var save_before = '';
      var el_id,
      form_el = 'fviewcomment',
      respond = document.getElementById(form_el);
      // 댓글 아이디가 넘어오면 답변, 수정
      if (comment_id)
      {
        if (work == 'c')
          el_id = 'reply_' + comment_id;
        else
          el_id = 'edit_' + comment_id;
      }
      else
        el_id = 'bo_vc_w';
      if (save_before != el_id)
      {
        if (save_before)
        {
          document.getElementById(save_before).style.display = 'none';
        }
        document.getElementById(el_id).style.display = '';
        document.getElementById(el_id).appendChild(respond);
        //입력값 초기화
        document.getElementById('wr_content').value = '';
          
        // 댓글 수정
        if (work == 'cu')
        {
          document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
          if (document.getElementById('secret_comment_'+comment_id).value)
            document.getElementById('wr_secret').checked = true;
          else
            document.getElementById('wr_secret').checked = false;
        }
        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;
        if(save_before)
          document.querySelector("#captcha_reload").trigger("click");
        save_before = el_id;
      }
    },
    comment_from_restore() {
      var form_el = 'fviewcomment',
      respond = document.getElementById(form_el);
      document.getElementById('bo_vc_w').appendChild(respond);
      document.getElementById('w').value = 'c';
      document.getElementById('comment_id').value = '';
    },
    comment_delete(href){
      let self = this;
      let params = {};
      href = href.replace(/amp;/gi, '');
      href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) { params[key] = value; });
      if(href.indexOf('password.php') != -1) {
        self.$router.push({path : '/bbs/password', query : params});
      }else{
        var data = {
          delete_comment : true,
          bo_table : params.bo_table,
          comment_id : params.comment_id,
          // eslint-disable-next-line no-undef
          wr_id : self.$props.v.wr_id,
          token : params.token,
        };
        let formData = new FormData();
        // eslint-disable-next-line no-undef
        for(key in data) {
          // eslint-disable-next-line no-undef
          if(key == 'url') url += data[key];
          // eslint-disable-next-line no-undef
          else formData.append(key, data[key]);
        }
        fetch(window.url, {
          method: "post",
          body: formData,
        }).then(function(response) {
          return response.json();
        }).then(function(json){
          if(json.msg){
            alert(json.msg)
          }else{
            if(json.redirect_url){
              self.$router.push(json.redirect_url);
            }else{
              self.update();
            }
            self.comment_from_restore();
          }
        });
      }
    }
  },
  created () {
    let self = this;
    window.req_api({
      view_comment : true,
      bo_table : this.$route.params.bo_table,
      wr_seo_title : this.$route.params.seo,
    }).then(function(json){
      self.c = json;
      console.log(json);
      self.cf_captcha = json.config.cf_captcha;
      self.cf_captcha_text = json.captcha;
      self.captcha();
    });
    const on = (selector, event, handler, element=document) => {
      element.addEventListener(event, (e) => { if(e.target.matches(selector)) handler(e); });
    };
    // click will work for each selector
    on('.s_cmt','click',  e => {
      e.preventDefault();
      e.stopPropagation();
      let params = {};
      var ele = e.target;
      ele.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) { params[key] = value; });
      self.$router.push({path : '/bbs/password', query : params});
    });
  },
  mounted () {
  
  },
}
</script>

<style scoped>
.show{display: flex !important;}
.hide{display: none !important;}
</style>