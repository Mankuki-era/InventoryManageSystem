<template>
  <div class="main">
    <div class="content-header">
      <h1>スケジュールデータ<i class="fas fa-chevron-right chevron-icon"></i><span>一覧</span></h1>
    </div>
    <div class="content schedule-index">
      <div class="card">
        <div class="card-header">
          <div class="left-box"></div>
          <div class="right-box">
            <ul>
              <li><a href="" :class="{ disabled: !tableArray01.length }" @click.prevent.stop="deleteSchedule">削除</a></li>
            </ul>
          </div>
        </div>
        <div class="card-body" v-show="tableArray01.length">
          <!-- type01 -->
          <table v-if="fields.scheduleType === 'type01'" class="type01">
            <thead>
              <tr>
                <th></th>
                <th class="team-name">登校形態</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(date, index) in dateArray" :key="index">
                <th>{{ date }}</th>
                <td>{{ setDayMode(dayModeArray[index]) }}</td>
              </tr>
            </tbody>
          </table>
          <!-- type02 -->
          <table v-if="fields.scheduleType === 'type02'" class="type02">
            <thead>
              <tr>
                <th></th>
                <th class="thema-name" :style="{ height: fields.tableHeadHeight }" v-for="(thema, index) in themaArray" :key="index">{{ thema }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(date, index1) in dateArray" :key="index1">
                <th>{{ date }}</th>
                <td v-for="(thema, index2) in themaArray" :key="index2">{{ tableArray01[index1][index2] }}</td>
              </tr>
            </tbody>
          </table>
          <!-- type03 -->
          <table v-if="fields.scheduleType === 'type03'" class="type03">
            <thead>
              <tr>
                <th></th>
                <th class="team-name" :style="{ height: fields.tableHeadHeight }" v-for="(team, index) in teamArray" :key="index">{{ team }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(date, index1) in dateArray" :key="index1">
                <th>{{ date }}</th>
                <td v-for="(team, index2) in teamArray" :key="index2">{{ tableArray02[index1][index2] }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-body no-data" v-show="!tableArray01.length">
          <div class="icon-contena">
            <i class="fas fa-fw fa-list"></i>
          </div>
          <p>スケジュールがありません.</p>
          <p>スケジュールを登録しましょう.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
module.exports = {
  initData: function(){
    return {
      fields: {
        grade: '',
        scheduleType: '',
        tableHeadHeight: '0',
      },
      dateArray: [],
      themaArray: [],
      teamArray: [],
      tableArray01: [],
      tableArray02: [],
    }
  },
  data: function() {
    return this.$options.initData();
  },
  mounted() {
    this.mountedEvent();
  },
  methods: {
    mountedEvent: function(){
      this.fields.grade = sessionStorage.getItem('grade');
      this.fields.scheduleType = gradeArray[this.fields.grade].schedule;
      this.getData();
    },
    resetData: function(){
      Object.assign(this.$data, this.$options.initData());
      this.mountedEvent();
    },
    getData: function(){
      axios.get(`http://localhost:${port}/backend/controllers/schedule.php`,{
        params: {
          grade: this.fields.grade
        }
      }).then((res) => {
        if(res.data){
          var data = JSON.parse(res.data.table_json);
          this.dateArray = data.date;
          this.themaArray = data.thema;
          this.teamArray = data.team;
          this.tableArray01 = data.table;
          this.dayModeArray = data.daymode;
          if(this.fields.scheduleType === 'type02'){
            var length = Math.max(...this.themaArray.map (s => s.length));
            this.fields.tableHeadHeight = `${ length * 1 }rem`;
          }
          if(this.fields.scheduleType === 'type03'){
            this.fields.tableHeadHeight = '2rem';
            for(var i = 0; i < this.dateArray.length; i++){
              this.tableArray02.push([]);
              for(var j = 0; j < this.teamArray.length; j++){
                this.tableArray02[i].push('');
              }
            }
            array = [] // [[0, 4, 1], ...] [[日付のインデックス, 班のインデックス, テーマのインデックス], ...]
            this.tableArray01.forEach((val1, index1) => {
              val1.forEach((val2, index2) => {
                if(val2 !== ''){
                  this.teamArray.forEach((val3, index3) => {
                    if(val2 === val3){
                      array.push([index1, index3, index2])
                    }
                  });
                }
              });
            });
            array.forEach(val => {
              this.tableArray02[val[0]][val[1]] = this.themaArray[val[2]]
            });
          }
        }
      });
    },
    setDayMode: function(number){
      if(number === '1'){
        return '奇数';
      }else if(number === '2'){
        return '偶数';
      }else if(number === '3'){
        return '全員登校';
      };
    },
    deleteSchedule: function(){
      if(window.confirm("スケジュールを削除してもよろしいですか？")) {
        // OKが選択された時の処理
        this.$emit('loading-event', true);
        this.$emit('message-event', null, null, true);
        setTimeout(() => {
          axios.post(`http://localhost:${port}/backend/controllers/schedule.php`,{
            func: 'delete',
            grade: this.fields.grade
          }).then((res) => {
            this.$emit('loading-event', false);
            this.$emit('message-event', 'スケジュールの削除が完了しました.', true, false);
            this.resetData();
          });
        }, 2000);
      }
    },
  }
}
</script>