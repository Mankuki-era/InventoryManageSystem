<template>
  <div class="alert-contena" v-bind:class="{none: noneFlag}">
    <div class="alert-main" v-bind:class="{show: showFlag, none: noneFlag, hide: hideFlag}">
      <div class="alert-contena-logo"><i class="fas fa-exclamation alert-contena-icon"></i></div>
      <p class="alert-message">{{ message }}</p>
      <div class="buttons">
        <li class="back-button"><a href="#" @click.prevent.stop="cancelLink">Cancel</a></li>
        <li class="ok-button"><a href="#" @click.prevent.stop="okLink">OK</a></li>
      </div>
    </div>
    <div class="alert-mask"></div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      showFlag: false,
      noneFlag: true,
      hideFlag: false,
      message: '',
      action_name: '',
    }
  },
  methods: {
    alertShowMethod: function(action_name){
      this.action_name = action_name;
      if(this.action_name === 'operate-page'){
        this.message = '管理者ページを退出しますか?';
      }else if(this.action_name === 'logout'){
        this.message = 'ログアウトしてもよろしいでしょうか?';
      }
      this.hideFlag = false;
      this.noneFlag = false;
      setTimeout(() => {
        this.showFlag = true;
      }, 300);
    },
    cancelLink: function(){
      this.showFlag = false;
      this.hideFlag = true;
      setTimeout(() => {
        this.noneFlag = true;
      }, 300);
    },
    okLink: function(){
      if(this.action_name === 'operate-page'){
        axios.post('/api/resetInfo').then(e => {
          this.$router.push({ name: "index" });
          this.showFlag = false;
          this.hideFlag = false;
          this.noneFlag = true;
        }).catch((error) => {
          console.log(error);
        });
      }else if(this.action_name === 'logout'){
        axios.post('/api/resetInfo').then(e => {
          axios.post('/api/logout').then(e => {
            this.$emit('message-event', e.data.message, true);
            this.$router.push({ name: "login"});
            this.showFlag = false;
            this.hideFlag = false;
            this.noneFlag = true;
          }).catch((error) => {
            console.log(error);
          });
        }).catch((error) => {
          console.log(error);
        });
      }
    }
  }
}
</script>