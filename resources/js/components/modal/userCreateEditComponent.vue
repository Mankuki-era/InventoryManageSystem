<template>
  <div class="create-form-contena">
    <a href="#" class="create-button" @click.prevent.stop="createAction" v-show="actionInfo.name === 'user-create'">Create</a>
    <a href="#" class="create-button" @click.prevent.stop="updateAction" v-show="actionInfo.name === 'user-edit'">Update</a>
    <div class="profile-image-box">
      <img :src="url" alt="画像">
      <label class="file-select-button" v-show="actionInfo.name !== 'user-show'">
        <div class="file-label" title="ファイルを選択">
          <i class="fas fa-camera camera-icon"></i>
        </div>
        <input type="file" class="file-input" accept=".jpg,.gif,.png,image/gif,image/jpeg,image/png" ref="preview" @change="fileSelected">
      </label>
    </div>
    <div class="modal-content">
      <div class="first-row-form">
        <div class="form-input">
          <input type="text" name="name" v-model="fields.familyName" required>
          <div class="underline"></div>
          <label for="">FamilyName</label>
          <p class="caution_message" v-if="errors.familyName">{{ errors.familyName[0] }}</p>
          <p class="caution_message" v-else></p>
        </div>
        <div class="form-input">
          <input type="text" name="name" v-model="fields.givenName" required>
          <div class="underline"></div>
          <label for="">GivenName</label>
          <p class="caution_message" v-if="errors.givenName">{{ errors.givenName[0] }}</p>
          <p class="caution_message" v-else></p>
        </div>
      </div>
      <div class="second-row-form">
        <div class="form-input">
          <input type="text" name="model" v-model="fields.number" required>
          <div class="underline"></div>
          <label for="">Number</label>
          <p class="caution_message" v-if="errors.number">{{ errors.number[0] }}</p>
          <p class="caution_message" v-else></p>
        </div>
        <div class="form-input">
          <input type="text" name="url" v-model="fields.email" required>
          <div class="underline"></div>
          <label for="">Email</label>
          <p class="caution_message" v-if="errors.email">{{ errors.email[0] }}</p>
          <p class="caution_message" v-else></p>
        </div>
      </div>
      <div class="third-row-form">
        <div class="form-input">
          <input type="password" name="model" v-model="fields.password" required>
          <div class="underline"></div>
          <label for="">Password</label>
          <p class="caution_message" v-if="errors.password">{{ errors.password[0] }}</p>
          <p class="caution_message" v-else></p>
        </div>
        <div class="form-input">
          <input type="password" name="url" v-model="fields.password_confirmation" required>
          <div class="underline"></div>
          <label for="">Confirm Password</label>
          <p class="caution_message" v-if="errors.password_confirmation">{{ errors.password_confirmation[0] }}</p>
          <p class="caution_message" v-else></p>
        </div>
      </div>
      <div class="fourth-row-form">
        <div class="select-box">
          <select class="selection" v-model="fields.role" required>
            <option>DAYTIME</option>
            <option>NIGHTTIME</option>
            <option>TEACHER</option>
          </select>
          <label for="">Role</label>
          <div class="underline"></div>
          <p class="caution_message" v-if="errors.role">{{ errors.role[0] }}</p>
          <p class="caution_message" v-else></p>
        </div>
        <div class="select-box">
          <select class="selection" v-model="fields.admin" @change="adminChangeMethod" required>
            <option value="assignment">ASSIGNMENT</option>
            <option value="nonassignment">NONASSIGNMENT</option>
          </select>
          <label for="">Admin</label>
          <div class="underline"></div>
          <p class="caution_message" v-if="errors.admin">{{ errors.admin[0] }}</p>
          <p class="caution_message" v-else></p>
        </div>
      </div>
      <div class="fifth-row-form" v-bind:class="{none: admin_passform_noneFlag}">
        <div class="form-input"></div>
        <div class="form-input">
          <input type="password" name="model" v-model="fields.admin_password" required>
          <div class="underline"></div>
          <label for="">Admin Password</label>
          <p class="caution_message" v-if="message">{{ message }}</p>
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
        familyName: '',
        givenName: '',
        number: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: '',
        admin: ''
      },
      url: '/image/default_user.png',
      errors: {},
      actionInfo: this.action_info,
      message: '',
      admin_passform_noneFlag: true,
      admin_changeFlag: false,
    }
  },
  mounted() {
    if(this.actionInfo.name === 'user-edit'){
      this.loadUser();
    }
  },
  methods: {
    loadUser: function() {
      axios.get('/api/user/' + this.actionInfo.id).then(e => {
        this.fields = e.data;
        this.url = this.fields.img_path;
        var name = this.fields.name.split(' ');
        this.fields.familyName = name[0];
        this.fields.givenName = name[1];
      }).catch((error) => {
        console.log(error);
      });
    },
    fileSelected: function(e) {
      const file = this.$refs.preview.files[0];
      this.url = URL.createObjectURL(file);
      this.fields.img_file = e.target.files[0];
    },
    adminChangeMethod: function(){
      this.admin_passform_noneFlag = this.fields.admin === 'assignment' ? false : true;
      this.admin_changeFlag = true;
    },
    createAction: function(){
      this.errors = {};
      if(this.fields.admin === 'assignment' && this.fields.admin_password === undefined){
        this.message = '管理者用のパスワードを入力してください.';
        return;
      }
      let formData = new FormData();
      if(this.fields.admin_password){
        formData.append('admin_pass', this.fields.admin_password);
      }
      formData.append('familyName', this.fields.familyName);
      formData.append('givenName', this.fields.givenName);
      formData.append('number', this.fields.number);
      formData.append('email', this.fields.email);
      formData.append('password', this.fields.password);
      formData.append('password_confirmation', this.fields.password_confirmation);
      formData.append('role', this.fields.role);
      formData.append('admin', this.fields.admin);
      if(this.fields.img_file){
        formData.append('file',this.fields.img_file);
      }

      axios.post('/api/user', formData).then((e) =>{
        if(e.data.caution_message){
          this.message = e.data.caution_message;
        }else{
          this.$emit('message-event', e.data.message, true);
          this.$emit('close-event');
          this.$emit('refresh-event');
        }
      }).catch((error) =>{
        this.errors = error.response.data.errors;
      })
    },
    updateAction: function() {
      this.errors = {};
      if(this.fields.admin === 'assignment' && this.fields.admin_password === undefined && this.admin_changeFlag === true){
        this.message = '管理者用のパスワードを入力してください.';
        return;
      }
      let formData = new FormData()
      if(this.fields.admin_password){
        formData.append('admin_pass', this.fields.admin_password);
      }
      formData.append('familyName', this.fields.familyName);
      formData.append('givenName', this.fields.givenName);
      formData.append('email', this.fields.email);
      formData.append('number', this.fields.number);
      formData.append('role', this.fields.role);
      formData.append('admin', this.fields.admin);
      if(this.fields.password){
        formData.append('password', this.fields.password);
      }
      if(this.fields.password_confirmation){
        formData.append('password_confirmation', this.fields.password_confirmation);
      }
      if(this.fields.img_file){
        formData.append('file', this.fields.img_file);
      }
      console.log(this.fields);

      axios.post('/api/user/' + this.actionInfo.id, formData, {
        headers: {
          'X-HTTP-Method-Override': 'PUT'
        }
      }).then(e => {
        if(e.data.caution_message){
          this.message = e.data.caution_message;
        }else{
          this.$emit('message-event', e.data.message, true);
          this.$emit('close-event');
          this.$emit('refresh-event');
        }
      }).catch((error) => {
        this.errors = error.response.data.errors;
      });
    },
  }
}
</script>