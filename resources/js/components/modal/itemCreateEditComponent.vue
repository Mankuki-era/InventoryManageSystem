<template>
  <div class="create-form-contena">
    <a href="#" class="create-button" @click.prevent.stop="createAction" v-show="actionInfo.name === 'item-create'">Create</a>
    <a href="#" class="create-button" @click.prevent.stop="updateAction" v-show="actionInfo.name === 'item-edit'">Update</a>
    <div class="item-image-box">
      <img :src="url" alt="画像">
      <label class="file-select-button" v-show="actionInfo.name !== 'show'">
        <div class="file-label" title="ファイルを選択">
          <i class="fas fa-camera camera-icon"></i>
        </div>
        <input type="file" class="file-input" accept=".jpg,.gif,.png,image/gif,image/jpeg,image/png" ref="preview" @change="fileSelected">
      </label>
    </div>
    <div class="modal-left">
      <div class="first-row-form">
        <div class="form-input">
          <input type="text" name="name" v-model="fields.name" required>
          <div class="underline"></div>
          <label for="">Name</label>
          <p class="caution_message" v-if="errors.name">{{ errors.name }}</p>
          <p class="caution_message" v-else></p>
        </div>
      </div>
      <div class="second-row-form">
        <div class="form-input">
          <input type="text" name="model" v-model="fields.model" required>
          <div class="underline"></div>
          <label for="">Model</label>
          <p class="caution_message" v-if="errors.model">{{ errors.model }}</p>
          <p class="caution_message" v-else></p>
        </div>
        <div class="form-input">
          <input type="text" name="url" v-model="fields.url" required>
          <div class="underline"></div>
          <label for="">URL</label>
          <p class="caution_message" v-if="errors.url">{{ errors.url }}</p>
          <p class="caution_message" v-else></p>
        </div>
      </div>
      <div class="third-row-form">
        <div class="form-input">
          <input type="number" name="price" v-model="fields.price" required>
          <div class="underline"></div>
          <label for="">Price</label>
          <p class="caution_message" v-if="errors.price">{{ errors.price }}</p>
          <p class="caution_message" v-else></p>
        </div>
        <div class="form-input">
          <input type="number" name="stocks" v-model="fields.stocks" class="stocks" required>
          <input type="text" name="unit" v-model="fields.unit" class="unit" required placeholder="単位">
          <div class="underline stocks"></div>
          <label for="">Stocks</label>
          <p class="caution_message" v-if="errors.stocks">{{ errors.stocks }}</p>
          <p class="caution_message" v-else></p>
        </div>
      </div>
      <div class="fourth-row-form">
        <div class="needs-select-box">
          <label class="radioBox">
            <input class="radioBox-Input" type="radio" name="radio" value="half" v-model="needsPicked" @change="needsSelected">
            <span class="radioBox-DummyInput"></span>
            <span class="radioBox-Label">半期必要数</span>
          </label>
          <label class="radioBox">
            <input class="radioBox-Input" type="radio" name="radio" value="all" v-model="needsPicked" @change="needsSelected">
            <span class="radioBox-DummyInput"></span>
            <span class="radioBox-Label">通年必要数</span>
          </label>
        </div>
        <div class="form-input all" v-if="needsPicked === 'all'">
          <input type="number" name="needs_all" v-model="fields.needs_all" required>
          <div class="underline"></div>
          <label for="">通年</label>
          <p class="caution_message"></p>
        </div>
        <div class="form-input" v-if="needsPicked === 'half'">
          <input type="number" name="needs_" v-model="fields.needs_pro" required>
          <div class="underline"></div>
          <label for="">前期</label>
          <p class="caution_message"></p>
        </div>
        <div class="form-input" v-if="needsPicked === 'half'">
          <input type="number" name="needs_" v-model="fields.needs_late" required>
          <div class="underline"></div>
          <label for="">後期</label>
          <p class="caution_message"></p>
        </div>
      </div>
      <div class="fifth-row-form">
        <div class="grade-select-box">
          <select class="grade_selection" v-model="fields.selectGrade" @change="gradeSelected" required>
            <option v-for="grade in gradeList" :key="grade" :value="grade">
              {{ grade }}
            </option>
          </select>
          <label class="gradeLabel" for="">Grade</label>
          <div class="underline"></div>
          <p class="caution_message" v-if="errors.grade">{{ errors.grade }}</p>
          <p class="caution_message" v-else></p>
        </div>
        <div class="thema-select-box">
          <select class="thema_selection" v-model="fields.selectThema" required>
            <option v-for="thema in themaList" :key="thema" :value="thema">
              {{ thema }}
            </option>
          </select>
          <label class="themaLabel" for="">Thema</label>
          <div class="underline"></div>
          <p class="caution_message" v-if="errors.thema">{{ errors.thema }}</p>
          <p class="caution_message" v-else></p>
        </div>
      </div>
    </div>
    <div class="modal-right">
      <div class="fifth-row-form">
        <div class="form-input">
          <textarea name="comment" rows="2" v-model="fields.comment"></textarea>
          <label for="">Comment</label>
        </div>
      </div>
      <div class="sixth-row-form">
        <div class="form-input">
          <input type="text" name="tag" v-model="tagForm[0]">
          <input type="text" name="tag" v-model="tagForm[1]">
          <input type="text" name="tag" v-model="tagForm[2]">
          <input type="text" name="tag" v-model="tagForm[3]">
          <input type="text" name="tag" v-model="tagForm[4]">
          <label for="">Tags</label>
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
      needsPicked: 'half',
      gradeList: [],
      themaList: [],
      tagForm: ['', '', ''],
      url: '/image/no_image.png',
      errors: {},
      actionInfo: this.action_info,
    }
  },
  mounted() {
    this.loadGrade();
    if(this.actionInfo.name === 'item-edit'){
      this.loadItem();
    }
  },
  methods: {
    loadItem: function() {
      axios.get('/api/item/' + this.actionInfo.id).then(e => {
        this.fields = e.data.data;
        this.needsPicked = this.fields.needs_all === null ? 'half' : 'all';
        if(this.fields.price === 0) {
          this.fields.price = '';
        }
        this.url = this.fields.img_path;
        this.fields.selectGrade = this.fields.second_category;
        this.gradeSelected();
        this.fields.selectThema = this.fields.third_category;
        var index = 0;
        this.fields.tags.forEach(tag => {
          if(tag.tag_name !== this.fields.first_category && tag.tag_name !== this.fields.second_category && tag.tag_name !== this.fields.third_category){
            this.tagForm[index] = tag.tag_name;
            index++;
          }
        });
      }).catch((error) => {
        console.log(error);
      });
    },
    loadGrade: function() {
      axios.get('/api/grade').then(e => {
        this.gradeList = e.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    backLink: function() {
      this.$emit('close-event');
    },
    needsSelected: function(){
      if(this.needsPicked === 'half'){
        this.fields.needs_all = null;
      }else{
        this.fields.needs_pro = null;
        this.fields.needs_late = null;
      }
    },
    gradeSelected: function(){
      axios.get('/api/themas', {
        params: {
          'grade': this.fields.selectGrade
        }
      }).then(e => {
        this.fields.grade_belong = e.data.grade_belong;
        this.themaList = e.data.themaList;
      }).catch((error) => {
        console.log(error);
      });
    },
    fileSelected: function(e) {
      const file = this.$refs.preview.files[0];
      this.url = URL.createObjectURL(file);
      this.fields.file = e.target.files[0];
    },
    createAction: function(){
      this.errors = {};
      this.setErrors();
      if(this.check()){
        this.setFields();

        let formData = new FormData();
        formData.append('name', this.fields.name);
        formData.append('stocks', this.fields.stocks);
        formData.append('first_category', this.fields.first_category);
        formData.append('second_category', this.fields.second_category);
        formData.append('third_category', this.fields.third_category);
        formData.append('tags', this.fields.tags);

        if(this.fields.model){
          formData.append('model', this.fields.model);
        }
        if(this.fields.unit){
          formData.append('unit', this.fields.unit);
        }
        if(this.fields.url){
          formData.append('url', this.fields.url);
        }
        if(this.fields.price){
          formData.append('price',this.fields.price);
        }
        if(this.fields.file){
          formData.append('file', this.fields.file);
        }
        if(this.fields.comment){
          formData.append('comment', this.fields.comment);
        }
        if(this.fields.needs_all){
          formData.append('needsAll', this.fields.needs_all);
        }
        if(this.fields.needs_pro){
          formData.append('needsPro', this.fields.needs_pro);
        }
        if(this.fields.needs_late){
          formData.append('needsLate', this.fields.needs_late);
        }
        
        axios.post('/api/item', formData).then(e => {
          this.$emit('message-event', e.data.message, true);
          this.$emit('close-event');
          this.$emit('refresh-event');
        }).catch((error) => {
          console.log(error);
        });
      };
    },
    updateAction: function() {
      this.errors = {};
      this.setErrors();
      if(this.check()){
        this.setFields();
        let formData = new FormData()
        formData.append('name', this.fields.name);
        formData.append('stocks', this.fields.stocks);
        formData.append('tags', this.fields.tags);
        formData.append('first_category', this.fields.first_category);
        formData.append('second_category', this.fields.second_category);
        formData.append('third_category', this.fields.third_category);
        if(this.fields.model){
          formData.append('model',this.fields.model);
        }
        if(this.fields.unit){
          formData.append('unit',this.fields.unit);
        }
        if(this.fields.url){
          formData.append('url',this.fields.url);
        }
        if(this.fields.price){
          formData.append('price',this.fields.price);
        }
        if(this.fields.file){
          formData.append('file',this.fields.file);
        }
        if(this.fields.comment){
          formData.append('comment', this.fields.comment);
        }
        if(this.fields.needs_all){
          formData.append('needsAll', this.fields.needs_all);
        }
        if(this.fields.needs_pro){
          formData.append('needsPro', this.fields.needs_pro);
        }
        if(this.fields.needs_late){
          formData.append('needsLate', this.fields.needs_late);
        }

        axios.post('/api/item/' + this.actionInfo.id, formData, {
          headers: {
            'X-HTTP-Method-Override': 'PUT'
          }
        }).then(e => {
          this.$emit('message-event', e.data.message, true);
          this.$emit('close-event');
          this.$emit('refresh-event');
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    setErrors: function(){
      var commonString = 'を入力してください.';
      this.errors.name = this.fields.name ? '' : '商品名' + commonString;
      this.errors.stocks = this.fields.stocks ? '' : '在庫数' + commonString;
      this.errors.grade = this.fields.selectGrade ? '' : '学年学科を選択してください.';
      this.errors.thema = this.fields.selectThema ? '' : '科目名を選択してください.';
    },
    check: function(){
      for(let key in this.errors){
        if(this.errors[key]){
          return false;
        };
      };
      return true;
    },
    setFields: function(){
      var tagformFiexed = [];
      var tags = [];
      this.tagForm.forEach(tag => {
        if(tag.trim()){
          tagformFiexed.push(tag.trim());
        }
      });
      if(this.fields.grade_belong === ''){
        tags.push(this.fields.selectGrade, this.fields.selectThema, ...tagformFiexed); //スプレッド関数によって配列を展開してpush
      }else{
        tags.push(this.fields.grade_belong, this.fields.selectGrade, this.fields.selectThema, ...tagformFiexed); //スプレッド関数によって配列を展開してpush
      }
      this.fields.first_category = this.fields.grade_belong;
      this.fields.second_category = this.fields.selectGrade;
      this.fields.third_category = this.fields.selectThema;
      this.fields.tags = tags;
    },
  }
}
</script>