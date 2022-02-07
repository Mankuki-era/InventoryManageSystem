<template>
  <div class="main">
    <div class="content-header">
      <h1>登録</h1>
    </div>
    <div class="content create">
      <div class="card">
        <div class="card-header type01">
          <span><i class="fas fa-plus-square fa-lg plus-square-icon"></i>一括追加</span>
        </div>
        <div class="card-body">
          <type01-component @loading-event="loadingEvent" @message-event="messageEvent"></type01-component>
        </div>
      </div>
      <div class="card">
        <div class="card-header type02">
          <span><i class="fas fa-plus-square fa-lg plus-square-icon"></i>追加</span>
        </div>
        <div class="card-body">
          <type02-component @loading-event="loadingEvent" @message-event="messageEvent"></type02-component>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
module.exports = {
  mounted() {
    $(function(){
      if(sessionStorage.getItem('createType') === '01'){
        $('.card .card-header.type01').addClass("open");
        $('.card .card-header.type02').next('.card .card-body').hide();
      }else if(sessionStorage.getItem('createType') === '02'){
        $('.card .card-header.type02').addClass("open");
        $('.card .card-header.type01').next('.card .card-body').hide();
      }
      $('.content .card .card-header').click(function(){
        if($(this).hasClass('type01')){
          sessionStorage.setItem('createType', '01');
        }else if($(this).hasClass('type02')){
          sessionStorage.setItem('createType', '02');
        };
        $(this).next('.card-body').slideToggle();
        $(this).toggleClass("open");
        $('.content .card .card-header').not($(this)).next('.card .card-body').slideUp();
        $('.content .card .card-header').not($(this)).removeClass("open");
      });
    });
  },
  methods: {
    loadingEvent: function(bool){
      this.$emit('loading-event', bool);
    },
    messageEvent: function(message, bool, initFlag){
      this.$emit('message-event', message, bool, initFlag);
    }
  }
}
</script>