<template>
  <div class="m-5">
    <t-card>
      <template v-slot:header >
        {{p.g5.title}}
      </template>
      <form name="fboardpassword" ref="fboardpassword" method="post" @submit.prevent="fboardpassword_submit">
        <input type="hidden" name="w" :value="$parent.$route.query.w">
        <input type="hidden" name="bo_table" :value="$parent.$route.query.bo_table">
        <input type="hidden" name="wr_id" :value="$parent.$route.query.wr_id">
        <input type="hidden" name="comment_id" :value="$parent.$route.query.comment_id">
        <input type="hidden" name="sfl" :value="$parent.$route.query.sfl">
        <input type="hidden" name="stx" :value="$parent.$route.query.stx">
        <input type="hidden" name="page" :value="$parent.$route.query.page">
        <label for="pw_wr_password" class="sound_only">비밀번호<strong>필수</strong></label>
        <t-input placeholder="비밀번호" id="pw_wr_password" name="wr_password"/>
      </form>
      <template v-slot:footer>
        <div class="flex justify-between">
          <t-button type="submit" @click="fboardpassword_submit"> 확인 </t-button>
        </div>
      </template>
    </t-card>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        p : {g5 : {title: null}},
      }
    },
    created () {
      let self = this;
      var query = this.$parent.$route.query;
      console.log(this.$parent.$route);
      query.password = true;
      window.req_api(query).then(function(json) {        
        self.p = json;
        if(self.p.g5.title) document.title = self.p.g5.title;
      });
    },
    methods : {
      fboardpassword_submit () {
        let self = this;
        var f = this.$refs.fboardpassword;
        if(f.w.value=='u') { //글 수정
          let self = this;
          var params  = '';
          // eslint-disable-next-line no-undef
          for(key in this.$route.query) {
            // eslint-disable-next-line no-undef
            params += '&' + key + '=' + this.$route.query[key];
          }
          console.log(params);
          window.req_api({
            url : window.url + '?' + params,
            write : true,
            wr_password : f.wr_password.value
          }).then(function(json){
            if(json.msg){
              alert(json.msg);
            }
            console.log(self.$route.query);
            self.$router.push('/write/?'+params);
          });
        }else if(f.w.value=='d') { //글 삭제
          let self = this;
          window.req_api({
            delete : true,
            bo_table : this.$parent.$route.query.bo_table,
            token : self.p.token,
            wr_id : this.$parent.$route.query.wr_id,
            page : this.$parent.$route.query.page,
            wr_password : f.wr_password.value
          }).then(function(json){
            if(json.msg){
              alert(json.msg);
            }
            self.$router.push(json.redirect_url);
          });
        } else if(f.w.value=='x') { //코멘트 삭제
          var data = {
            delete_comment : true,
            bo_table : this.$parent.$route.query.bo_table,
            comment_id : this.$parent.$route.query.comment_id,
            // eslint-disable-next-line no-undef
            wr_id : self.p.row.wr_parent,
            token : self.p.token,
            wr_password : f.wr_password.value
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
              }
            }
          });
        }else {
          var formData = new FormData(f);
          formData.append('password_check', true);
          fetch(window.url, {
            method: "post",
            body: formData,
          }).then(function(response) {
            return response.json();
          }).then(function(json){
            if(json.msg){
              alert(json.msg);
            }else{
              var href = json.redirect_url.replace(/amp;/gi, '');
              self.$router.push(href);
            }
          });
        }
      }
    }
  }
</script>

<style lang="scss" scoped>

</style>