<template>
  <main>
    <div class="header">
      <ul>
        <li><a href="javascript:void(0)" id="bar"><i class="fas fa-bars"></i></a></li>
      </ul>
      <p>管理者</p>
    </div>
    <loading-component ref="loadingChild"></loading-component>
    <router-view ref="routerChild" @loading-event="loadingEvent" @open-modal="openModal" @message-event="messageEvent"></router-view>
  </main>
</template>

<script>
module.exports = {
  methods: {
    loadingEvent: function(bool){
      this.$refs.loadingChild.loadingEvent(bool);
    },
    openModal: function(func, id, index){
      this.$emit('open-modal', func, id, index);
    },
    indexTypeClick: function(){
      this.$refs.routerChild.indexTypeClick();
    },
    dataChange: function(index, data){
      this.$refs.routerChild.dataChange(index, data);
    },
    messageEvent: function(message, bool, initFlag){
      this.$emit('message-event', message, bool, initFlag);
    }
  }
}
</script>