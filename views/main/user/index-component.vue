<template>
  <div class="main">
    <div class="content-header">
      <h1>学生データ<i class="fas fa-chevron-right chevron-icon"></i><span>一覧</span></h1>
    </div>
    <div class="content user-index">
      <div class="card">
        <div class="card-header">
          <div class="left-box">
            <p class="amount-box">{{ users.length }}件</p>
          </div>
          <div class="right-box">
            <ul>
              <li><a href="" :class="{ disabled: users.length === 0 }" @click.prevent.stop="deleteUsers">削除</a></li>
            </ul>
          </div>
        </div>
        <div class="card-body" v-show="users.length > 0">
          <table>
            <thead>
              <tr>
                <th v-for="(column, index) in columnArray" :key="index">{{ column }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user, index) in filterUsers" :key="index">
                <td>{{ user.team }}</td>
                <td>{{ user.number }}</td>
                <td>{{ user.name }}</td>
              </tr>
            </tbody>
          </table>
          <div class="pagination">
            <a href="#" class="prev" @click.prevent.stop="onPrev"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="next" @click.prevent.stop="onNext"><i class="fas fa-chevron-right"></i></a>
            <p class="total">{{ fields.currentPage }} / {{ fields.totalPage }}</p>
          </div>
        </div>
        <div class="card-body no-data" v-show="users.length === 0">
          <div class="icon-contena">
            <i class="fas fa-fw fa-list"></i>
          </div>
          <p>学生データがありません.</p>
          <p>学生データを登録しましょう.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
module.exports = {
  initData: function(){
    return {
      columnArray: ['班','学籍番号','学生氏名'],
      users: [],
      fields: {
        grade: '',
        currentPage: 1, // 現在のページ番号
        perPage: 10, // 1ページ毎の表示件数
        totalPage: 1, // 総ページ数
      }
    };
  },
  data: function(){
    return this.$options.initData();
  },
  computed: {
    filterUsers(){
      return this.users.slice((this.fields.currentPage - 1) * this.fields.perPage, this.fields.currentPage * this.fields.perPage);
    }
  },
  mounted: function(){
    this.fields.grade = sessionStorage.getItem('grade');
    this.getUsersData();
  },
  methods: {
    resetData: function(){
      Object.assign(this.$data, this.$options.initData());
    },
    getUsersData: function(){
      axios.get(`http://localhost:${port}/backend/controllers/user.php`,{
        params: {
          func: 'index',
          grade: this.fields.grade
        }
      }).then((res) => {
        this.users = res.data;
        this.fields.currentPage = 1;
        this.fields.totalPage = Math.ceil(this.users.length / this.fields.perPage);
      });
    },
    onPrev: function() {
      this.fields.currentPage = Math.max(this.fields.currentPage - 1, 1);
    },
    onNext: function() {
      this.fields.currentPage = Math.min(this.fields.currentPage + 1, this.fields.totalPage);
    },
    deleteUsers: function(){
      if(window.confirm("全データを削除してもよろしいですか？")) {
        // OKが選択された時の処理
        this.$emit('loading-event', true);
        this.$emit('message-event', null, null, true);
        setTimeout(() => {
          axios.post(`http://localhost:${port}/backend/controllers/user.php`,{
            func: 'delete-all',
            grade: this.fields.grade
          }).then((res) => {
            this.$emit('loading-event', false);
            this.$emit('message-event', '学生データの削除が完了しました.', true, false);
            this.resetData();
            this.fields.grade = sessionStorage.getItem('grade');
          });
        }, 2000);
      }
    }
  }
}
</script>