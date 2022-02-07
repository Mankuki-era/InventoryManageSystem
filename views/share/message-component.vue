<template>
  <div class="message" :class="{ animation: fields.animationFlag, success: fields.typeFlag, error: !fields.typeFlag }">
    <p>
      <i v-show="fields.typeFlag" class="fas fa-check-circle fa-lg check-icon"></i>
      <i v-show="!fields.typeFlag" class="fas fa-times-circle fa-lg cross-icon"></i>
      <span>{{ fields.message }}</span>
    </p>
  </div>
</template>

<script>
module.exports = {
  initData: function(){
    return {
      fields: {
        message: '',
        typeFlag: false,
        animationFlag: false
      }
    }
  },
  data: function() {
    return this.$options.initData();
  },
  methods: {
    messageEvent: function(message, bool, initFlag){
      if(initFlag){
        this.fields.animationFlag = false;
      }else{
        this.fields.message = message;
        this.fields.typeFlag = bool;
        this.fields.animationFlag = true;
      }
    },
  }
}
</script>