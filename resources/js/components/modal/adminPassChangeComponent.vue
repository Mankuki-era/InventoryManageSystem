<template>
  <div class="create-form-contena">
    <a href="#" class="create-button" @click.prevent.stop="updateAction">Update</a>
    <div class="modal-content">
      <div class="first-row-form">
        <div class="form-input">
          <input type="password" name="name" v-model="fields.current_password" required>
          <div class="underline"></div>
          <label for="">現在のパスワード</label>
          <p class="caution_message" v-if="caution_message">{{ caution_message }}</p>
          <p class="caution_message" v-if="errors.current_password">{{ errors.current_password[0] }}</p>
          <p class="caution_message" v-else></p>
        </div>
      </div>
      <div class="second-row-form">
        <div class="form-input">
          <input type="password" name="model" v-model="fields.password" required>
          <div class="underline"></div>
          <label for="">新しいパスワード</label>
          <p class="caution_message" v-if="errors.password">{{ errors.password[0] }}</p>
          <p class="caution_message" v-else></p>
        </div>
      </div>
      <div class="third-row-form">
        <div class="form-input">
          <input type="password" name="model" v-model="fields.password_confirmation" required>
          <div class="underline"></div>
          <label for="">新しいパスワード[確認用]</label>
          <p class="caution_message" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</p>
          <p class="caution_message" v-else></p>
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
      fields: {
        current_password: '',
        password: '',
        password_confirmation: '',
      },
      actionInfo: this.action_info,
      caution_message: '',
      errors: {}
    }
  },
  methods: {
    updateAction: function() {
      this.errors = {};
      this.caution_message = '';

      let formData = new FormData()
      formData.append('current_password', this.fields.current_password);
      formData.append('password', this.fields.password);
      formData.append('password_confirmation', this.fields.password_confirmation);

      axios.post('/api/infoUpdate', formData).then(e => {
        if(e.data.caution_message){
          this.caution_message = e.data.caution_message;
        }else{
          this.$emit('message-event', e.data.message, true);
          this.$emit('close-event');
        }
      }).catch((error) => {
        this.errors = error.response.data.errors;
      });
    },
  }
}
</script>