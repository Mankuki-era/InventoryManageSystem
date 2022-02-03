<template>
  <div class="submit_button">
    <div class="inventory_input">
      <div class="inventory_input_button">
        <button type="click" name="button" class="button_inventory button_cartin_in" @click.prevent.stop="buttonClick(true)">
          <p>納&nbsp;入<i class="fas fa-plus-circle"></i></p>
        </button>
      </div>
    </div>
    <div class="inventory_output">
      <div class="inventory_output_button">
        <button type="click" name="button" class="button_inventory button_cartin_out" @click.prevent.stop="buttonClick(false)">
          <p>消&nbsp;費<i class="fas fa-minus-circle"></i></p>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['id', 'index', 'itemName'],
  data: function() {
    return {
      stocks: 0,
    }
  },
  methods: {
    buttonClick(bool) {
      let formData = new FormData();
      formData.append('stocks', this.stocks);
      formData.append('bool', bool);
      formData.append('item_name', this.itemName);

      axios.post('/api/item/stocks/' + this.id, formData, {
        headers: {
          'X-HTTP-Method-Override': 'PUT'
        }
      }).then(e => {
        this.$emit('notificationChange-event');
        this.$emit('messageshow-event', e.data.message, true);
        this.$emit('submit-event', this.index, this.stocks, bool);
        this.$emit('quantityreset-event', this.index);
      }).catch((error) => {
        console.log(error);
      });
    },
    changequantityMethod(count) {
      this.stocks = count;
    }
  }
}
</script>