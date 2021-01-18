<template>
  <div>
    <div class="m-5" v-if="s.list.length > 0">
      <t-card >
        <template v-slot:header>
          <div class="flex justify-between">
            {{s.member.mb_nick}}님의 스크랩
          </div>
        </template>
        <div v-for="row in list" :key="row.wr_id" class="pb-3">
          <div class="flex justify-between"> <router-link :to="row.opener_href_wr_id"> {{row.subject}} </router-link> <i class="far fa-trash-alt"></i> </div>
          <div class="text-gray-500">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-purple-100 text-purple-800"> {{row.bo_subject}} </span>
            <span class="text-xs ml-3"> {{row.ms_datetime}} </span>
          </div>
        </div>
      </t-card>
      <t-pagination
        :total-items="s.total_count"
        :per-page="s.perPage"
        :limit="5"
        :disabled="false"
        v-model="s.page"
        @change="page"
      />
    </div>
    
    <t-alert variant="danger" show v-if="list.length==0" :dismissible="false">
      스크랩 한 게시물이 없습니다.
    </t-alert>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        s : {
          msg : null,
          list : [],
        },
        list : [],
      }
    },
    created () {
      let self = this;
      window.req_api({
        scrap : true,
      }).then(function(json) {        
        self.s = json;
        self.list = json.list;
        if(json.g5.title) document.title = json.g5.title;
      });
    },
    methods : {
      page (page) {
        page = page ? page : 1;
        this.$router.push({name: 'scrap', query : {page : page}});
      },
    }
  }
</script>

<style lang="scss" scoped>

</style>