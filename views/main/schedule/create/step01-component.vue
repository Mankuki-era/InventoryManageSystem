<template>
  <div class="step01">
    <p class="msg">実験が行われるすべての日付を入力してください.</p>
    <div class="form-contena">
      <div class="left-contena">
        <div class="form-box">
          <p class="form-name">第１回実験日</p>
          <label class="date-edit"><input type="date" value="2019-08-22" v-model="fields.startDate" @change="changeStartDate"></label>
        </div>
        <div class="form-box">
          <p class="form-name">実験実施回数</p>
          <div class="select-contena">
            <select id="select" v-model="fields.dateAmount" @change="changeDateAmount">
              <option v-for="(number, index) in numberArray" :key="index">{{ number }}</option>
            </select>
          </div>
        </div>
      </div>
      <div class="right-contena">
        <p class="form-name">実験日一覧</p>
        <div class="preview-area">
          <div class="date-row" v-for="(date, index) in dateArray" :key="index">
            <p class="count">第 {{ index + 1 }} 回</p>
            <label class="date-edit first" v-show="index === 0"><input type="date" :value="date" disabled></label>
            <label class="date-edit" v-show="index !== 0"><input type="date" v-model="dateArray[index]"></label>
            <li class="auto-fill">
              <a href="" v-show="date !== '' && dateArray.length > 1" @click.prevent.stop="autoCreateDate(index)"><i class="fas fa-arrow-alt-circle-down autofill-icon"></i></a>
            </li>
          </div>
        </div>
      </div>
    </div>
    <ul>
      <li class="link-button first" :class="{disabled: dateArray.length === 1}"><a href="" @click.prevent.stop="nextStep">次へ</a></li>
    </ul>
  </div>
</template>

<script>
module.exports = {
  initData: function(){
    return {
      fields: {
        startDate: '',
        dateAmount: '1',
        postDateAmount: 1,
      },
      dateArray: [],
      numberArray: [...Array(20).keys()].map(i => ++i),
    }
  },
  data: function() {
    return this.$options.initData();
  },
  mounted: function(){
    this.setStartDate();
  },
  methods: {
    resetData: function(){
      Object.assign(this.$data, this.$options.initData());
      this.setStartDate();
    },
    setStartDate: function(){
      this.fields.startDate = this.getDate(new Date());;
      this.dateArray = [this.fields.startDate];
    },
    getDate: function(date){
      var toDoubleDigits = function(num) {
        num += "";
        if (num.length === 1) {
          num = "0" + num;
        }
      return num;     
      };
      var year = date.getFullYear();
      var month = toDoubleDigits(date.getMonth() + 1);
      var day = toDoubleDigits(date.getDate());
      return String(year) + "-" + String(month) + "-" + String(day);
    },
    changeStartDate: function(){
      this.dateArray = [this.fields.startDate];
      for(var i = 1; i < this.fields.dateAmount; i++){
        this.dateArray.push('');
      };
    },
    changeDateAmount: function(){
      var amount = Number(this.fields.dateAmount) - this.fields.postDateAmount;
      if(amount >= 0){
        for(var i = 1; i <= amount; i++){
          this.dateArray.push('');
        };
      }else{
        for(var i = 1; i <= -amount; i++){
          this.dateArray.pop();
        };
      }
      this.fields.postDateAmount = Number(this.fields.dateAmount);
    },
    autoCreateDate: function(index){
      var date = new Date(this.dateArray[index]);
      for(var i = index + 1; i < this.dateArray.length; i++){
        date.setDate(date.getDate() + 7);
        this.dateArray.splice(i, 1, this.getDate(date));
      };
    },
    nextStep: function(){
      if(this.dateArray.includes('')){
        this.$emit('message-event', null, null, true);
        setTimeout(() => {
          this.$emit('message-event', '入力してください', false, false);
        }, 300);
      }else{
        this.$emit('pass-event', this.dateArray);
        document.getElementById('step01').classList.add('complete');
        document.getElementById('step01_check').checked = false;
        document.getElementById('step02_check').checked = true;
      }
    }
  }
}
</script>