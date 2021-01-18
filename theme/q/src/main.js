import Vue from 'vue'
import Vuex from 'vuex'
import './assets/css/tailwind.css'
import App from './App.vue'
import theme from './theme'
import { router } from "./router"
import VueTailwind from 'vue-tailwind'
import VueAppend from 'vue-append'
Vue.use(VueAppend)
Vue.use(Vuex);
Vue.use(VueTailwind, theme);
Vue.filter("number_format", val =>{
  return String(val).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});
const store = new Vuex.Store({
  state: {
    isLogin : false,
    member : {},
    connect : {
      mb_cnt : 0,
      total_cnt : 0,
    },
  },
  mutations: {
    async Login (state) {
      let formData = new FormData();
      const id = document.getElementById('login_id').value;
      const pw = document.getElementById('login_pw').value;
      formData.append("login", true);
      formData.append("mb_id", id);
      formData.append("mb_password", pw);
      fetch("../../api/", {
        method: "post",
        body: formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(json) {
        if(json.msg) {
          alert(json.msg);
          return false;
        }
        state.isLogin = true;
        state.member = json;
      });
    },
    async Logout (state) {
      let formData = new FormData();
      formData.append('logout', true);
      fetch("../../api/", {
        method: "post",
        body: formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function() {
        state.isLogin = false;
        state.member = {};
      });
    },
  }
});
Vue.config.productionTip = false;

new Vue({
  store: store,
  router,
  render: h => h(App),
}).$mount('#app')
