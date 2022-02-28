<template>
  <div class="step03">
    <div class="table-contena">
      <table v-if="type === 'type02'">
        <thead>
          <tr>
            <th></th>
            <th class="thema-name" :style="{ height: fields.tableHeadHeight }" v-for="(thema, index) in themaArray" :key="index">{{ thema }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(date, index1) in dateArray" :key="index1">
            <th>{{ date }}</th>
            <td v-for="(thema, index2) in themaArray" :key="index2">
              <select v-model="tableArray01[index1][index2]">
                <option></option>
                <option :value="team" v-for="(team, index3) in teamArray" :key="index3">{{ team }}</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
      <table v-if="type === 'type03'">
        <thead>
          <tr>
            <th></th>
            <th class="team-name" :style="{ height: fields.tableHeadHeight }" v-for="(team, index) in teamArray" :key="index">{{ team }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(date, index1) in dateArray" :key="index1">
            <th>{{ date }}</th>
            <td v-for="(team, index2) in teamArray" :key="index2">
              <select v-model="tableArray02[index1][index2]">
                <option></option>
                <option :value="thema" v-for="(thema, index3) in themaArray" :key="index3">{{ thema }}</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <ul>
      <li class="link-button second"><a href="" @click.prevent.stop="backStep">戻る</a></li>
      <li class="link-button first"><a href="" @click.prevent.stop="createData">作成</a></li>
    </ul>
  </div>
</template>

<script>
module.exports = {
  props: ['grade', 'type'],
  initData: function(){
    return {
      fields: {
        tableHeadHeight: '0'
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
  methods: {
    resetData: function(){
      Object.assign(this.$data, this.$options.initData());
    },
    step02PassEvent: function(data1, data2, data3, length){
      this.dateArray = data1;
      this.themaArray = data2;
      this.teamArray = data3;
      this.fields.tableHeadHeight = `${ 1 * length }rem`;
      for(let i = 0; i < this.dateArray.length; i++){
        this.tableArray01.push([]);
        this.tableArray02.push([]);
        for(let j = 0; j < this.themaArray.length; j++){
          this.tableArray01[i].push('');
        }
        for(let j = 0; j < this.teamArray.length; j++){
          this.tableArray02[i].push('');
        }
      }
    },
    backStep: function(){
      this.$emit('height-change');
      document.getElementById('step02').classList.remove('complete');
      document.getElementById('step02_check').checked = true;
      document.getElementById('step03_check').checked = false;
    },
    createData: function(){
      var flag = false;
      if(this.type === 'type02'){
        var table_array = this.tableArray01;
      }else if(this.type === 'type03'){
        var table_array = this.tableArray02;
      }
      table_array.forEach(val => {
        var result = val.some( function(value) {
          return value !== '';
        });
        if(!flag){
          flag = result;
        }
      });
      if(flag){
        if(this.type === 'type03'){ // tableArray02の形を変更する
          array = [] // [[0, 4, 1], ...] [[日付のインデックス, テーマのインデックス, 班のインデックス], ...]
          this.tableArray02.forEach((val1, index1) => {
            val1.forEach((val2, index2) => {
              if(val2 !== ''){
                this.themaArray.forEach((val3, index3) => {
                  if(val2 === val3){
                    array.push([index1, index3, index2])
                  }
                });
              }
            });
          });
          array.forEach(val => {
            this.tableArray01[val[0]][val[1]] = this.teamArray[val[2]]
          });
        }
        var schedule_json = {
          date: this.dateArray, // tableの行数に対応
          thema: this.themaArray, // tableの列数に対応
          team: this.teamArray, // tableの列数に対応するかも
          table: this.tableArray01 // ['', 'A', 'B', '', '', 'D']のような形
        };
        this.$emit('loading-event', true);
        this.$emit('message-event', null, null, true);
        setTimeout(() => {
          axios.post(`http://localhost:${port}/backend/controllers/schedule.php`,{
            func: 'create',
            grade: this.grade,
            schedule_json: schedule_json
          }).then((res) => {
            this.$emit('reset-event');
            this.$emit('message-event', 'スケジュールを登録しました.', true, false);
            this.$emit('loading-event', false);
          });
        }, 2000);
      }else{
        this.$emit('message-event', null, null, true);
        setTimeout(() => {
          this.$emit('message-event', '入力してください', false, false);
        }, 300);
      }
    },
  }
}
</script>