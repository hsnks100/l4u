<template>
  <div>
    <div class="m-5" v-if="list.length > 0">
      <t-card >
        <template v-slot:header>
          <div class="flex justify-between">
            {{m.member.mb_nick}}님의 스크랩
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
        :total-items="m.total_count"
        :per-page="m.perPage"
        :limit="5"
        :disabled="false"
        v-model="m.page"
        @change="page"
      />
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      m : [],
      list : [],
    }
  },
  created () {
    let self = this;
    window.req_api({
      memo : true,
    }).then(function(json) {        
      self.m = json;
      self.list = json.list;
      if(json.g5.title) document.title = json.g5.title;
    });
  },
}
</script>

<style lang="scss" scoped>

</style>