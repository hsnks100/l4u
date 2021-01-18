<template>
<aside class="hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0" id="nav_menu">
  <div class="py-4 text-gray-500 dark:text-gray-400">
    <router-link class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" to="/">
      {{title}}
    </router-link>
    <div class="mt-6 menu" >
      <ul v-for="(row, i) in get_menu_db" :key="row.me_id">
        <div class="flex items-center">
          <router-link class="relative px-6 py-3 inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-teal-300 dark:hover:text-gray-200" :to="row.me_link" >
            <span class="ml-4">{{row.me_name}}</span>
            <div v-if="row.sub">
            </div>
          </router-link>
          <div v-if="row.sub">
            <svg class="w-10 h-10 cursor-pointer fill-current hover:text-teal-500" @click="subToggle(i)" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </div>
        <ul v-if="row.sub" :data-sub="i" class="hidden transition-all ease-in-out duration-300 p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900" aria-label="submenu">
          <div v-for="sub in row.sub" :key="sub.me_id">
            <router-link class="block w-full px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" :to="sub.me_link" >{{sub.me_name}}</router-link>
          </div>
        </ul>
      </ul>
    </div>
  </div>
  <!--
  <div class="fixed bottom-0 left-0 z-50 p-2 border-t text-center w-full bg-white dark:bg-gray-800 dark:text-gray-300 text-sm divide-x divide-gray-400 dark:divide-gray-200"> 
    <router-link class="px-3" to="/content/회사소개"> 회사소개 </router-link>
    <router-link class="px-3" to="/content/서비스-이용약관"> 이용약관 </router-link>
    <router-link class="px-3" to="/content/개인정보-처리방침"> 개인정보 처리 방침 </router-link>
  </div>
  -->
</aside>
</template>

<script>
  export default {
    data () {
      return {
        get_menu_db : [],
        title : window.title,
      }   
    },
    created(){
      let self = this;
      var formData = new FormData();
      formData.append('get_menu_db', true)
      fetch('../../api/',{
        method : 'post',
        body : formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(json) {
        self.get_menu_db = json;
      });
    },
    methods : {
      subToggle (i) {
        var sub = document.querySelector('[data-sub="'+i+'"]');
        if(sub.classList.contains('hidden'))
          sub.classList.remove('hidden');
        else
          sub.classList.add('hidden');
      }
    }
  }
</script>

<style scoped>
.menu .router-link-exact-active {
  @apply border-l-4 border-purple-600
}
</style>