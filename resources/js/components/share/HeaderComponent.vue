<template>
  <header class="page_header" id="page_header">
    <h1>
      <router-link to="/items/index">
        <p class="h1_sub main_title">情報通信工学科実験室</p>
        <p class="main_title2">在庫管理システム</p>
      </router-link>
    </h1>
    <div class="header_menu">
      <div class="shopping_cart">
        <a href="#" @click.prevent.stop="cartLink" v-bind:class="{ animation: animationFlag }">
          <div class="shopping_cart_first">
            <img src="/image/shopping_cart_icon.png" alt="shopping_cart" class="shopping_cart_icon">
          </div>
          <div class="shopping_cart_number"> <!-- 追加 -->
            <p class="shopping_cart_amount">{{ count }}</p>
          </div>
        </a>
      </div>
      <div class="notification_button">
        <a href="#" class="open_notification">
          <div class="notification_top">
            <img src="/image/notification_icon.png" alt="notification" class="notification_icon">
            <div class="notification_number">
              <p class="notification_amount">{{ notificationCount }}</p>
            </div>
          </div>
        </a>
        <div class="notification_message_div">
          <div class="notification_message_div_bg">
            <ul>
              <li v-for="(notification, index) in this.notifications" :key="index">
                <div class="notification_message_all" v-bind:class="getFirstclass(notification)">
                  <div class="notification_message_date_all">
                    <div class="notification_message_date" v-bind:class="getSecondclass(notification)">
                      <div class="notification_message_date_inside">
                        <p class="event_year">{{ notification.created_at_Y }}</p>
                        <hr>
                        <p class="event_date">{{ notification.created_at_Date }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="notification_message">
                    <div class="notification_message_inside">
                      <p>{{ notification.user_name }} さんが</p>
                      <p>{{ notificationMessage(notification.type, notification.name, notification.count, notification.price) }}</p>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="for_my_account">
        <div class="../account_img" id="account_img">
          <img :src="profileImage" alt="my_photo" class="profile_img" id="profile_img" v-if="loadCompFlag">
          <img src="/image/default_user.png" alt="my_photo" class="profile_img" id="profile_img" v-else>
          <div class="for_account" id="for_account">
            <ul class="for_my_account_ul" id="for_my_account_ul">
              <li><a href="#" class="for_my_account_a" @click.prevent.stop="usershowPage">マイページ</a></li>
              <li><a href="#" class="for_my_account_a" @click.prevent.stop="usereditPage">登録内容修正</a></li>
              <li v-show="currentUserAdmin === 'assignment'"><a href="#" class="for_my_account_a" @click.prevent.stop="adminPage">管理者画面</a></li>
              <li><a href="#" class="for_my_account_a" @click.prevent.stop="logoutAction">ログアウト</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  data: function(){
    return {
      count: 0,
      profileImage: '',
      animationFlag: false,
      currentUserid: 0,
      notifications: {},
      notificationCount: 0,
      currentUserAdmin: '',
      loadCompFlag: false,
    }
  },
  mounted(){
    this.loadCompFlag = false;
    this.getCartinfo();
    this.getCurrentUserId();
    this.loadNotification();
    $(function() {
      $(document).on('click',function(e) {
        if(!$(e.target).closest('.open_notification').length && !$(e.target).closest('.profile_img').length) {
          $('.notification_message_div').slideUp(300);
          $('#for_account, #for_my_account_ul').slideUp(300);
        }
      });
      $('.open_notification').click(function(){
        $('.notification_message_div').slideToggle(300);
        $('#for_account, #for_my_account_ul').slideUp(300);
      });
      $('.profile_img').click(function(){
        $('.notification_message_div').slideUp(300);
        $('#for_account, #for_my_account_ul').slideToggle(300);
      });
      $('.for_my_account_a').click(function(){
        $('#for_account, #for_my_account_ul').slideUp(300);
      });
    });
  },
  methods: {
    getCurrentUserId: function() {
      axios.get('/api/info').then(e => {
        this.currentUserid = e.data.user_id;
        this.getUserInfo();
      }).catch((error) => {
        console.log(error);
      });
    },
    getUserInfo: function() {
      axios.get('/api/user/' + this.currentUserid).then(e => {
        this.profileImage = e.data.img_path;
        this.currentUserAdmin = e.data.admin;
        this.loadCompFlag = true;
      }).catch((error) => {
        console.log(error);
      });
    },
    loadNotification: function() {
      axios.get('/api/notification').then(e => {
        this.notifications = e.data.data;
        this.notificationCount = this.notifications.length;
      }).catch((error) => {
        console.log(error);
      });
    },
    getCartinfo: function(){
      axios.get('/api/cartinfo').then(e => {
        this.count = e.data.count;
      }).catch((error) => {
        console.log(error);
      });  
    },
    cartchangeMethod: function(){
      this.animationFlag = false;
      this.getCartinfo();
      setInterval(()=> {
        this.animationFlag = true;
      }, 600)
    },
    adminPage: function(){
      this.$router.push({
        name: 'admindashboard',
        params: {
          showAnimationFlag: true
        }
      });
    },
    cartLink: function() {
      if(this.count === 0){
        this.$emit('message-event', 'カートに商品がありません.', false);
      }else{
        this.$emit('loading-event', true);
        this.$router.push({
          name: 'cart'
        });
      }
    },
    logoutAction: function(){
      // this.$emit('loading-event', true);
      axios.post('/api/logout').then(e => {
        // this.$emit('loading-event', false);
        this.$router.push({ 
          name: "login",
          params: {
            logoutFlag: true
          }
        });
      }).catch((error) => {
        console.log(error);
      });
    },
    getFirstclass: function(notification) {
      if(notification.user_id === this.currentUserid){
        return 'mes_my';
      }else{
        return 'mes_other';
      }
    },
    getSecondclass: function(notification) {
      if(notification.type === 'ItemSupply' || notification.type === 'ItemConsume'){
        return 'stock_trigger';
      }else if(notification.type === 'UserCreate' || notification.type === 'UserUpdate' || notification.type === 'UserDestroy' || notification.type === 'UserRegister'){
        return 'user_trigger';
      }else if(notification.type === 'ItemCreate' || notification.type === 'ItemUpdate' || notification.type === 'ItemDestroy') {
        return 'item_trigger';
      }else if(notification.type === 'ThemaCreate' || notification.type === 'ThemaUpdate' || notification.type === 'ThemaDestroy') {
        return 'thema_trigger';
      }else if(notification.type === 'ItemPurchase') {
        return 'export_trigger';
      }else if(notification.type === 'PassChange' || notification.type === 'RefreshTable' || notification.type === 'ItemBackup' || notification.type === 'ItemImport') {
        return 'subaction_trigger';
      }
    },
    notificationMessage: function(type, name, count, price) {
      if(type === 'ItemSupply') {
        return `${name}を${count}個納入しました.`;
      }else if(type === 'ItemConsume') {
        return `${name}を${count}個消費しました.`;
      }else if(type === 'UserRegister') {
        return '新規会員として参加しました.';
      }else if(type === 'UserCreate') {
        return `${name}を新規ユーザー登録しました.`;
      }else if(type === 'UserUpdate') {
        return `${name}のユーザー情報を編集しました.`;
      }else if(type === 'UserDestroy') {
        return `${name}をユーザーデータから削除しました.`;
      }else if(type === 'ItemCreate') {
        return `${name}を製品データに新規登録しました.`;
      }else if(type === 'ItemUpdate') {
        return `${name}の製品情報を編集しました.`;
      }else if(type === 'ItemDestroy') {
        return `${name}を製品データから削除しました.`;
      }else if(type === 'ThemaCreate') {
        return `${name}をテーマデータに新規登録しました.`;
      }else if(type === 'ThemaUpdate') {
        return `${name}のテーマ情報を編集しました.`;
      }else if(type === 'ThemaDestroy') {
        return `${name}をテーマデータから削除しました.`;
      }else if(type === 'ItemPurchase') {
        return `${count}個の製品(${Number(price).toLocaleString()}円)の発注表を作成しました.`;
      }else if(type === 'PassChange') {
        return '管理者パスワードを変更しました.';
      }else if(type === 'RefreshTable') {
        return `${name}テーブルをリフレッシュしました.`;
      }else if(type === 'ItemBackup') {
        return '製品をバックアップしました.';
      }else if(type === 'ItemImport') {
        return '製品データをインポートしました.';
      }
    },
    usershowPage: function(){
      this.$emit('loading-event', true);
      this.$router.push({
        name: 'usershow',
        params: {
          id: this.currentUserid
        }
      });
    },
    usereditPage: function(){
      this.$emit('loading-event', true);
      this.$router.push({
        name: 'useredit',
        params: {
          id: this.currentUserid
        }
      });
    },
  }
}
</script>
