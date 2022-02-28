<template>
  <div class="main">
    <div class="content-header">
      <h1>接続</h1>
    </div>
    <div class="content connect">
      <div class="card">
        <div class="card-header">
          <div class="left-box">
            <p class="amount-box">{{ logs.length }}件</p>
          </div>
          <div class="right-box">
            <ul>
              <li><a href="" :class="{ disabled: fields.connectFlag }" @click.prevent.stop="connectClick(true)">接続</a></li>
              <li><a href="" :class="{ disabled: !fields.connectFlag }" @click.prevent.stop="connectClick(false)">接続解除</a></li>
            </ul>
          </div>
        </div>
        <div class="card-body" v-show="logs.length > 0">
          <table>
            <thead>
              <tr>
                <th v-for="(column, index) in columnArray" :key="index">{{ column }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="log in filterLogs" :key="log.id">
                <td>{{ log.grade }}</td>
                <td>{{ log.number }}</td>
                <td v-show="log.temperature">{{ log.temperature }}℃</td>
                <td v-show="!log.temperature">ー</td>
                <td>{{ log.created_at }}</td>
              </tr>
            </tbody>
          </table>
          <div class="pagination">
            <a href="#" class="prev" @click.prevent.stop="onPrev"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="next" @click.prevent.stop="onNext"><i class="fas fa-chevron-right"></i></a>
            <p class="total">{{ fields.currentPage }} / {{ fields.totalPage }}</p>
          </div>
        </div>
        <div class="card-body no-data" v-show="logs.length === 0">
          <div class="icon-contena">
            <i class="fas fa-link"></i>
          </div>
          <p>接続していません。</p>
          <p>RaspberryPiと接続して、出席状況を監視しましょう。</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
module.exports = {
  initData: function(){
    return {
      columnArray: ['学年','学籍番号','体温','入室時間'],
      logs: [],
      fields: {
        grade: '',
        connectFlag: false,
        timer: null,
        currentPage: 1, // 現在のページ番号
        perPage: 10, // 1ページ毎の表示件数
        totalPage: 1, // 総ページ数
      },
    };
  },
  data: function() {
    return this.$options.initData();
  },
  computed: {
    filterLogs(){
      return this.logs.slice((this.fields.currentPage - 1) * this.fields.perPage, this.fields.currentPage * this.fields.perPage);
    }
  },
  mounted: function(){
    this.fields.grade = sessionStorage.getItem('grade');
    this.fields.connectFlag = JSON.parse(sessionStorage.getItem('connectFlag').toLowerCase());
    this.getLogs();
    this.pollingAction();
  },
  methods: {
    resetData: function(){
      Object.assign(this.$data, this.$options.initData());
    },
    getLogs: function(){
      axios.get(`http://localhost:${port}/backend/controllers/log.php`, {
        params: {
          func: 'index',
          grade: this.fields.grade
        }
      }).then((res) => {
        this.logs = res.data;
      });
    },
    connectClick: function(bool){
      this.$emit('loading-event', true);
      this.messageEvent(bool, true);
      sessionStorage.setItem('connectFlag', bool);
      setTimeout(() => {
        this.fields.connectFlag = bool;
        this.$emit('loading-event', false);
        this.messageEvent(bool, false);
        this.pollingAction();
      }, 2000);
    },
    messageEvent: function(bool, initFlag){
      var message = bool ? '接続を開始しました.' : '接続を終了しました.';
      this.$emit('message-event', message, true, initFlag);
    },
    pollingAction: function(){
      if(this.fields.connectFlag){
        this.fields.timer = setInterval(() => {
          this.getLogs();
        }, 5000);
      }else{
        clearInterval(this.fields.timer);
      }
    },
    onPrev: function() {
      this.fields.currentPage = Math.max(this.fields.currentPage - 1, 1);
    },
    onNext: function() {
      this.fields.currentPage = Math.min(this.fields.currentPage + 1, this.fields.totalPage);
    },
  }
}
</script>