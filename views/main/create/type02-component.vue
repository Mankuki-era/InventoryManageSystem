<template>
  <div class="type02-contena">
    <form>
      <div class="form-group">
        <label for="name">製品名<span>必須</span></label>
        <input type="text" class="form-control" id="name" v-model="form.name">
      </div>
      <div class="form-group">
        <label for="url">URL</label>
        <input type="text" class="form-control" id="url" v-model="form.url">
      </div>
      <div class="form-group-row">
        <div class="form-group">
          <label for="require_amount">必要数</label>
          <input type="text" class="form-control" id="require_amount" v-model="form.require_amount">
        </div>
        <div class="form-group">
          <label for="stock_amount">在庫数<span>必須</span></label>
          <input type="text" class="form-control" id="stock_amount" v-model="form.stock_amount">
        </div>
      </div>
      <div class="form-group">
        <label for="category">カテゴリー</label>
        <input type="text" class="form-control" id="category" v-model="form.category">
      </div>
      <ul class="button-box">
        <li><a href="" :class="{disabled: form.name === '' || form.stock_amount === ''}" @click.prevent.stop="createData">追加</a></li>
      </ul>
    </form>
  </div>
</template>

<script>
module.exports = {
  initData: function(){
    return {
      form: {
        name: '',
        url: '',
        require_amount: '',
        stock_amount: '',
        category: '',
        favorite: 0,
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
    createData: function(){
      this.$emit('loading-event', true);
      this.$emit('message-event', null, null, true);
      setTimeout(() => {
        axios.post(`http://localhost:${port}/backend/controllers/item.php`,{
          func: 'create-type02',
          data: this.form
        }).then((res) => {
          console.log('作成完了');
          this.resetData();
          this.$emit('loading-event', false);
          this.$emit('message-event', '登録が完了しました.', true, false);
        });
      }, 2000);
    },
  }
}
</script>