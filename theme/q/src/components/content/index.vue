<template>
  <div class="dark:bg-gray-700 h-full">
    <t-alert variant="danger" show v-if="c.msg" :dismissible="false">
      {{c.msg}}
    </t-alert>
    <div v-if="c.member.mb_level >= 10" class="p-3 flex justify-end">
      <t-button variant="error" > 관리</t-button>
    </div>
    <div class="p-3 bg-white mx-3 my-5 shadow dark:bg-gray-800 dark:text-gray-300" v-html="c.str"> </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        c : {
          msg : null,
          member : {mb_level : 0}
        },
      }
    },
    created () {
      let co_id;
      if(this.$route.params.co_seo_title == '회사소개') {
        co_id ='company';
      }else if(this.$route.params.co_seo_title == '서비스-이용약관') {
        co_id ='provision';
      }else if(this.$route.params.co_seo_title == '개인정보-처리방침') {
        co_id ='privacy';
      }
      let self = this;
       window.req_api({
        content : true,
        co_seo_title : this.$route.params.co_seo_title,
        co_id : co_id,
      }).then(function(json){
        self.c = json;
        if(!json) document.title = '잘못 된 접근입니다.';
        else document.title = json.co_seo_title;
      });
    },
    beforeRouteUpdate (to, from, next) {
      let co_id;
      if(to.params.co_seo_title == '회사소개') {
        co_id ='company';
      }else if(to.params.co_seo_title == '서비스-이용약관') {
        co_id ='provision';
      }else if(to.params.co_seo_title == '개인정보-처리방침') {
        co_id ='privacy';
      }
      let self = this;
       window.req_api({
        content : true,
        co_seo_title : to.params.co_seo_title,
        co_id : co_id,
      }).then(function(json){
        self.c = json;
        if(!json) document.title = '잘못 된 접근입니다.';
        else document.title = json.co_seo_title;
        //self.$refs.cmt.update();
        next();
      });
    },
  }
</script>

<style lang="scss" scoped>

</style>