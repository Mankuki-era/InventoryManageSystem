<template>
  <nav>
    <div class="logo-box">
      <img src="/img/icon.png" alt="管理画面">
      <span class="small-hide-inline">管理画面</span>
    </div>
    <div class="link-box">
      <ul class="link-box-ul">
        <li class="link-box-li">
          <a href="javascript:void(0)" @click.prevent.stop="router.push({path:'/create'}, () => {})" class="accordion-header create">
            <span><i class="fas fa-fw fa-edit link-icon"></i><span class="small-hide-inline">登録</span></span>
          </a>
        </li>
        <li class="link-box-li">
          <a href="javascript:void(0)" @click.prevent.stop="clickIndexLink" class="accordion-header index">
            <span><i class="fas fa-fw fa-list link-icon"></i><span class="small-hide-inline">一覧</span></span>
            <i class="fas fa-angle-left right angle-icon small-hide-inline"></i>
          </a>
          <ul class="accordion-main small-hide-block">
            <li v-for="(link, index) in linkArray" :key="index">
              <a href="" :class="{ selected: fields.indexType === link }" @click.prevent.stop="clickLink(link)">{{ link }}</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
module.exports = {
  mounted() {
    $(function(){
      if(sessionStorage.getItem('linkName') === 'create'){
        $('.link-box-li .accordion-header.create').addClass("open");
        $('.link-box-li .accordion-header.index').next('.link-box-li .accordion-main').hide();
      }else if(sessionStorage.getItem('linkName') === 'index'){
        $('.link-box-li .accordion-header.index').addClass("open");
        $('.link-box-li .accordion-header.index').next('.link-box-li .accordion-main').show();
      }
      $('.link-box-ul .link-box-li .accordion-header').click(function(){
        if(!$(this).hasClass('open')){
          $(this).next('.accordion-main').slideToggle();
          $(this).toggleClass("open");
        }
        $('.link-box-ul .link-box-li .accordion-header').not($(this)).next('.link-box-li .accordion-main').slideUp();
        $('.link-box-ul .link-box-li .accordion-header').not($(this)).removeClass("open");
      });
      $('nav').hover( // hover時
        function(){
          setTimeout(() => {
              if($('nav').hasClass('small')){
                $('.small-hide-inline').show().css("display","inline-block"); // small -> 通常
                $('.small-hide-block').css('opacity','1'); // small -> 通常
              }
            }, 150);
        },
        function(){
          if($('nav').hasClass('small')){
            $('.small-hide-inline').hide(); // 通常 -> small
            $('.small-hide-block').css('opacity','0'); // 通常 -> small
          }
        }
      );
      $('#bar').click(function(){ // barクリック時
          if($('nav').hasClass('small')){
          setTimeout(() => {
            $('.small-hide-inline').show().css("display","inline-block"); // small -> 通常
            $('.small-hide-block').css('opacity','1'); // small -> 通常
          }, 150);
        }else{
          $('.small-hide-inline').hide(); // 通常 -> small
          $('.small-hide-block').css('opacity','0'); // 通常 -> small
        }
        $('nav').toggleClass('small');
      });
    });
    this.fields.indexType = sessionStorage.getItem('indexType');
  },
  data () {
    return {
      fields: {
        indexType: ''
      },
      linkArray: ['すべて','1EC','2EC','3EC','2NC','3NC','4EC','4NC','管理室']
    }
  },
  methods: {
    clickIndexLink: function(){
      this.fields.indexType = sessionStorage.getItem('indexType');
      router.push({path:'/index'}, () => {});
    },
    clickLink: function(link){
      this.fields.indexType = link;
      sessionStorage.setItem('indexType', link);
      this.$emit('indextype-click');
    },
  }
}
</script>