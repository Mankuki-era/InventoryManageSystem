<template>
  <section class="modal-area" :class="{show: fields.showFlag, hide: fields.hideFlag}">
    <div class="modal-mask" @click="closeModal"></div>
    <div class="modal-contena">
      <div class="modal-header"></div>
      <loading-component ref="loadingChild"></loading-component>
      <div class="modal-box">
        <item-component v-if="fields.func === 'item-update'" :id="fields.id" :index="fields.index" @data-change="dataChange" @loading-event="loadingEvent" @close-modal="closeModal" @message-event="messageEvent"></item-component>
      </div>
      <div class="close-modal" @click="closeModal">×</div>
    </div>
  </section>
</template>

<script>
module.exports = {
  initData: function(){
    return {
      fields: {
        id: null,
        index: null,
        func: null,
        showFlag: false,
        hideFlag: false,
      },
    };
  },
  data: function() {
    return this.$options.initData();
  },
  methods: {
    resetData: function(){
      Object.assign(this.$data, this.$options.initData());
    },
    openModal: function(func, id, index){
      this.fields.func = func;
      this.fields.id = id;
      this.fields.index = index;
      this.fields.hideFlag = false;
      this.fields.showFlag = true;
    },
    closeModal: function(){
      this.fields.showFlag = false;
      this.fields.hideFlag = true;
      setTimeout(() => {
        this.fields.hideFlag = false;
        this.resetData();
      }, 300);
    },
    dataChange: function(index, data){
      this.$emit('data-change', index, data);
    },
    loadingEvent: function(bool){
      this.$refs.loadingChild.loadingEvent(bool);
    },
    messageEvent: function(message, bool, initFlag){
      this.$emit('message-event', message, bool, initFlag);
    }
  }
}
</script>