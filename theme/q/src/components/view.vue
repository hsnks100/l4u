<template>
  <div class="my-4">
    <t-alert variant="danger" show v-if="v.msg" :dismissible="false">
      {{v.msg}}
    </t-alert>
    <article id="bo_v" class="w-full dark:bg-gray-900 h-full dark:text-gray-400" v-if="v.view">
      <section class="mx-3 border bg-white mb-3 px-3 rounded dark:bg-gray-900 dark:text-gray-400">
        <header class="py-3 border-b">
            <h2 id="bo_v_title">
                <span v-if="v.view.ca_name" class="bo_v_cate bg-gray-800 p-2 rounded text-gray-100">{{v.view.ca_name}}</span> 
                <span class="bo_v_tit">
                  {{view.wr_subject}}
                </span>
            </h2>
        </header>
        <section id="bo_v_info" class="border-b flex ">
          <h2 class="hidden">페이지 정보</h2>
          <div class="profile_info flex items-center w-full py-1 ">
            <div class="profile_info_ct items-center flex w-full">
              <span class="hidden">작성자</span> <span class="whitespace-no-wrap md:mr-0 mr-3" v-html="view.name"> </span> <span class='text-xs' v-if="view.is_ip_view"> {{$view.ip}} </span>
            </div>
            <div class="flex ml-2 w-full justify-end text-xs whitespace-no-wrap flex-wrap">
              <span class="hidden">댓글</span><span class="px-1 text-gray-600"><a href="#bo_vc"> <i class="far fa-comment-dots"></i> {{view.wr_comment}} 건</a></span>
              <span class="hidden">조회</span><span class="px-1 text-gray-600"><i class="far fa-eye"></i> {{view.wr_hit}} 회</span>
              <span class="if_date px-1 text-gray-600"><span class="hidden">작성일</span><i class="far fa-clock"></i> {{view.datetime}} </span>
            </div>
          </div>
        </section>
        <ul class="flex py-3 border-b justify-end whitespace-no-wrap">
          <li class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><router-link :to="v.list_href" title="목록"> <i class="fa fa-list" aria-hidden="true"></i> <span class="hidden md:inline-block">목록</span></router-link></li>
            <li class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><router-link :to="v.reply_href" title="답변"><i class="fas fa-reply"></i><span class="hidden md:inline-block">답변</span></router-link></li>
            <li class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><router-link :to="v.write_href" title="글쓰기"><i class="fas fa-pencil-alt"></i><span class="hidden md:inline-block"> 글쓰기</span></router-link></li>
            <li v-if="v.update_href" class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><router-link :to="v.update_href"><i class="far fa-edit"></i> <span class="hidden md:inline-block">수정</span></router-link></li>
            <li v-if="v.delete_href" class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a :href="v.delete_href" v-on:click.prevent.stop="del(v.delete_href)"><i class="fa fa-trash-alt"></i> <span class="hidden md:inline-block">삭제</span></a></li>
            <li v-if="v.copy_href" class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a :href="v.copy_href" onclick="board_move(this.href); return false;"><i class="far fa-copy"></i> <span class="hidden md:inline-block">복사</span></a></li>
            <li v-if="v.move_href" class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a :href="v.move_href" onclick="board_move(this.href); return false;"><i class="fas fa-arrows-alt"></i> <span class="hidden md:inline-block">이동</span></a></li>
            <li v-if="v.search_href" class="px-2 py-1 bg-gray-200 mx-1 md:mx-2 rounded hover:bg-gray-400"><a :href="v.search_href"><i class="fas fa-search"></i> <span class="hidden md:inline-block">검색</span></a></li>
        </ul>
        <t-modal ref="scrap">
          <template v-slot:header>
            {{view.wr_subject}}
          </template>
          <form ref="f_scrap_popin" name="f_scrap_popin">
            <input type="hidden" id="bo_table" name="bo_table" :value="v.bo_table">
            <input type="hidden" id="wr_id" name="wr_id" :value="view.wr_id">
            <textarea name="wr_content" id="wr_content" class="w-full h-16 border"> </textarea>
            <t-alert variant="danger" show :dismissible="false">
              스크랩을 하시면서 감사 혹은 격려의 댓글을 남기실 수 있습니다.
            </t-alert>
          </form>
          <template v-slot:footer>
            <div class="flex justify-between">
              <t-button type="button" @click="f_scrap_popin_update">
                스크랩 확인
              </t-button>
              <t-button type="button" @click="$refs.scrap.hide()">
                닫기
              </t-button>
            </div>
          </template>
        </t-modal>
        <section id="bo_v_atc" class="pb-3">
          <h2 id="bo_v_atc_title" class="sound_only">본문</h2>
          <div class="text-right">
            <t-button class="text-right m-2" @click="scrap"> 스크랩 </t-button>
          </div>
          <div v-html="view.File_Img"></div>
          <div id="bo_v_con" v-html="view.wr_content"></div>
          <div v-html="view.is_signature"></div>
          <!--  추천 비추천 시작 { -->
          <div id="bo_v_act" class="flex justify-center w-full" v-if="v.good_href || v.nogood_href">
            <div class="border rounded-full h-12 w-12 flex items-center justify-center hover:border-green-300 hover:text-green-300 mr-3" v-if="v.good_href">
                <a :href="v.good_href + '&'+ v.qstr" id="good_button" v-on:click.prevent.stop="excute_good(v.good_href)" class="bo_v_good"><i class="far fa-thumbs-up"></i><span class="sound_only">추천</span><strong>{{view.wr_good}}</strong></a>
                <b id="bo_v_act_good"></b>
            </div>
            <span class="border rounded-full h-12 w-12 flex items-center justify-center hover:border-red-300 hover:text-red-300" v-if="v.nogood_href">
                <a :href="v.nogood_href + '&'+ v.qstr" id="nogood_button" v-on:click.prevent.stop="excute_good(v.nogood_href)" class="bo_v_nogood"><i class="far fa-thumbs-down"></i><span class="sound_only">비추천</span><strong>{{view.wr_nogood}}</strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
          </div>
          <div v-else>
            <div id="bo_v_act" class="flex justify-center w-full" v-if="v.board.bo_use_good || v.board.bo_use_nogood">
              <span v-if="v.board.bo_use_good" class="border rounded-full h-12 w-12 flex items-center justify-center hover:border-green-300 hover:text-green-300 mr-3 cursor-not-allowed bo_v_good"><i class="far fa-thumbs-up"></i><span class="sound_only">추천</span><strong>{{view.wr_good}}</strong></span>
              <span v-if="v.board.bo_use_nogood" class="border rounded-full h-12 w-12 flex items-center justify-center hover:border-red-300 hover:text-red-300 cursor-not-allowed bo_v_nogood"><i class="far fa-thumbs-down"></i><span class="sound_only">비추천</span><strong>{{view.wr_nogood}}</strong></span>
            </div>
          </div>
          <!-- }  추천 비추천 끝 -->
          <!-- 첨부파일 시작 { -->
          <section id="bo_v_file" class="w-full" v-if="view.file.count > 0">
              <ul class="border my-2 px-2 py-2 mx-3 bg-white">
                <li v-for="row in view.file" :key="row.file" >
                  <div v-if="row.file" class="flex justify-between">
                    <p>
                      <i class="fa fa-folder-open" aria-hidden="true"></i>
                      <a :href="row.href" v-on:click.prevent.stop="download(row.href, row.source)" class="view_file_download hover:text-teal-800" download>
                          <strong>{{row.source}}</strong> {{row.bf_content}} ({{row.size}})
                      </a>
                    </p>
                    <p class="flex text-right text-sm text-gray-600">
                        <span class="bo_v_file_cnt">{{row.download}}회 다운로드 | DATE : {{row.datetime}}</span>
                    </p>
                  </div>
                </li>
              </ul>
          </section>
          <!-- } 첨부파일 끝 -->
          <!-- 관련링크 시작 { -->
          <section id="bo_v_link" v-if="view.link.length > 0">
            <h2>관련링크</h2>
            <ul>
              <li v-for="row in view.link" :key="row.file">
                <i class="fa fa-link" aria-hidden="true"></i>
                <a :href="row.link_href" target="_blank" rel="nofollow">
                    <strong>{{row.link}}</strong>
                </a>
                <br>
                <span class="bo_v_link_cnt">{{row.link_hit}}</span>
              </li>
            </ul>
          </section>
          <!-- } 관련링크 끝 -->
        </section>
      </section>
      <div class="mx-3" v-if="v.view.prev_href || v.next_href">
        <ul class="w-full border rounded bg-white dark:bg-gray-900 dark:text-gray-400">
          <li v-if="v.prev_href" class="btn_prv hover:bg-gray-300 py-3 px-4 border-b"><span class="nb_tit mr-3"><i class="fa fa-chevron-up" aria-hidden="true"></i> 이전글</span><router-link :to="v.prev_href" >{{v.prev_wr_subject}}</router-link> <span class="nb_date float-right">{{v.prev_wr_date}}</span></li>
          <li v-if="v.next_href" class="btn_next hover:bg-gray-300 py-3 px-4"><span class="nb_tit mr-3"><i class="fa fa-chevron-down" aria-hidden="true"></i> 다음글</span><router-link :to="v.next_href">{{v.next_wr_subject}}</router-link>  <span class="nb_date float-right">{{v.next_wr_date}}</span></li>
        </ul>
      </div>

     
      <view-comment v-bind:v="v" ref="cmt"> </view-comment>
    </article>
  </div>
