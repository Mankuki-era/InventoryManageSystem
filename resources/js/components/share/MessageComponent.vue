<template>
  <div>
    <div class="message flash_message" v-bind:class="{ animation: bool }" v-show="flag"><i class="fas fa-check fa-lg icon"></i> {{ message }}</div>
    <div class="message error_message" v-bind:class="{ animation: !bool }" v-show="flag"><i class="fas fa-times fa-lg icon"></i> {{ message }}</div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      bool: false,
      message: '',
      flag: false,
    }
  },
  methods: {
    setMessage(message, bool){
      this.flag = false;
      setTimeout(() => {
        this.flag = true;
        this.message = message;
        this.bool = bool;
      }, 300);
      setTimeout(() => {
        this.flag = false;
      }, 4000);
    }
  }
}
</script>