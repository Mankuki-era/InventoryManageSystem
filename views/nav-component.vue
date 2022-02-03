<template>
  <nav :class="{ small: fields.smallFlag }">
    <div class="logo-box">
      <img src="/img/icon.png" alt="管理画面">
      <span>管理画面</span>
    </div>
    <div class="link-box">
      <ul class="link-box-ul">
        <li class="link-box-li">
          <a href="javascript:void(0)" class="accordion-header">
            <span><i class="fas fa-fw fa-edit link-icon"></i>登録</span>
          </a>
        </li>
        <li class="link-box-li">
          <a href="javascript:void(0)" class="accordion-header open">
            <span><i class="fas fa-fw fa-list link-icon"></i>一覧</span>
            <i class="fas fa-angle-left right angle-icon"></i>
          </a>
          <ul class="accordion-main">
            <li v-for="(link, index) in linkArray" :key="index">
              <a href="" :class="{ selected: fields.selectIndex === index }" @click.prevent.stop="clickLink(index)">{{ link }}</a>
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
      $('.link-box-ul .link-box-li .accordion-header').click(function(){
        $(this).next('.accordion-main').slideToggle();
        $(this).toggleClass("open");
        $('.link-box-ul .link-box-li .accordion-header').not($(this)).next('.link-box-li .accordion-main').slideUp();
        $('.link-box-ul .link-box-li .accordion-header').not($(this)).removeClass("open");
      });
    });
  },
  data () {
    return {
      fields: {
        smallFlag: false,
        selectIndex: 0
      },
      linkArray: ['すべて','1EC','2EC','3EC','2NC','3NC','4EC','4NC','管理室']
    }
  },
  methods: {
    clickLink: function(index){
      this.fields.selectIndex = index;
      // this.$emit('click-link',index);
    },
    clickBar: function(){
      this.fields.smallFlag = !this.fields.smallFlag;
    }
  }
}
</script>