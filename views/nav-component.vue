<template>
  <nav>
    <div class="logo-box">
      <img src="/img/icon.png" alt="管理画面">
      <span class="small-hide-inline">管理画面</span>
    </div>
    <div class="link-box">
      <ul class="link-box-ul">
        <li class="link-box-li" v-for="link in navLinkArray" :key="link.name">
          <a href="javascript:void(0)" @click.prevent.stop="clickLink(link)" class="accordion-header" :class="setClass(link.name)">
            <span><span v-html="link.icon" class="link-icon"></span><span class="small-hide-inline">{{ link.name_jp }}</span></span>
            <i v-show="link.subLinkArray !== ''" class="fas fa-angle-left right angle-icon small-hide-inline"></i>
          </a>
          <ul v-show="link.subLinkArray" class="accordion-main small-hide-block">
            <li v-for="subLink in link.subLinkArray" :key="subLink.name">
              <a href="" :class="{ selected: fields.subLinkName === subLink.name }" @click.prevent.stop="clickSubLink(subLink.name)">{{ subLink.name_jp }}</a>
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
      // 初期のナビゲーションの選択
      $('.link-box-li .accordion-header.'+sessionStorage.getItem('linkName')).addClass("open");
      $('.link-box-li .accordion-header').not('.'+sessionStorage.getItem('linkName')).next('.link-box-li .accordion-main').hide();

      // ナビゲーションがクリックされた時
      $('.link-box-ul .link-box-li .accordion-header').click(function(){
        if(!$(this).hasClass('open')){
          $(this).next('.accordion-main').slideToggle();
          $(this).toggleClass("open");
        }
        $('.link-box-ul .link-box-li .accordion-header').not($(this)).next('.link-box-li .accordion-main').slideUp();
        $('.link-box-ul .link-box-li .accordion-header').not($(this)).removeClass("open");
      });

      // ナビゲーションがhoverされた時
      $('nav').hover(
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

      // 三本線がクリックされた時
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
    this.fields.linkName = sessionStorage.getItem('linkName');
    this.fields.subLinkName = sessionStorage.getItem('subLinkName');
  },
  data () {
    return {
      fields: {
        linkName: '',
        subLinkName: ''
      },
    }
  },
  methods: {
    setClass: function(linkName){
      return `${linkName}`;
    },
    clickLink: function(link){
      if(link.name === this.fields.linkName){
        return;
      };
      this.fields.linkName = link.name;
      this.fields.subLinkName = link.subLinkArray ? link.subLinkArray[0].name : '';
      sessionStorage.setItem('linkName', this.fields.linkName);
      sessionStorage.setItem('subLinkName', this.fields.subLinkName);
      if(this.fields.subLinkName){
        router.push({path:`/${this.fields.linkName}-${this.fields.subLinkName}`}, () => {});
      }else{
        router.push({path:`/${this.fields.linkName}`}, () => {});
      }
    },
    clickSubLink: function(subLinkName){
      this.fields.subLinkName = subLinkName;
      sessionStorage.setItem('subLinkName', subLinkName);
      router.push({path:`/${this.fields.linkName}-${this.fields.subLinkName}`}, () => {});
      // this.$emit('indextype-click');
    },
  }
}
</script>