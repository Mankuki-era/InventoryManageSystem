<template>
  <main class="main-notification">
    <div class="main-contena">
      <div class="main-title">Notification Management</div>
      <div class="submain-contena">
        <div class="submain-contena-logo"><i class="fas fa-bell submain-contena-icon"></i></div>
        <div class="submain">
          <p class="submain-title">Notifications All</p>
          <div class="no-notifications" v-if="notifications.length === 0">
            <p><i class="fas fa-info-circle info-icon"></i>通知はありません.</p>
          </div>
          <div class="buttons" v-if="notifications.length !== 0">
            <li class="refresh-button"><a href="#" @click.prevent.stop="refreshAction"><i class="fas fa-redo-alt buttons-icon refresh-icon"></i>REFRESH</a></li>
          </div>
          <div class="notificationCount-box" v-if="notifications.length !== 0">
            <div class="left-box"><i class="fas fa-bell fa-lg icon"></i></div>
            <div class="right-box">{{ notifications.length }}</div>
          </div>
          <div class="notification-chatcontena" v-if="notifications.length !== 0">
            <div class="left-contena">
              <div class="chat-row" v-for="(notification, index) in notifications" :key="index" v-bind:class="{ hide: notification.user_id === currentUserid }">
                <div class="chat-box" v-bind:class="setColor(notification.user.role)">
                  <div class="up-box">
                    <img :src="notification.user.img_path" alt="Image">
                    <div class="sub-content">
                      <p class="user-name">{{ notification.user.name }}</p>
                      <p class="time"><i class="fas fa-history time-icon"></i>{{ notification.created_at }}</p>
                    </div>
                  </div>
                  <div class="down-box">
                    <p>{{ notificationMessage(notification.type, notification.name, notification.count, notification.price) }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="center-contena">
              <div class="center-row" v-for="(notification, index) in notifications" :key="index">
                <div class="center-line"></div>
                <div class="icon-box" v-bind:class="setClass(notification)">
                  <i class="fas fa-plus" v-show="notification.type === 'ItemSupply'"></i>
                  <i class="fas fa-minus" v-show="notification.type === 'ItemConsume'"></i>
                  <i class="fas fa-plus-square" v-show="notification.type === 'UserCreate' || notification.type === 'ItemCreate' || notification.type === 'ThemaCreate'"></i>
                  <i class="fas fa-edit" v-show="notification.type === 'UserUpdate' || notification.type === 'ItemUpdate' || notification.type === 'ThemaUpdate'"></i>
                  <i class="fas fa-trash-alt" v-show="notification.type === 'UserDestroy' || notification.type === 'ItemDestroy' || notification.type === 'ThemaDestroy'"></i>
                  <i class="fas fa-receipt" v-show="notification.type === 'ItemPurchase'"></i>
                  <i class="fas fa-key" v-show="notification.type === 'PassChange'"></i>
                  <i class="fas fa-sync-alt" v-show="notification.type === 'RefreshTable'"></i>
                  <i class="fas fa-download" v-show="notification.type === 'ItemBackup'"></i>
                  <i class="fas fa-upload" v-show="notification.type === 'ItemImport'"></i>
                  <i class="fas fa-user-plus" v-show="notification.type === 'UserRegister'"></i>
                </div>
              </div>
            </div>
            <div class="right-contena">
              <div class="chat-row" v-for="(notification, index) in notifications" :key="index" v-bind:class="{ hide: notification.user_id !== currentUserid }">
                <div class="chat-box" v-bind:class="setColor(notification.user.role)">
                  <div class="up-box">
                    <img :src="notification.user.img_path" alt="Image">
                    <div class="sub-content">
                      <p class="user-name">{{ notification.user.name }}</p>
                      <p class="time"><i class="fas fa-history time-icon"></i>{{ notification.created_at }}</p>
                    </div>
                  </div>
                  <div class="down-box">
                    <p>{{ notificationMessage(notification.type, notification.name, notification.count, notification.price) }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data: function() {
    return {
      notifications: {},
      currentUserid: 0,
    }
  },
  mounted() {
    this.$emit('class-event', 'admin');
    this.getCurrentUserId();
  },
  methods: {
    getCurrentUserId: function() {
      this.$emit("adminLoading-event", true);
      axios.get('/api/info').then(e => {
        this.currentUserid = e.data.user_id;
        this.loadNotification();
      }).catch((error) => {
        console.log(error);
      });
    },
    loadNotification: function() {
      axios.get('/api/notification').then(e => {
        this.notifications = e.data.data;
        this.$emit("adminLoading-event", false);
      }).catch((error) => {
        console.log(error);
      });
    },
    refreshAction: function() {
      this.getCurrentUserId();
    },
    setClass: function(notification){
      var classObject = {
        'stock': false,
        'export': false,
        'subaction': false,
        'user': false,
        'item': false,
        'thema': false,
      }
      if(notification.type === 'ItemSupply' || notification.type === 'ItemConsume'){
        classObject.stock = true;
      }else if(notification.type === 'ItemPurchase'){
        classObject.export = true;
      }else if(notification.type === 'PassChange' || notification.type === 'RefreshTable' || notification.type === 'ItemBackup' || notification.type === 'ItemImport'){
        classObject.subaction = true;
      }else if(notification.type === 'UserCreate' || notification.type === 'UserUpdate' || notification.type === 'UserDestroy' || notification.type === 'UserRegister'){
        classObject.user = true;
      }else if(notification.type === 'ItemCreate' || notification.type === 'ItemUpdate' || notification.type === 'ItemDestroy'){
        classObject.item = true;
      }else if(notification.type === 'ThemaCreate' || notification.type === 'ThemaUpdate' || notification.type === 'ThemaDestroy'){
        classObject.thema = true;
      }

      return classObject;
    },
    setColor: function(role){
      var classObject = {
        'dayTime': false,
        'nightTime': false,
        'teacher': false
      }
      if(role === 'DAYTIME'){
        classObject.dayTime = true;
      }else if(role === 'NIGHTTIME'){
        classObject.nightTime = true;
      }else {
        classObject.teacher = true;
      }
      return classObject;
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
        return `${count}個の製品(${price}円)の発注表を作成しました.`;
      }else if(type === 'PassChange') {
        return '管理者パスワードを変更しました.';
      }else if(type === 'RefreshTable') {
        return `${name}テーブルをリフレッシュしました.`;
      }else if(type === 'ItemBackup') {
        return '製品をバックアップしました.';
      }else if(type === 'ItemImport') {
        return '製品データをインポートしました.';
      }
    }
  }
}
</script>