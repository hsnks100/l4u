<template>
  <div>
    <t-alert variant="danger" show v-if="list.msg && list" :dismissible="false">
      {{list.msg}}
    </t-alert>
    <div v-if="list" class="p-3">
      <div v-html="list.fm.fm_head_html" class="my-3"></div>
      <div v-for="row in list.faq_list" :key="row.id" class="bg-white dark:bg-gray-800 shadow dark:text-gray-300">
        <div> 
          <h2 class="flex justify-between p-3 border-b cursor-pointer hover:text-teal-500 font-bold" v-on:click="View(row.fa_id)"> Q. {{row.fa_subject}} <i class="fas fa-plus"> </i> </h2>
          <div class="hidden p-5" v-html="row.fa_content" :data-a="row.fa_id"> {{row.fa_subject}} </div>
        </div>
      </div>
      <div v-html="list.fm.fm_tail_html"></div>
    </div>
    <div class="text-right p-5 text-red-500"><a :href="list.admin_href" class="btn_admin btn" title="FAQ 수정"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">FAQ 수정</span></a></div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        list : {
          msg : null,
          fm : {
            fm_head_html : null,
            fm_tail_html : null,
          }
        },
      }
    },
    methods : {
      View(id) {
        if(document.querySelector('[data-a="'+id+'"]').classList.contains('hidden'))
          document.querySelector('[data-a="'+id+'"]').classList.remove('hidden');
        else
          document.querySelector('[data-a="'+id+'"]').classList.add('hidden');
      }
    },
    created () {
      let self = this;
      window.req_api({
        faq : true,
      }).then(function(json){
        self.list = json;
        console.log(self.list);
      });
    }
  }
</script>

<style lang="scss" scoped>

</style>