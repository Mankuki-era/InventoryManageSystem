<template>
  <main class="main-thema">

    <div class="modal-window" v-bind:class="{show: showFlag, none: noneFlag, hide: hideFlag}">
      <adminmodal-component
        v-on:close-event="closeMethod"
        v-on:refresh-event="refreshAction"
        v-on:message-event="messageMethod"
        ref="modalchild"
      ></adminmodal-component>
    </div>
    <div class="modal-mask" v-bind:class="{none: noneFlag}"></div>

    <div class="main-contena">
      <div class="main-title">Thema Management</div>
      <div class="submain-contena">
        <div class="submain-contena-logo"><i class="fas fa-graduation-cap submain-contena-icon"></i></div>
        <div class="submain">
          <p class="submain-title">Themas Table</p>
          <div class="buttons">
            <li class="add-button"><a href="#" @click.prevent.stop="linkAction('thema-create', null)"><i class="fas fa-plus buttons-icon add-icon"></i>ADD NEW</a></li>
            <li class="refresh-button"><a href="#" @click.prevent.stop="refreshAction"><i class="fas fa-redo-alt buttons-icon refresh-icon"></i>REFRESH</a></li>
          </div>
          <div class="form-contena">
            <div class="perpage-select-box">
              <select class="perpage_selection" v-model="fields.perpage" @change="perpageClick" required>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
              </select>
              <div class="underline"></div>
              <label for="">Perpage</label>
            </div>
            <div class="search-box">
              <input type="text" v-model="keyword" required>
              <div class="underline"></div>
              <label for="">Search</label>
              <a href="#" class="search-button" @click.prevent.stop="searchAction"><i class="fas fa-search search-icon"></i></a>
            </div>
          </div>
          <table class="tags-table" v-bind:class="{noData: noThemas}">
            <div class="admin-loader" v-bind:class="{ hidden: isHide }"></div>
            <div class="admin-mask" v-bind:class="{ hidden: isHide }"></div>
            <thead>
              <tr>
                <th>ID</th>
                <th>First Category</th>
                <th>Second Category</th>
                <th>Third Category</th>
                <th>Action</th>
              </tr>
            </thead>
            <div class="no-data-message" v-show="noThemas"><i class="fas fa-info-circle info-icon"></i> 該当するテーマはありません.</div>
            <tbody>
              <tr v-for="thema in themas" :key="thema.id">
                <td>{{ thema.id }}</td>
                <td>{{ thema.first_category }}</td>
                <td>{{ thema.second_category }}</td>
                <td>{{ thema.third_category }}</td>
                <td>
                  <a href="#" @click.prevent.stop="linkAction('thema-edit', thema.id)"><i class="fas fa-pen action-icon edit-icon"></i></a>
                  <a href="#" @click.prevent.stop="linkAction('thema-destroy', thema.id)"><i class="fas fa-trash-alt action-icon trash-icon"></i></a>
                </td>
              </tr>
            </tbody>
          </table>
          <ul class="paginate-box">
            <li class="paginate-link" v-for="page of fields.maxPage" :key="page" v-bind:class="{ this: fields.currentPage === page }">
              <a href="#" @click.prevent.stop="paginateAction(page)">{{ page }}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data: function() {
    return {
      themas: {},
      fields: {},
      keyword: '',
      isHide: true,
      showFlag: false,
      noneFlag: true,
      hideFlag: false,
      noThemas: false
    }
  },
  mounted() {
    this.$emit('class-event', 'admin');
    this.resetInfo();
  },
  methods: {
    resetInfo: function(){
      this.$emit("adminLoading-event", true);
      axios.post('/api/resetInfo').then(e => {
        this.loadInfo();
      }).catch((error) => {
        console.log(error);
      });
    },
    loadInfo: function() {
      axios.get('/api/info').then(e => {
        this.fields.perpage = e.data.perpage;
        this.fields.currentPage = e.data.currentPage;
        this.fields.first_search = e.data.first_search;
        this.keyword = e.data.first_search;
        this.loadThemas();
      }).catch((error) => {
        console.log(error);
      });
    },
    loadThemas: function(){
      axios.get('/api/thema?page=' + this.fields.currentPage, {
        params: {
          perpage: this.fields.perpage,
          first_search: this.fields.first_search,
        }
      }).then(e => {
        this.fields.maxPage = e.data.last_page;
        this.fields.fromPage = e.data.from;
        this.fields.toPage = e.data.to;
        this.fields.totalAmount = e.data.total;
        this.noTags = this.fields.totalAmount === 0 ? true : false;
        this.themas = e.data.data;
        this.$emit("adminLoading-event", false);
      }).catch((error) => {
        console.log(error);
      });
    },
    refreshAction: function() {
      this.resetInfo();
    },
    searchAction: function() {
      this.isHide = false;
      axios.get('/api/thema?page=1', {
        params: {
          perpage: this.fields.perpage,
          first_search: this.keyword,
        }
      }).then(e => {
        this.fields.maxPage = e.data.last_page;
        this.fields.fromPage = e.data.from;
        this.fields.toPage = e.data.to;
        this.fields.totalAmount = e.data.total;
        this.noItems = this.fields.totalAmount === 0 ? true : false;
        this.themas = e.data.data;
        this.fields.first_search = this.keyword;
        this.isHide = true;
      }).catch((error) => {
        console.log(error);
      });
    },
    paginateAction: function(page){
      axios.get('/api/thema?page=' + page, {
        params: {
          perpage: this.fields.perpage,
          first_search: this.fields.first_search,
        }
      }).then(e => {
        this.fields.currentPage = page;
        this.fields.maxPage = e.data.last_page;
        this.fields.fromPage = e.data.from;
        this.fields.toPage = e.data.to;
        this.fields.totalAmount = e.data.total;
        this.themas = e.data.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    perpageClick: function(){
      this.isHide = false;
      axios.get('/api/thema?page=1', {
        params: {
          perpage: this.fields.perpage,
          first_search: this.fields.first_search,
        }
      }).then(e => {
        this.fields.currentPage = 1;
        this.fields.maxPage = e.data.last_page;
        this.fields.fromPage = e.data.from;
        this.fields.toPage = e.data.to;
        this.fields.totalAmount = e.data.total;
        this.themas = e.data.data;
        this.isHide = true;
      }).catch((error) => {
        console.log(error);
      });
    },
    linkAction: function(actionName, id) {
      this.$refs.modalchild.initFields(actionName, id);
      this.hideFlag = false;
      this.noneFlag = false;
      setTimeout(() => {
        this.showFlag = true;
      }, 100);
    },
    closeMethod: function() {
      this.showFlag = false;
      this.hideFlag = true;
      setTimeout(() => {
        this.noneFlag = true;
      }, 500);
      this.loadInfo();
    },
    messageMethod: function(message, bool){
      this.$emit('message-event', message, bool);
    }
  }
}
</script>