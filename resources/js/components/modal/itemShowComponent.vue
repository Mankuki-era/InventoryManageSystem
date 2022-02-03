<template>
  <div class="show-form-contena">
    <div class="item-image-box">
      <img :src="fields.img_path" alt="画像">
    </div>
    <div class="first-row-contena">
      <div class="content-box">
        <p class="content">{{ fields.name }}</p>
        <span>Name</span>
      </div>
    </div>
    <div class="second-row-contena">
      <div class="content-box">
        <p class="content" v-if="fields.model">{{ fields.model }}</p>
        <p class="content" v-else>登録なし</p>
        <span>Model</span>
      </div>
      <div class="content-box">
        <p class="content" v-if="fields.url">{{ fields.url }}</p>
        <p class="content" v-else>登録なし</p>
        <span>URL</span>
      </div>
    </div>
    <div class="third-row-contena">
      <div class="left-contena">
        <div class="left-up-contena">
          <div class="content-box">
            <p class="content" v-if="fields.price === '0'">{{ fields.price }}</p>
            <p class="content" v-else>登録なし</p>
            <span>Price</span>
          </div>
          <div class="content-box">
            <p class="content">{{ fields.stocks }}{{ fields.unit }}</p>
            <span>Stocks</span>
          </div>
        </div>
        <div class="left-down-contena">
          <div class="content-box">
            <p class="content" v-if="fields.comment">{{ fields.comment }}</p>
            <p class="content" v-else>登録なし</p>
            <span>Comment</span>
          </div>
        </div>
      </div>
      <div class="right-contena">
        <div class="content-box">
          <p class="tag" v-for="(tag, index) in fields.tags" :key="index">{{ tag.tag_name }}</p>
          <span>Tags</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['action_info'],
  data: function(){
    return {
      fields: {},
      actionInfo: this.action_info
    }
  },
  mounted() {
    this.loadItem();
  },
  methods: {
    loadItem: function() {
      axios.get('/api/item/' + this.actionInfo.id).then(e => {
        this.fields = e.data.data;
      }).catch((error) => {
        console.log(error);
      });
    },
  }
}
</script>