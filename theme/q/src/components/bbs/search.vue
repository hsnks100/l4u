<template>
  <div class="m-5 mb-20">
    <div v-if="s" class="flex">
        <t-select name="gr_id" id="gr_id" ref="gr_id"
        :options="s.group_select" />      
        <t-select name="sfl" id="sfl" ref="sfl"
        :options="[
          { value: 'wr_subject||wr_content', label: '제목+내용' },
          { value: 'wr_subject', label: '제목' },
          { value: 'wr_content', label: '내용' },
          { value: 'mb_id', label: '회원아이디' },
          { value: 'wr_name', label: '이름' },
        ]"
        />
      <t-input :value="$route.query.stx" name="stx" id="stx" ref="stx" @keyup.enter="search" />
      <t-button variant="primary" class="whitespace-no-wrap" @click="search"> 검색 </t-button>
      <t-toggle ref="sop"
        value="and"
        unchecked-value="and"
        checked-placeholder="AND"
        unchecked-placeholder="OR"
        checked-label="OR"
        unchecked-label="AND"
        :classes="{
          wrapper: 'bg-gray-200 focus:outline-none focus:shadow-outline rounded-sm border-2',
          wrapperChecked: 'bg-gray-200 focus:outline-none focus:shadow-outline rounded-sm border-2',
          button: 'rounded-sm w-10 h-10 bg-white shadow flex items-center justify-center text-gray-800 text-xs',
          buttonChecked: 'rounded-sm w-10 h-10 bg-white shadow flex items-center justify-center text-gray-800 text-xs',
          checkedPlaceholder: 'rounded-sm w-10 h-10 flex items-center justify-center text-gray-500 text-xs',
          uncheckedPlaceholder: 'rounded-sm w-10 h-10 flex items-center justify-center text-gray-500 text-xs'
        }"
      />
    </div>
    <div class="bg-teal-700 my-2 p-3 text-gray-200 font-bold rounded"> {{$route.query.stx}} 검색 결과 </div>
    <div v-if="lists"> 
      <div v-for="(list, i) in lists" :key="i">
        <h2 v-if="s.bo_subject && s.search_table_count" class="bg-purple-600 p-3 rounded text-gray-300 font-bold"> {{s.bo_subject[i]}} 검색 결과 총 {{s.search_table_count[i]}}개 </h2>
        <div v-for="row in list" :key="row.wr_id" class="border-b py-3 items-center px-1">
          <router-link :to="row.href"> <div class="title hover:text-blue-500 hover:bg-gray-300 rounded" v-html="row.subject"> </div> </router-link>
          <div v-html="row.content" class="break-all p-3 text-gray-800 text-sm"> </div>
          <div class="inline-block text-sm" v-html="row.name"> </div> <div class="inline-block ml-4 text-xs text-gray-600"> {{row.wr_datetime}} </div>
        </div>
      </div>
      <t-pagination
        :total-items="s.total_count"
        :per-page="s.perPage"
        :limit="5"
        :disabled="false"
        v-model="s.page"
        @change="page"
      />
    </div>
  </div>
</template>

<script>
  export default {
    created () {
      let self = this;
      window.req_api({
        fsearch : true,
        sfl : this.$route.query.sfl,
        sop : this.$route.query.sop,
        stx : this.$route.query.stx,
        page : this.$route.query.page,
      }).then(function(json) {        
        self.s = json;
        self.lists = json.list;
        document.title = json.g5.title;
      });
    },
    data () {
      return {
        s : {
          bo_subject : [],
          search_table_count : [],
        },
        lists : null,
      }
    },
    methods : {
      search () {
        let stx = document.getElementById('stx').value;
        let sfl = this.$refs.sfl.$el.value;
        let gr_id = this.$refs.gr_id.$el.value;
        let sop = this.$refs.sop.value;
        this.$router.push({name: 'search', query : {sfl : sfl , sop : sop, stx : stx, gr_id : gr_id}});
      },
      page (page) {
        let stx = document.getElementById('stx').value;
        let sfl = this.$refs.sfl.$el.value;
        let gr_id = this.$refs.gr_id.$el.value;
        let sop = this.$refs.sop.value;
        this.$router.push({name: 'search', query : {sfl : sfl , sop : sop, stx : stx, gr_id : gr_id, page : page}});
      }
    },
    beforeRouteUpdate (to, from, next) {
      let self = this;
      window.req_api({
        fsearch : true,
        sfl : to.query.sfl,
        sop : to.query.sop,
        stx : to.query.stx,
        page : to.query.page,
      }).then(function(json) {        
        self.s = json;
        self.lists = json.list;
        document.title = json.g5.title;
        console.log(json);
        next();
      });
    }
  }
</script>

<style lang="scss" scoped>

</style>