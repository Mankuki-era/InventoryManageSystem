<template>
  <header class="admin_header">
    <div class="header-box">
      <div class="header-title">
        <img src="/image/zaiko_icon.png" alt="画像">
        <p>Admin Panel</p>
      </div>
      <ul>
        <li v-bind:class="{ selected: isSelect[0] }"><a href="#" @click.prevent.stop="linkAction(0)"><i class="fas fa-stream fa-lg icon"></i>Dash Board</a></li>
        <li v-bind:class="{ selected: isSelect[1] }"><a href="#" @click.prevent.stop="linkAction(1)"><i class="fas fa-user fa-lg icon"></i>User Management</a></li>
        <li v-bind:class="{ selected: isSelect[2] }"><a href="#" @click.prevent.stop="linkAction(2)"><i class="fas fa-shopping-bag fa-lg icon"></i>Item Management</a></li>
        <li v-bind:class="{ selected: isSelect[3] }"><a href="#" @click.prevent.stop="linkAction(3)"><i class="fas fa-shopping-cart cart-icon fa-lg icon"></i>Cart Management</a></li>
        <li v-bind:class="{ selected: isSelect[4] }"><a href="#" @click.prevent.stop="linkAction(4)"><i class="fas fa-bell fa-lg icon"></i>Notification Management</a></li>
        <li v-bind:class="{ selected: isSelect[5] }"><a href="#" @click.prevent.stop="linkAction(5)"><i class="fas fa-tags fa-lg icon"></i>Tag Management</a></li>
        <li v-bind:class="{ selected: isSelect[6] }"><a href="#" @click.prevent.stop="linkAction(6)"><i class="fas fa-graduation-cap fa-lg icon"></i>Thema Management</a></li>
        <li v-bind:class="{ selected: isSelect[7] }"><a href="#" @click.prevent.stop="linkAction(7)"><i class="fas fa-history fa-lg icon"></i>History Management</a></li>
        <li v-bind:class="{ selected: isSelect[8] }"><a href="#" @click.prevent.stop="linkAction(8)"><i class="fas fa-door-open fa-lg icon"></i>Operation Page</a></li>
        <li v-bind:class="{ selected: isSelect[9] }"><a href="#" @click.prevent.stop="linkAction(9)"><i class="fas fa-power-off fa-lg icon"></i>Logout</a></li>
      </ul>
    </div>
  </header>
</template>

<script>
export default {
  data: function(){
    return {
      isSelect: [true, false, false, false, false, false, false, false, false, false],
      adminAnimationFlag: false,
    }
  },
  mounted(){
    var path = this.$route.path;
    if(path === '/items/dashboard'){
      this.isSelect = [true, false, false, false, false, false, false, false, false, false];
    }else if(path === '/items/adminuser') {
      this.isSelect = [false, true, false, false, false, false, false, false, false, false];
    }else if(path === '/items/adminitem') {
      this.isSelect = [false, false, true, false, false, false, false, false, false, false];
    }else if(path === '/items/admincart') {
      this.isSelect = [false, false, false, true, false, false, false, false, false, false];
    }else if(path === '/items/adminnotification') {
      this.isSelect = [false, false, false, false, true, false, false, false, false, false];
    }else if(path === '/items/admintag') {
      this.isSelect = [false, false, false, false, false, true, false, false, false, false];
    }else if(path === '/items/adminthema') {
      this.isSelect = [false, false, false, false, false, false, true, false, false, false];
    }else if(path === '/items/adminhistory') {
      this.isSelect = [false, false, false, false, false, false, false, true, false, false];
    };
  },
  methods: {
    linkAction(num) {
      this.isSelect = [false, false, false, false, false, false, false, false, false, false];
      this.isSelect[num] = true;
      if(num === 0){
        this.$router.push({ name: "admindashboard"}); 
      }else if(num === 1){
        this.$router.push({ name: "adminuser"});
      }else if(num === 2) {
        this.$router.push({ name: "adminitem"}); 
      }else if(num === 3) {
        this.$router.push({ name: "admincart"}); 
      }else if(num === 4) {
        this.$router.push({ name: "adminnotification"}); 
      }else if(num === 5) {
        this.$router.push({ name: "admintag"}); 
      }else if(num === 6) {
        this.$router.push({ name: "adminthema"}); 
      }else if(num === 7) {
        this.$router.push({ name: "adminhistory"}); 
      }else if(num === 8) {
        this.$emit('alert-event', 'operate-page');
      }else if(num === 9) {
        this.$emit('alert-event', 'logout');
      }
    },
  }
}
</script>
