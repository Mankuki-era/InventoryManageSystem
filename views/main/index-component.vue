<template>
  <div class="main">
    <div class="content-header">
      <h1>一覧<i class="fas fa-chevron-right chevron-icon"></i><span>{{ indexType }}</span></h1>
    </div>
    <div class="content index">
      <div class="card">
        <div class="card-header">
          <div class="left-box">
            <p class="amount-box">{{ items.length }}件</p>
          </div>
          <div class="right-box">
            <div class="search-box">
              <input type="text" placeholder="製品名およびカテゴリー" v-model="keyword">
              <i class="fas fa-search search-icon"></i>
            </div>
            <ul>
              <li><a href="" :class="{ disabled: items.length === 0 }" @click.prevent.stop="deleteItems">削除</a></li>
            </ul>
          </div>
        </div>
        <div class="card-body" v-show="items.length > 0">
          <table>
            <thead>
              <tr>
                <th></th>
                <th v-for="(column, index) in columnArray" :key="index">{{ column }}</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in filterItems" :key="item.id">
                <td class="favorite">
                  <i class="far fa-star fa-lg star-icon" v-show="item.favorite === '0'" @click="favoriteEvent(item.id, item.favorite, index)"></i>
                  <i class="fas fa-star fa-lg star-icon check" v-show="item.favorite === '1'" @click="favoriteEvent(item.id, item.favorite, index)"></i>
                </td>
                <td class="name">{{ item.name }}</td>
                <td>{{ item.require_amount }}</td>
                <td>{{ item.stock_amount }}</td>
                <td>{{ formatDate(item.updated_at) }}</td>
                <td><i class="fas fa-ellipsis-h fa-lg ellipsis-icon" @click="openModal('item-update', item.id, index)"></i></td>
              </tr>
            </tbody>
          </table>
          <div class="pagination">
            <a href="#" class="prev" @click.prevent.stop="onPrev"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="next" @click.prevent.stop="onNext"><i class="fas fa-chevron-right"></i></a>
            <p class="total">{{ currentPage }} / {{ totalPage }}</p>
          </div>
        </div>
        <div class="card-body no-data" v-show="items.length === 0">
          <div class="icon-contena">
            <i class="fas fa-fw fa-list"></i>
          </div>
          <p>製品データがありません.</p>
          <p>製品データを登録しましょう.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
module.exports = {
  initData: function(){
    return {
      indexType: '',
      keyword: '',
      columnArray: ['製品名','必要数','在庫数','更新日'],
      items: [],
      currentPage: 1, // 現在のページ番号
      perPage: 10, // 1ページ毎の表示件数
      totalPage: 1, // 総ページ数
      mountFlag: true
    };
  },
  data: function(){
    return this.$options.initData();
  },
  computed: {
    filterItems(){
      return this.items.slice((this.currentPage - 1) * this.perPage, this.currentPage * this.perPage);
    }
  },
  mounted: function(){
    this.indexType = sessionStorage.getItem('indexType');
    this.getItemsData();
  },
  methods: {
    resetData: function(){
      Object.assign(this.$data, this.$options.initData());
    },
    getItemsData: function(){
      axios.get(`http://localhost:${port}/backend/controllers/item.php`,{
        params: {
          func: 'index',
          indexType: this.indexType === 'すべて' ? '' : this.indexType,
          keyword: this.keyword
        }
      }).then((res) => {
        if(res.data.length > 0){
          this.items = res.data;
          this.currentPage = 1;
          this.totalPage = Math.ceil(this.items.length / this.perPage);
          if(this.mountFlag){ // mountのときだけ
            this.mountFlag = false;
            // watchでformを監視
            this.$watch('keyword', function() {
              axios.get(`http://localhost:${port}/backend/controllers/item.php`,{
                params: {
                  func: 'index',
                  indexType: this.indexType === 'すべて' ? '' : this.indexType,
                  keyword: this.keyword
                }
              }).then((res) => {
                this.items = res.data;
                this.currentPage = 1;
                this.totalPage = Math.ceil(this.items.length / this.perPage);
              });
            },{
              immediate: false,
              deep: true
            });
          }
        };
      });
    },
    favoriteEvent: function(id, favorite, index){
      favorite = favorite === '0' ? '1' : '0';
      axios.post(`http://localhost:${port}/backend/controllers/item.php`,{
        func: 'update-favorite',
        id: id,
        favorite: favorite
      }).then((res) => {
        console.log('favorite更新完了');
        this.items[(this.currentPage - 1) * this.perPage + index].favorite = favorite;
      });
    },
    formatDate: function(date){ // 2021-02-07 10:20:00
      date = date.split(' ');
      return `${date[0].slice(0,4)}年${date[0].slice(5,7)}月${date[0].slice(8,10)}日`;
    },
    onPrev: function() {
      this.currentPage = Math.max(this.currentPage - 1, 1);
    },
    onNext: function() {
      this.currentPage = Math.min(this.currentPage + 1, this.totalPage);
    },
    openModal: function(func, id, index){
      this.$emit('open-modal', func, id, index);
    },
    indexTypeClick: function(){
      this.indexType = sessionStorage.getItem('indexType');
      this.keyword = '';
      this.getItemsData();
    },
    dataChange: function(index, data){ // modalでの変更、削除を反映   配列は$set, $delete使わないと反映されない
      if(data){ // 変更
        this.$set(this.items, (this.currentPage - 1) * this.perPage + index, data);
      }else{ // 削除
        this.$delete(this.items, (this.currentPage - 1) * this.perPage + index);
      }
    },
    deleteItems: function(){
      if(window.confirm("全データを削除してもよろしいですか？")) {
        // OKが選択された時の処理
        this.$emit('loading-event', true);
        this.$emit('message-event', null, null, true);
        setTimeout(() => {
          axios.post(`http://localhost:${port}/backend/controllers/item.php`,{
            func: 'delete-all',
          }).then((res) => {
            console.log('削除完了');
            this.$emit('loading-event', false);
            this.$emit('message-event', '削除が完了しました.', true, false);
            this.resetData();
          });
        }, 2000);
      }
    }
  }
}
</script>