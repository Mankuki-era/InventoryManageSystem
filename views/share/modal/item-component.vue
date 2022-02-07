<template>
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
      <li><a href="" :class="{disabled: form.name === '' || form.stock_amount === '' || !fields.changeFlag}" @click.prevent.stop="updateData">更新</a></li>
      <li><a href="" class="delete" @click.prevent.stop="deleteData">削除</a></li>
    </ul>
  </form>
</template>

<script>
module.exports = {
  props: ['id', 'index'],
  initData: function(){
    return {
      fields: {
        changeFlag: false,
      },
      form: {},
      originForm: {}
    };
  },
  data: function() {
    return this.$options.initData();
  },
  mounted: function(){
    this.getItemData();
  },
  methods: {
    resetData: function(){
      Object.assign(this.$data, this.$options.initData());
    },
    getItemData: function(){
      axios.get(`http://localhost:${port}/backend/controllers/item.php`,{
        params: {
          func: 'show',
          id: this.id
        }
      }).then((res) => {
        if(res.data){
          this.form = JSON.parse(JSON.stringify(res.data)); // formとoriginFormで同期を切り離す
          this.originForm = JSON.parse(JSON.stringify(res.data));
          // watchでformを監視
          this.$watch('form', function() {
            this.fields.changeFlag = JSON.stringify(this.form) !== JSON.stringify(this.originForm); // 連想配列の比較
          },{
            immediate: false,
            deep: true
          });
        }
      });
    },
    updateData: function(){
      this.$emit('loading-event', true);
      this.$emit('message-event', null, null, true);
      setTimeout(() => {
        axios.post(`http://localhost:${port}/backend/controllers/item.php`,{
          func: 'update',
          id: this.id,
          data: this.form
        }).then((res) => {
          console.log('更新完了');
          this.$emit('data-change', this.index, this.form);
          this.$emit('loading-event', false);
          this.$emit('close-modal');
          this.$emit('message-event', '更新が完了しました.', true, false);
        });
      }, 2000);
    },
    deleteData: function(){
      if(window.confirm("本当に削除してもよろしいですか？")) {
        // OKが選択された時の処理
        this.$emit('loading-event', true);
        this.$emit('message-event', null, null, true);
        setTimeout(() => {
          axios.post(`http://localhost:${port}/backend/controllers/item.php`,{
            func: 'delete',
            id: this.id,
          }).then((res) => {
            console.log('削除完了');
            this.$emit('data-change', this.index, null);
            this.$emit('loading-event', false);
            this.$emit('close-modal');
            this.$emit('message-event', '削除が完了しました.', true, false);
          });
        }, 2000);
      }
    }
  }
}
</script>