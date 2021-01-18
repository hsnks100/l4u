import Vue from 'vue';
import VueRouter from 'vue-router';
//import App from '@/App'
import Index from '@/index'
import list from '@/components/list'
import view from '@/components/view'
import write from '@/components/write'
import register from '@/components/bbs/register'
import search from '@/components/bbs/search'
import New from '@/components/bbs/new'
import memo from '@/components/bbs/memo'
import scrap from '@/components/bbs/scrap'
import password from '@/components/bbs/password'
import faq from '@/components/faq'
import content from '@/components/content/index'
const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function push(location) { // 해당 경로에서 또 호출했을떄 에러 처리
  return originalPush.call(this, location).catch(err => err)
};
Vue.use(VueRouter); // Vue 라이브러리를 인식하게끔 상단에 Vue 를 임포트 해준다!

// 라우터의 정보들을 넣어준다.
export const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Index,
    },
    {
      path: '/content/:co_seo_title',
      component: content,
    },
    {
      path: '/bbs/faq',
      component: faq,
    },
    {
      path: '/bbs/password',
      component: password,
      name : password,
    },
    {
      path: '/bbs/scrap',
      name : 'scrap',
      component: scrap,
    },
    {
      path: '/bbs/memo',
      name : 'memo',
      component: memo,
    },
    {
      path: '/bbs/new',
      name : 'New',
      component: New,
    },
    {
      path: '/bbs/search',
      name : 'search',
      component: search,
    },
    {
      path: '/bbs/register',
      component: register,
    },
    {
      path: '/:bo_table/write/',
      component: write,
      name : 'write',
    },
    {
      path: '/:bo_table/:seo/',
      component: view,
    },
    {
      path: '/:bo_table',
      component: list,
    },
  ]
})