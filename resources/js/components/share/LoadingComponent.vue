<template>
  <div class="loader" v-bind:class="{hidden: hideFlag, none: noneFlag}">
    <div class="loading"></div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      hideFlag: false,
      noneFlag: true
    }
  },
  methods: {
    loadingStart: function(){
      this.hideFlag = false;
      this.noneFlag = false;
    },
    loadingStop: function(){
      this.hideFlag = true;
      setTimeout(() => {
        this.noneFlag = true;
        this.hideFlag = false;
      }, 1000);
    },
  }
}
</script>