</template>

<script>
import viewcomment from "./view.comment";
  export default {
    components : {
      'view-comment' : viewcomment,
    },
    data () {
      return {
        view : null,
        v : {},
      }
    },
    created () {
      let self = this;
      window.req_api({
        view : true,
        bo_table : this.$route.params.bo_table,
        wr_seo_title : this.$route.params.seo,
      }).then(function(json){
        if(json.redirect_url) {
          console.log(json.redirect_url);
          self.$router.push(json.redirect_url);
        }
        self.view = json.view;
        self.v = json;
        self.$store.state.connect = json.connect;
        console.log(self.v);
        if(json.g5_title) document.title = json.g5.title;
      });
    },
    mounted () {
    },
    methods : {
      update () {
        let self = this;
        window.req_api({
          view : true,
          bo_table : this.$route.params.bo_table,
          wr_seo_title : this.$route.params.seo,
        }).then(function(json){
          self.view = json.view;
          self.v = json;
          self.$store.state.connect = json.connect;
          document.title = json.g5.title;
          self.$refs.cmt.update();
        });
      },
      del (href) {
        if(window.confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
          let self = this;
          let params = {};
          href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) { params[key] = value; });
          if(href.indexOf('password.php') != -1) {
            self.$router.push({path : '/bbs/password', query : params});
          }else{
            window.req_api({
              delete : true,
              bo_table : params.bo_table,
              token : params.token,
              wr_id : params.wr_id,
              page : params.page,
            }).then(function(json){
              if(json.msg){
                alert(json.msg);
              }
              self.$router.push(json.redirect_url);
            });
          }
        }
      },
      excute_good(href) {
        let self = this;
        let params = {};
        href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) { params[key] = value; });
        window.req_api({
          vote : true,
          good : params.good,
          bo_table : params.bo_table,
          js : 'on',
          wr_id : params.wr_id,
        }).then(function(data){
          if(data.msg){
            alert(data.msg);
          }else if(data.error){
            alert(data.error);
          }else if(data.count){
            self.update();
          }
        });
      },
      download(href, filename) {
        let self = this;
        let params = {};
        href = href.replace(/amp;/gi, '');
        href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) { params[key] = value; });
        var data = {
          download : true,
          bo_table : params.bo_table,
          no : params.no,
          wr_id : params.wr_id,
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
          return response.blob();
        }).then(function(b){
          var a = document.createElement("a");
          a.href = URL.createObjectURL(b);
          a.setAttribute("download", filename);
          a.click();
          self.update();
        });
      },
      scrap() {
        this.$refs.scrap.show();
      },
      f_scrap_popin_update () {
        let self = this;
        const f = this.$refs.f_scrap_popin;
        let formData = new FormData(f);
        formData.append('f_scrap_popin_update', true);
        fetch(window.url, {
          method: "post",
          body: formData,
        }).then(function(response) {
          return response.json();
        }).then(function(data){
          if(data.msg){
            alert(data.msg);
            self.$refs.scrap.hide();
          }
        });
      }
    },
    beforeRouteUpdate (to, from, next) {
      let self = this;
      window.req_api({
        view : true,
        bo_table : to.params.bo_table,
        wr_seo_title :to.params.seo,
      }).then(function(json){
        self.view = json.view;
        self.v = json;
        self.$store.state.connect = json.connect;
        if(!json) document.title = '잘못 된 접근입니다.';
        else document.title = json.title;
        self.$refs.cmt.update();
        next();
      });
    },
  }
</script>

<style lang="scss" scoped>

</style>