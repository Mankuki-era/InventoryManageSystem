<template>
    <div class="submit_button">
        <button v-if="flag" @click.prevent.stop="uncart" class="button_cartin button_cartin_cancel">
            <p>キャンセルする<i class="fas fa-cart-arrow-down"></i></p>
        </button>
        <button v-else @click.prevent.stop="cart" class="button_cartin">
            <p>カートに入れる<i class="fas fa-cart-arrow-down"></i></p>
        </button>
    </div>
</template>

<script>
    export default {
        props: ['item', 'index', 'flg'],
        data () {
            return {
                flag: this.flg,
                quantity: 0,
            };
        },
        methods: {
            cart() {
                if(this.quantity === 0){
                    this.$emit('messageshow-event', '数量を選択してください.', false);
                    return
                }else{
                    axios.get('/api/cart', {
                        params: {
                            'id': this.item.id,
                            'quantity': this.quantity
                        }
                    }).then(e => {
                        this.flag = e.data.res;
                        this.$emit('messageshow-event', 'カートに入れました.', true);
                        this.$emit('cartchange-event');
                    }).catch((error) => {
                        console.log(error);
                    });
                }
            },
            uncart() {
                axios.get('/api/uncart', {
                    params: {
                        'id': this.item.id,
                    }
                }).then(e => {
                    this.flag = e.data.res;
                    this.$emit('messageshow-event', 'カートから出しました.', true);
                    this.$emit('quantityreset-event', this.index);
                    this.$emit('cartchange-event');
                }).catch((error) => {
                    console.log(error);
                });
            },
            changequantityMethod(count) {
                this.quantity = count;
            },
        }
    }
</script>