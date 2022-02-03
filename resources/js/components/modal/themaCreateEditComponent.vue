<template>
  <div class="create-form-contena">
    <a href="#" class="create-button" @click.prevent.stop="createAction" v-show="actionInfo.name === 'thema-create'">Create</a>
    <a href="#" class="create-button" @click.prevent.stop="updateAction" v-show="actionInfo.name === 'thema-edit'">Update</a>
    <div class="modal-content">
      <div class="first-row-form">
        <div class="form-input">
          <input type="text" name="name" v-model="fields.first_category" required>
          <div class="underline"></div>
          <label for="">First Category</label>
        </div>
      </div>
      <div class="second-row-form">
        <div class="form-input">
          <input type="text" name="model" v-model="fields.second_category" required>
          <div class="underline"></div>
          <label for="">Second Category</label>
        </div>
      </div>
      <div class="third-row-form">
        <div class="form-input">
          <input type="text" name="model" v-model="fields.third_category" required>
          <div class="underline"></div>
          <label for="">Third Category</label>
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
        first_category: '',
        second_category: '',
        third_category: '',
      },
      actionInfo: this.action_info,
    }
  },
  mounted() {
    if(this.actionInfo.name === 'thema-edit'){
      this.loadThema();
    }
  },
  methods: {
    loadThema: function() {
      axios.get('/api/thema/' + this.actionInfo.id).then(e => {
        this.fields = e.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    createAction: function(){
      let formData = new FormData();
      formData.append('first_category', this.fields.first_category);
      formData.append('second_category', this.fields.second_category);
      formData.append('third_category', this.fields.third_category);

      axios.post('/api/thema', formData).then((e) =>{
        this.$emit('message-event', e.data.message, true);
        this.$emit('close-event');
      }).catch((error) =>{
        console.log(error);
      })
    },
    updateAction: function() {
      let formData = new FormData()
      formData.append('first_category', this.fields.first_category);
      formData.append('second_category', this.fields.second_category);
      formData.append('third_category', this.fields.third_category);

      axios.post('/api/thema/' + this.actionInfo.id, formData, {
        headers: {
          'X-HTTP-Method-Override': 'PUT'
        }
      }).then(e => {
        this.$emit('message-event', e.data.message, true);
        this.$emit('close-event');
      }).catch((error) => {
        console.log(error);
      });
    },
  }
}
</script>