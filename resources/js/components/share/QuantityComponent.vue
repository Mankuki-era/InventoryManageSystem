<template>
  <div class="amount_change_button">
    <input type="button" name="minus" value="－" @mousedown="Down(false)" @mouseup="Up(false)" class="amount_button amount_change minus" v-bind:class="{inventory: linkName === 'inventory'}">
    <input type="number" name="amount" step="1" v-model="quantity" class="FormOfms"  data-min="0" data-max="999" @input="numberFormChange">
    <input type="button" name="plus" value="＋" @mousedown="Down(true)" @mouseup="Up(true)" class="amount_button amount_change plus" v-bind:class="{inventory: linkName === 'inventory'}">
  </div>
</template>

<script>

export default {
  props: ['index', 'defaultQuantity', 'linkname'],
  data: function(){
    return {
      time: 0,
      timer: null,
      quantity: this.defaultQuantity,
      counter: null,
      linkName: this.linkname,
    }
  },
  methods: {
    Down: function(bool) {   
      this.timer = setInterval(() => {
        this.time += 1;
        if(this.time >= 50){
          clearInterval(this.timer);
          this.counter = setInterval(() => {
            if(bool === false && parseInt(this.quantity) !== 0){
              this.quantity = parseInt(this.quantity) - 1;
            }else if(bool === true){
              this.quantity = parseInt(this.quantity) + 1;
            }
          },100);
        }
      },10); 
    },
    Up: function(bool) {
      if(this.time < 50){
        if(bool === false && parseInt(this.quantity) !== 0){
          this.quantity = parseInt(this.quantity) - 1;
        }else if(bool === true){
          this.quantity = parseInt(this.quantity) + 1;
        }
        clearInterval(this.timer);
      }
      this.time = 0;
      clearInterval(this.counter);

      this.$emit('quantity-event', this.quantity, this.index, this.linkName); //propsのindexをそのまま用いないとダメ
    },
    numberFormChange: function() {
      this.$emit('quantity-event', this.quantity, this.index, this.linkName);
    },
    quantityresetMethod: function() {
      this.quantity = 0;
    },
  }
}


</script>