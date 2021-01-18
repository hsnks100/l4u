<template>
  <div class="m-5 mb-20">
    <div v-if="n" class="flex border rouned">
      <t-select name="gr_id" id="gr_id" ref="gr_id"
      :options="n.group_select" />      
      <t-select name="view" id="view" ref="view"
      :options="[
        { value: '', label: '전체게시물' },
        { value: 'w', label: '원글만' },
        { value: 'c', label: '코멘트만' },
      ]"
      />
      <t-input :value="$route.query.mb_id" name="mb_id" id="mb_id" ref="mb_id" @keyup.enter="search" />
      <t-button variant="primary" class="whitespace-no-wrap" @click="search"> 검색 </t-button>
    </div>
    <div class="text-center text-xs my-2"> <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-teal-100 text-teal-800"> 회원 아이디만 검색 가능 </span> </div>
    <div v-for="row in list" :key="row.wr_id" class="border-b py-2 items-center px-1 table w-full">
      <div class="table-row">
      <div class="w-20 whitespace-no-wrap	table-cell"> <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> {{row.gr_subject}} </span> </div>
      <div class="w-20 whitespace-no-wrap	table-cell"> <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800"> {{row.bo_subject}} </span> </div>
      <router-link :to="row.href" class="hover:text-teal-500 font-bold"> <div> {{row.comment}} {{row.wr_subject}} </div> </router-link>
      <div class="w-32 whitespace-no-wrap	table-cell" v-html="row.name"></div>
      <div class="w-16 whitespace-no-wrap	table-cell"> {{row.datetime2}} </div>
      </div>
    </div>
    <div class="p-5 shadow text-center my-4 border" v-if="list.length == 0"> 게시물이 없습니다 </div>
    <t-pagination
      :total-items="n.total_count"
      :per-page="n.perPage"
      :limit="5"
      :disabled="false"
      v-model="n.page"
      @change="page"
    />
  </div>
</template>

<script>
  export default {
    created () {
      let self = this;
      window.req_api({
        new : true,
        gr_id : this.$route.query.gr_id ? this.$route.query.gr_id : 0,
        mb_id : this.$route.query.mb_id ? this.$route.query.mb_id : 0,
        view : this.$route.query.view ? this.$route.query.view : 0,
      }).then(function(json) {        
        self.n = json;
        self.list = json.list;
        if(json.g5.title) document.title = json.g5.title;
      });
    },
    data () {
      return {
        n : {
          bo_subject : [],
          search_table_count : [],
        },
        list : [],
      }
    },
    methods : {
      search () {
        let mb_id = document.querySelector('#mb_id').value;
        let gr_id = this.$refs.gr_id.$el.value;
        let view = this.$refs.view.$el.value;
        this.$router.push({name: 'New', query : {mb_id : mb_id , view : view, gr_id : gr_id}});
      },
      // eslint-disable-next-line no-unused-vars
      page (page) {
        let mb_id = this.$route.query.mb_id ? this.$route.query.mb_id : '';
        let gr_id = this.$route.query.gr_id ? this.$route.query.gr_id : '';
        let view = this.$route.query.view ? this.$route.query.view : '';
        page = page ? page : 0;
        this.$router.push({name: 'New', query : {mb_id : mb_id , view : view, gr_id : gr_id,page : page}});
      },
    },
    beforeRouteUpdate (to, from, next) {
      let self = this;
      window.req_api({
        new : true,
        mb_id : to.query.mb_id,
        gr_id : to.query.gr_id,
        view : to.query.view,
        page : to.query.page ? to.query.page : 1,
      }).then(function(json) {        
        self.n = json;
        self.list = json.list;
        if(json.g5.title) document.title = json.g5.title;
        console.log(json);
        next();
      });
    }
  }
</script>

<style lang="scss" scoped>

</style>