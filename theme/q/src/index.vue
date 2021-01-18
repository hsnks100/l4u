<template>
  <div class="dark:bg-gray-900 h-full dark:text-gray-400">
    <div class="grid sm:grid-flow-row-dense md:grid-flow-row-dense lg:grid-flow-row-dense xl:grid-flow-col">
      <div class="my-3 mx-2" v-for="rows in list" :key="rows.wr_id">
        <t-card header="자유게시판"
        :classes="{
            wrapper: 'bg-white dark:bg-gray-700',
            body: 'flex-grow text-teal-700',
            close: {'text-teal-500 hover:bg-teal-200 ml-4 rounded': true},
            closeIcon: ['h-5', 'w-5', 'fill-current']
          }">
          <div v-for="row in rows" :key="row.wr_id">
            <ul class="flex justify-between items-center">
              <li> <router-link class="" :to=row.href> {{row.subject}} </router-link> </li>
              <li class="text-sm"> {{row.last2}} </li>
            </ul>
          </div>
        </t-card>
      </div>
    </div>
  </div>
</template>

<script>
import latest from './mixin/latest.js'
export default {
  mixins: [latest],
  name: 'index',
  components: {
    //'gnu-footer' : tail,
  },
  data () {
    return {
      list : [],
    }
  },
  created () {
    this.latest('free','10','40').then((rows) => this.list.push(rows))
    this.latest('notice','10','40').then((rows) => this.list.push(rows))
    console.log(this.list);
  }
}
</script>

<style>
</style>
