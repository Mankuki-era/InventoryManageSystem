// ルーター設定
const router = new VueRouter({
  mode:'history', // .htaccessを記入してリフレッシュ時のnot foundを回避
  routes: [
    {
      path: '/',
      name: 'root',
    },
    { 
      path: '/connect',
      name: 'connect',
      component: httpVueLoader('../views/main/connect/index-component.vue'),
    },
    { 
      path: '/user-index',
      name: 'user-index',
      component: httpVueLoader('../views/main/user/index-component.vue'),
    },
    { 
      path: '/user-create',
      name: 'user-create',
      component: httpVueLoader('../views/main/user/create-component.vue'),
    },
    { 
      path: '/schedule-index',
      name: 'schedule-index',
      component: httpVueLoader('../views/main/schedule/index-component.vue'),
    },
    { 
      path: '/schedule-create',
      name: 'schedule-create',
      component: httpVueLoader('../views/main/schedule/create-component.vue'),
    },
    { 
      path: '/log-index',
      name: 'log-index',
      component: httpVueLoader('../views/main/log/index-component.vue'),
    },
  ]
});

router.beforeEach((to, from, next) => {
  if(!sessionStorage.getItem('linkName')){
    sessionStorage.setItem('linkName', 'connect');
    sessionStorage.setItem('subLinkName', '');
    sessionStorage.setItem('grade', '1EC');
    sessionStorage.setItem('connectFlag', false);
    next({path: '/connect'});
  }else{
    next();
  }
})

// コンポーネントをグローバル登録
Vue.component('nav-component', httpVueLoader('../views/nav-component.vue'));
Vue.component('main-component', httpVueLoader('../views/main-component.vue'));
Vue.component('modal-component', httpVueLoader('../views/share/modal-component.vue'));
Vue.component('message-component', httpVueLoader('../views/share/message-component.vue'));
Vue.component('item-component', httpVueLoader('../views/share/modal/item-component.vue'));
Vue.component('step01-component', httpVueLoader('../views/main/schedule/create/step01-component.vue'));
Vue.component('step02-component', httpVueLoader('../views/main/schedule/create/step02-component.vue'));
Vue.component('step03-component', httpVueLoader('../views/main/schedule/create/step03-component.vue'));
Vue.component('loading-component', httpVueLoader('../views/share/loading-component.vue'));

// ポート番号
var port = 8888;

const app = new Vue({
  el: "#app",
  router,
  methods: {
    openModal: function(func, id, index){
      this.$refs.modalChild.openModal(func, id, index);
    },
    indexTypeClick: function(){
      this.$refs.mainChild.indexTypeClick();
    },
    dataChange: function(index, data){ // モーダルでの変更, 削除をindexに反映
      this.$refs.mainChild.dataChange(index, data);
    },
    messageEvent: function(message, bool, initFlag){
      this.$refs.messageChild.messageEvent(message, bool, initFlag);
    }
  }
});