// ルーター設定
// const router = new VueRouter({
//   // mode:'history',
//   routes: [
//     { 
//       path: '/',
//       component: httpVueLoader('../views/main.vue'),
//     },
//   ]
// });

// コンポーネントをグローバル登録
Vue.component('nav-component', httpVueLoader('../views/nav-component.vue'));
Vue.component('main-component', httpVueLoader('../views/main-component.vue'));

// ポート番号
var port = 8888

const app = new Vue({
  el: "#app",
  // router,
  methods: {
    clickBar: function(){
      this.$refs.navChild.clickBar();
    }
  }
});