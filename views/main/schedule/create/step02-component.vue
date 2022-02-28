<template>
  <div class="step02">

    <template v-if="type === 'type01'">
      <p class="msg">登校形態を選択してください.</p>
      <div class="table-contena">
        <div class="date-row" v-for="(date, index) in dateArray" :key="index">
          <p class="count">第 {{ index + 1 }} 回</p>
          <p class="date">{{ date }}</p>
          <div class="select-box">
            <select v-model="dayModeArray[index]">
              <option value="1">奇数</option>
              <option value="2">偶数</option>
              <option value="3">全員登校</option>
            </select>
          </div>
        </div>
      </div>
      <ul>
        <li class="link-button second"><a href="" @click.prevent.stop="backStep">戻る</a></li>
        <li class="link-button first"><a href="" @click.prevent.stop="createData">作成</a></li>
      </ul>
    </template>



    <template v-if="type !== 'type01'">
      <p class="msg">すべての実験テーマを入力してください.</p>
      <div class="form-contena">
        <div class="left-contena">
          <div class="form-box">
            <p class="form-name">実験テーマ数</p>
            <div class="select-contena">
              <select id="select" v-model="fields.themaAmount" @change="changeThemaAmount">
                <option v-for="(number, index) in numberArray" :key="index">{{ number }}</option>
              </select>
            </div>
          </div>
          <div class="form-box team">
            <p class="form-name">班構成</p>
            <div class="team-select-box">
              <p><span class="a">A</span><span class="c">〜</span></p>
              <div class="select-contena">
                <select v-model="fields.alphaIndex"  @change="changeTeam">
                  <option v-for="(team, index) in alphaArray" :key="index" :value="index">{{ team }}</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="right-contena">
          <p class="form-name">実験テーマ一覧</p>
          <div class="preview-area">
            <div class="date-row" v-for="(thema, index) in themaArray" :key="index">
              <p class="count">{{ index + 1 }}</p>
              <input type="text" v-model="themaArray[index]">
            </div>
          </div>
        </div>
      </div>
      <ul>
        <li class="link-button second"><a href="" @click.prevent.stop="backStep">戻る</a></li>
        <li class="link-button first" :class="{disabled: themaArray.length === 1}"><a href="" @click.prevent.stop="nextStep">次へ</a></li>
      </ul>
    </template>



  </div>
</template>

<script>
module.exports = {
  props: ['grade', 'type'],
  initData: function(){
    return {
      fields: {
        themaAmount: 1,
        postThemaAmount: 1,
        alphaIndex: 0,
      },
      dateArray: [],
      themaArray: [''],
      numberArray: [...Array(20).keys()].map(i => ++i),
      alphaArray: [...'ABCDEFGHIJKLMNOP'],
      teamArray: [],
      dayModeArray: [],
    }
  },
  data: function() {
    return this.$options.initData();
  },
  methods: {
    resetData: function(){
      Object.assign(this.$data, this.$options.initData());
    },
    step01PassEvent: function(data){
      this.dateArray = data;
      for(let i=0; i < this.dateArray.length; i++){
        this.dayModeArray.push('3');
      }
    },
    changeThemaAmount: function(){
      var amount = this.fields.themaAmount - this.fields.postThemaAmount;
      if(amount >= 0){
        for(var i = 1; i <= amount; i++){
          this.themaArray.push('');
        };
      }else{
        for(var i = 1; i <= -amount; i++){
          this.themaArray.pop();
        };
      }
      this.fields.postThemaAmount = this.fields.themaAmount;
    },
    changeTeam: function(){
      this.teamArray = this.alphaArray.slice(0, this.fields.alphaIndex + 1)
    },
    backStep: function(){
      document.getElementById('step01').classList.remove('complete');
      document.getElementById('step01_check').checked = true;
      document.getElementById('step02_check').checked = false;
    },
    nextStep: function(){
      if(this.themaArray.includes('')){
        this.$emit('message-event', null, null, true);
        setTimeout(() => {
          this.$emit('message-event', '入力してください', false, false);
        }, 300);
      }else{
        if(this.type === 'type02'){
          var length = Math.max(...this.themaArray.map (s => s.length));
        }else if(this.type === 'type03'){
          var length = 2;
        }
        document.getElementById('step02').classList.add('complete');
        this.$emit('pass-event', this.dateArray, this.themaArray, this.teamArray, length);
        document.getElementById('step02_check').checked = false;
        document.getElementById('step03_check').checked = true;
      }
    },
    createData: function(){
      var schedule_json = {
        date: this.dateArray,
        daymode: this.dayModeArray
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
    },
  }
}
</script>