<template>
  <div class="buy_consume_bar">
    <nav class="select_buy_consume">
      <ul>
        <li class="select_buy">
          <a href="#" id="select_buy" @click.prevent.stop="linkClick('purchase')">
            <span class="changing_english">PURCHASE</span>
            <span class="changing_japanese">  購入</span>
          </a>
        </li>
        <li class="select_consume">
          <a href="#" id="select_consume" @click.prevent.stop="linkClick('inventory')">
            <span class="changing_english ch_white">INVENTORY</span>
            <span class="changing_japanese ch_white">&nbsp;在庫管理</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  methods: {
    linkClick: function(linkName) {
      this.$emit('subheader-event', linkName);
    },
  }
}
</script>