<template>
  <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300">
      <!-- Mobile hamburger -->
      <button class="p-1 -ml-1 mr-5 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" aria-label="Menu" @click="toggleMenu">
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
        </svg>
      </button>
      <!-- Search input -->
      <div class="flex justify-center flex-1 lg:mr-32">
        <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500">
          <div class="absolute inset-y-0 flex items-center pl-2">
            <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
            </svg>
          </div>
          <input class="w-full pl-8 pr-2 py-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input" type="text" placeholder="검색어를 입력해주세요" aria-label="Search" :value="$route.query.stx" @keyup.enter="MainSearch()" ref="fsearch">
        </div>
      </div>
      <ul class="flex items-center flex-shrink-0 space-x-6">
        <!-- Theme toggler -->
        <li class="flex">
          <button class="rounded-md focus:outline-none focus:shadow-outline-purple" aria-label="Toggle color mode" @click="themeChange">
            <div v-if="!dark">
              <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
              </svg>
            </div>
            <div v-if="dark">
              <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
              </svg>
            </div>
          </button>
        </li>
        <!-- Notifications menu -->
        <li class="relative">
          <t-dropdown>
            <div
              slot="trigger"
              slot-scope="{
                mousedownHandler,
                focusHandler,
                blurHandler,
                keydownHandler,
                isShown
              }"
            >
              <button
                id="user-menu"
                class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple"
                :class="{ '': isShown }"
                aria-label="User menu"
                aria-haspopup="true"
                @mousedown="mousedownHandler"
                @focus="focusHandler"
                @blur="blurHandler"
                @keydown="keydownHandler"
              >
                <i class="fa fa-info w-5 h-5"></i>
              </button>
            </div>
            <div>
              <ul class="absolute right-0 w-32 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700" aria-label="submenu">
                <li class="flex">
                  <router-link to='/bbs/faq' class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                    <span>FAQ</span>
                  </router-link>
                </li>
                <li class="flex">
                  <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                    <span>Q&A</span>
                  </a>
                </li>
                <li class="flex">
                  <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                    <span>새글</span>
                  </a>
                </li>
                <li class="flex">
                  <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                    <span>접속자</span>
                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600" v-if="$store.state.connect">
                      {{$store.state.connect.total_cnt}}
                    </span>
                  </a>
                </li>
             </ul>
            </div>
          </t-dropdown>
        </li>
        <!-- Profile menu -->
        <li class="relative">
          <div v-if="$store.state.isLogin == false">
            <button @click="$refs.LoginModal.show()" type="button">로그인</button>
            <t-modal
              ref="LoginModal"
              header="로그인"
            >
              <t-input value="" name="mb_id" ref="login_id" id="login_id" placeholder="아이디를 입력하세요." @keyup.enter="floginSubmit" />
              <t-input value="" name="mb_password" ref="login_pw" id="login_pw" type="password" placeholder="비밀번호를 입력하세요." @keyup.enter="floginSubmit"/>
              <div class="flex justify-between mt-3">
                <t-button v-on:click="floginSubmit"> 로그인 </t-button>
                <t-button variant="success" type="button" @click="register">회원가입</t-button>
              </div>
            </t-modal>
          </div>
          <t-dropdown v-if="$store.state.isLogin == true">
            <div
              slot="trigger"
              slot-scope="{
                mousedownHandler,
                focusHandler,
                blurHandler,
                keydownHandler,
                isShown
              }"
            >
              <button
                id="user-menu"
                class="flex rounded-full text-sm text-gray-700 items-center pr-3 focus:outline-none focus:shadow-solid transition duration-150 ease-in-out "
                :class="{ 'border-gray-300 bg-gray-100 text-white dark:bg-gray-600': isShown }"
                aria-label="User menu"
                aria-haspopup="true"
                @mousedown="mousedownHandler"
                @focus="focusHandler"
                @blur="blurHandler"
                @keydown="keydownHandler"
              >
                <img class="object-cover w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1502378735452-bc7d86632805?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=entropy&amp;cs=tinysrgb&amp;w=200&amp;fit=max&amp;s=aa3a807e1bbdfd4364d1f449eaa96d82" alt="" aria-hidden="true">
                <div class="px-2 dark:text-gray-400 font-bold"> {{$store.state.member.mb_id}} </div>
              </button>
            </div>
            <div>
              <ul class="absolute right-0 w-32 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700" aria-label="submenu">
                <li class="flex">
                  <a class="justify-between inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                    <i class="w-4 h-4 mr-3 fa fa-database"> </i>
                    <span>{{$store.state.member.mb_point | number_format}}</span>
                  </a>
                </li>
                <li class="flex">
                  <router-link class="justify-between inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" to="/bbs/memo">
                    <i class="w-4 h-4 mr-3 far fa-envelope"> </i>
                    <span>{{$store.state.member.mb_memo_cnt | number_format}}</span>
                  </router-link>
                </li>
                <li class="flex">
                  <router-link class="justify-between inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" to="/bbs/scrap">
                    <i class="w-4 h-4 mr-3 fas fa-thumbtack"> </i>
                    <span>{{$store.state.member.mb_scrap_cnt | number_format}}</span>
                  </router-link>
                </li>
                <li class="flex">
                  <a class="justify-between inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="#">
                    <i class="w-4 h-4 mr-3 fas fa-user-edit"> </i>
                    <span>프로필</span>
                  </a>
                </li>
                <li class="flex">
                  <button class="justify-between inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" @click="floginSubmit">
                    <i class="w-4 h-4 mr-3 fas fa-sign-out-alt"> </i>
                    <span>로그아웃</span>
                  </button>
                </li>
             </ul>
            </div>
          </t-dropdown>
        </li>
      </ul>
    </div>
  </header>
</template>

<script>
  export default {
    name : 'top',
    methods : {
      themeChange () {
        document.getElementById('themeChange').click();
        if(this.dark == true) {
          this.dark = false;
        }else if(this.dark == false){
          this.dark = true;
        }
      },
      MainSearch () {
        var stx = this.$refs.fsearch.value;
        this.$router.push({name: 'search', query : {sfl : "wr_subject||wr_content" , sop : "and", stx : stx}});
      },
      toggleMenu () {
        if(document.getElementById('nav_menu').classList.contains('hidden'))
          document.getElementById('nav_menu').classList.remove('hidden');
        else
          document.getElementById('nav_menu').classList.add('hidden');
      },
      async floginSubmit () {
        if(this.$store.state.isLogin == false){
          await this.$store.commit('Login');
          await this.$parent.$refs.body.update();
        }else{
          await this.$store.commit('Logout');
          await this.$parent.$refs.body.update();
        }
      },
      register () {
        this.$router.push('/bbs/register');
        this.$refs.LoginModal.hide();
      }
    },
    data: function () {
      return {
        dark: false
      }
    },
    created () {
      /**
       * 로그인 중이라면 바로 로그인 상태로 표기
       */
      let self = this;
      window.req_api({
        isLogin : true,
      }).then(function(json) {        
        if(json.mb_id != '') {
          self.$store.state.isLogin = true;
          self.$store.state.member = json;
        }
      });
    }
  }
</script>

<style lang="scss" scoped>

</style>