<template>
  <div class="adminLoadingContena">
    <div class="adminMain-loader" v-bind:class="{hidden: hideFlag, none: noneFlag}">
      <div class="adminMain-loading"></div>
    </div>
    <div class="adminMain-mask" v-bind:class="{hidden: hideFlag, none: noneFlag}"></div>
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
      }, 500);
    },
  }
}
</script>