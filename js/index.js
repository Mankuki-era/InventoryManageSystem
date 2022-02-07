// ルーター設定
const router = new VueRouter({
  mode:'history', // .htaccessを記入してリフレッシュ時のnot foundを回避
  routes: [
    {
      path: '/',
      name: 'root',
      redirect: '/index',
    },
    { 
      path: '/create',
      name: 'create',
      component: httpVueLoader('../views/main/create-component.vue'),
      beforeEnter: (to, from, next) => {
        sessionStorage.setItem('linkName', 'create');
        if(!sessionStorage.getItem('createType') || from.name !== null){
          sessionStorage.setItem('createType', '01');
        };
        if(from.name === 'index'){
          sessionStorage.setItem('indexType', 'すべて');
        }
        next();
      }
    },
    { 
      path: '/index',
      name: 'index',
      component: httpVueLoader('../views/main/index-component.vue'),
      beforeEnter: (to, from, next) => {
        sessionStorage.setItem('linkName', 'index');
        if(!sessionStorage.getItem('indexType')){
          sessionStorage.setItem('indexType', 'すべて');
        };
        next();
      }
    },
  ]
});

// コンポーネントをグローバル登録
Vue.component('nav-component', httpVueLoader('../views/nav-component.vue'));
Vue.component('main-component', httpVueLoader('../views/main-component.vue'));
Vue.component('modal-component', httpVueLoader('../views/share/modal-component.vue'));
Vue.component('message-component', httpVueLoader('../views/share/message-component.vue'));
Vue.component('item-component', httpVueLoader('../views/share/modal/item-component.vue'));
Vue.component('type01-component', httpVueLoader('../views/main/create/type01-component.vue'));
Vue.component('type02-component', httpVueLoader('../views/main/create/type02-component.vue'));
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