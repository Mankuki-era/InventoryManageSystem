<template>
  <main>
    <div class="header">
      <ul>
        <li><a href="javascript:void(0)" id="bar"><i class="fas fa-bars"></i></a></li>
      </ul>
      <ul class="grade-box-ul">
        <li class="grade-box-li">
          <a href="javascript:void(0)" class="accordion-header">{{ fields.grade }}</a>
          <ul class="accordion-main">
            <li v-for="link in Object.keys(gradeArray)" :key="link" v-show="link !== fields.grade">
              <a href="" @click.prevent.stop="clickGradeLink(link)">{{ link }}</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <loading-component ref="loadingChild"></loading-component>
    <router-view ref="routerChild" @loading-event="loadingEvent" @open-modal="openModal" @message-event="messageEvent"></router-view>
  </main>
</template>

<script>
module.exports = {
  initData: function(){
    return {
      fields: {
        grade: '',
      }
    };
  },
  data: function(){
    return this.$options.initData();
  },
  mounted: function(){
    $(function(){
      $('.accordion-main').slideUp();
      // ナビゲーションがクリックされた時
      $('.grade-box-ul .grade-box-li .accordion-header').click(function(){
        $(this).next('.accordion-main').slideToggle();
        $(this).toggleClass("open");
      });

    });
    this.fields.grade = sessionStorage.getItem('grade');
  },
  methods: {
    clickGradeLink: function(grade){
      this.fields.grade = grade;
      sessionStorage.setItem('grade', grade);
    },
    loadingEvent: function(bool){
      this.$refs.loadingChild.loadingEvent(bool);
    },
    openModal: function(func, id, index){
      this.$emit('open-modal', func, id, index);
    },
    indexTypeClick: function(){
      this.$refs.routerChild.indexTypeClick();
    },
    dataChange: function(index, data){
      this.$refs.routerChild.dataChange(index, data);
    },
    messageEvent: function(message, bool, initFlag){
      this.$emit('message-event', message, bool, initFlag);
    }
  }
}
</script>