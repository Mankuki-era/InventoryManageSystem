<template>
  <div class="wrapper" v-bind:class="classObject">
    <!-- ヘッダー -->
    <header-component
      v-on:message-event="messageMethod"
      v-on:loading-event="loadingMethod"
      ref="headerchild"
      v-if="showHeader"
    ></header-component>
    <adminheader-component
      v-if="showAdminHeader"
      v-on:alert-event="alertShowMethod"
      v-on:adminLoading-event="adminLoadingMethod"
      ref="adminheaderchild"
    ></adminheader-component>

    <alert-component
      v-on:message-event="messageMethod"
      ref="alertchild"
    ></alert-component>

    <div class="opening-animation" v-bind:class="{hide: openingAnimationFlag}">
      <img src="/image/zaiko_icon.png" alt="画像">
      <p>LabCom</p>
    </div>
    <div class="opening-animation-filter" v-bind:class="{hide: openingAnimationFlag}"></div>

    <div class="admin-animation" v-bind:class="{hide: adminAnimationFlag}">Admin Panel</div>
    <div class="admin-animation-filter" v-bind:class="{hide: adminAnimationFlag}"></div>

    <adminLoading-component ref="adminLoadingchild"></adminLoading-component>

    <loading-component ref="loadingchild"></loading-component>
    <message-component ref="messagechild"></message-component>
    
    <!-- メイン -->
    <router-view
      v-on:cartchange-event="cartchangeMethod"
      v-on:notificationChange-event="notificationChangeMethod"
      v-on:loading-event="loadingMethod"
      v-on:message-event="messageMethod" 
      v-on:cartReset-event="cartResetMethod" 
      v-on:class-event="classMethod"
      v-on:adminLoading-event="adminLoadingMethod"
    ></router-view>

    <!-- フッター -->
    <footer-component
      v-if="showFooter"
      ref="footerchild"
    ></footer-component>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      classObject: {
        'auth': false,
        'main': false,
        'inventory': false,
        'create': false,
        'show': false,
        'edit': false,
        'admin': false,
        'cart-index': false,
        'cart-confirm': false,
        'user-show': false,
        'user-edit': false,
      },
      hide_1: false,
      hide_2: false,
      show_1: false,
      show_2: false,
      showHeader: false,
      showAdminHeader: false,
      showFooter: false,
      adminAnimationFlag: true,
      openingAnimationFlag: true,
      shutterFlag: false,
      adminLoadingFlag: false,
    }
  },
  methods: {
    change: function(){
      this.hide_1 = true;
      this.hide_2 = true;
      this.show_1 = false;
      this.show_2 = false;
    },
    returnchange: function(){
      this.hide_1 = false;
      this.hide_2 = false;
      this.show_1 = true;
      this.show_2 = true;
    },
    cartchangeMethod: function(){
      this.$refs.headerchild.cartchangeMethod();
    },
    notificationChangeMethod: function(){
      this.$refs.headerchild.loadNotification();
    },
    loadingMethod: function(bool){
      if(bool === true){
        this.$refs.loadingchild.loadingStart();
      }else{
        this.$refs.loadingchild.loadingStop();
      }
    },
    adminLoadingMethod: function(bool){
      if(bool === true){
        this.$refs.adminLoadingchild.loadingStart();
      }else{
        this.$refs.adminLoadingchild.loadingStop();
      }
    },
    messageMethod: function(message, bool){
      this.$refs.messagechild.setMessage(message, bool);
    },
    classMethod: function(name, animationFlag){
      this.classObject = {
        'auth': false,
        'main': false,
        'inventory': false,
        'create': false,
        'show': false,
        'edit': false,
        'admin': false,
        'cart-index': false,
        'cart-confirm': false,
        'user-show': false,
        'user-edit': false,
      };
      this.classObject[name] = true;
      if(name === 'auth') {
        if(animationFlag){
          this.openingAnimationFlag = false;
          setTimeout(() => {
            this.openingAnimationFlag = true;
          }, 5000);
        }
        this.showHeader = false;
        this.showAdminHeader = false;
        this.showFooter = false;
      }else if(name === 'admin'){
        if(animationFlag){
          this.adminAnimationFlag = false;
          setTimeout(() => {
            this.adminAnimationFlag = true;
          }, 3000);
        }
        this.showHeader = false;
        this.showAdminHeader = true;
        this.showFooter = false;
      }else{
        this.showHeader = true;
        this.showAdminHeader = false;
        this.showFooter = true;
      }
    },
    alertShowMethod: function(action_name){
      this.$refs.alertchild.alertShowMethod(action_name);
    },
    cartResetMethod: function(){
      setTimeout(() => {
        this.$refs.headerchild.getCartinfo();
        this.$refs.headerchild.loadNotification();
      }, 1000)
    }
  }
}
</script>