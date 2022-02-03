<template>
  <footer class="page_footer" id="footer" v-bind:class="{ inventoryPage: inventoryFlag }">(c) 2021 Kenshin Sasaki, Riku hiruta.</footer>
</template>

<script>
export default {
  data: function() {
    return {
      inventoryFlag: false,
    }
  },
  mounted() {
    axios.get('/api/info').then(e => {
      if(e.data.link_name === 'inventory'){
        this.inventoryFlag = true;
      }
    }).catch((error) => {
      console.log(error);
    });
  },
  methods: {
    colorChangeMethod(linkName) {
      if(linkName === 'inventory'){
        this.inventoryFlag = true;
      }else{
        this.inventoryFlag = false;
      }
    }
  }
}
</script>