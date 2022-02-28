<template>
  <div class="main">
    <div class="content-header">
      <h1>スケジュールデータ<i class="fas fa-chevron-right chevron-icon"></i><span>登録</span></h1>
    </div>
    <div class="content schedule-create">
      <div class="card">
        <div id="step01" class="card-header step01">
          <span><i class="fas fa-plus-square fa-lg plus-square-icon"></i>STEP1</span>
        </div>
        <input type="checkbox" id="step01_check" checked />
        <div class="card-body">
          <step01-component ref="firstChild" @message-event="messageEvent" @pass-event="step01PassEvent"></step01-component>
        </div>
      </div>
      <div class="card">
        <div id="step02" class="card-header step02">
          <span><i class="fas fa-plus-square fa-lg plus-square-icon"></i>STEP2</span>
        </div>
        <input type="checkbox" id="step02_check" />
        <div class="card-body">
          <step02-component :grade="fields.grade" :type="fields.scheduleType" ref="secondChild" @loading-event="loadingEvent" @message-event="messageEvent" @pass-event="step02PassEvent" @reset-event="resetEvent(1)"></step02-component>
        </div>
      </div>
      <div class="card" v-if="fields.scheduleType !== 'type01'">
        <div id="step03" class="card-header step03">
          <span><i class="fas fa-plus-square fa-lg plus-square-icon"></i>STEP3</span>
        </div>
        <input type="checkbox" id="step03_check" />
        <div class="card-body" :style="{ height: fields.step03Height }">
          <step03-component :grade="fields.grade" :type="fields.scheduleType" ref="thirdChild" @loading-event="loadingEvent" @message-event="messageEvent" @height-change="step03HeightChangeEvnet" @reset-event="resetEvent(2)"></step03-component>
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
        step03Height: '0'
      },
    }
  },
  data: function() {
    return this.$options.initData();
  },
  mounted() {
    this.fields.grade = sessionStorage.getItem('grade');
    this.fields.scheduleType = gradeArray[this.fields.grade].schedule;
    $(function(){
      $(window).on('beforeunload', function() {
        return '入力が完了していません.このまま移動しますか？';
      });
    });
  },
  methods: {
    step01PassEvent: function(data){
      this.$refs.secondChild.step01PassEvent(data);
    },
    step02PassEvent: function(data1, data2, data3, length){
      this.fields.step03Height = `${ 1 * length + data1.length * 1.8 + 5 }rem`;
      this.$refs.thirdChild.step02PassEvent(data1, data2, data3, length);
    },
    step03HeightChangeEvnet: function(){
      this.fields.step03Height = '0';
    },
    loadingEvent: function(bool){
      this.$emit('loading-event', bool);
    },
    messageEvent: function(message, bool, initFlag){
      this.$emit('message-event', message, bool, initFlag);
    },
    resetEvent: function(num){
      this.$refs.firstChild.resetData();
      this.$refs.secondChild.resetData();
      document.getElementById('step01').classList.remove('complete');
      if(num === 1){
        document.getElementById('step02_check').checked = false;
      }else if(num === 2){
        this.$refs.thirdChild.resetData();
        document.getElementById('step02').classList.remove('complete');
        document.getElementById('step03_check').checked = false;
        this.step03HeightChangeEvnet();
      }
      document.getElementById('step01_check').checked = true;
    }
  }
}
</script>