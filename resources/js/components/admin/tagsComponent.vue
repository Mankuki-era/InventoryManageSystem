<template>
  <main class="main-user">

    <div class="main-contena">
      <div class="main-title">Tag Management</div>
      <div class="submain-contena">
        <div class="submain-contena-logo"><i class="fas fa-tags submain-contena-icon"></i></div>
        <div class="submain">
          <p class="submain-title">Tags Table</p>
          <div class="no-tags" v-if="tags.length === 0">
            <p><i class="fas fa-info-circle info-icon"></i>タグは登録されていません.</p>
          </div>
          <div class="buttons" v-if="tags.length !== 0">
            <li class="refresh-button"><a href="#" @click.prevent.stop="refreshAction"><i class="fas fa-redo-alt buttons-icon refresh-icon"></i>REFRESH</a></li>
          </div>
          <div class="form-contena" v-if="tags.length !== 0">
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
          <table class="tags-table" v-if="tags.length !== 0">
            <div class="admin-loader" v-bind:class="{ hidden: isHide }"></div>
            <div class="admin-mask" v-bind:class="{ hidden: isHide }"></div>
            <thead>
              <tr>
                <th style="width: 60px;">ID</th>
                <th style="width: 200px;">Name</th>
                <th style="width: 70px;">Item Count</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="tag in tags" :key="tag.id">
                <td>{{ tag.id }}</td>
                <td>{{ tag.tag_name }}</td>
                <td>{{ tag.items_count }}</td>
              </tr>
            </tbody>
          </table>
          <ul class="paginate-box" v-if="tags.length !== 0">
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
      tags: {},
      fields: {},
      keyword: '',
      isHide: true,
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
        this.loadTags();
      }).catch((error) => {
        console.log(error);
      });
    },
    loadTags: function(){
      axios.get('/api/tag?page=' + this.fields.currentPage, {
        params: {
          perpage: this.fields.perpage,
          first_search: this.fields.first_search,
        }
      }).then(e => {
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.tags = e.data.data;
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
      axios.get('/api/tag?page=1', {
        params: {
          perpage: this.fields.perpage,
          first_search: this.keyword,
        }
      }).then(e => {
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.noItems = this.fields.totalAmount === 0 ? true : false;
        this.tags = e.data.data;
        this.fields.first_search = this.keyword;
        this.isHide = true;
      }).catch((error) => {
        console.log(error);
      });
    },
    paginateAction: function(page){
      axios.get('/api/tag?page=' + page, {
        params: {
          perpage: this.fields.perpage,
          first_search: this.fields.first_search,
        }
      }).then(e => {
        this.fields.currentPage = page;
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.tags = e.data.data;
      }).catch((error) => {
        console.log(error);
      });
    },
    perpageClick: function(){
      this.isHide = false;
      axios.get('/api/tag?page=1', {
        params: {
          perpage: this.fields.perpage,
          first_search: this.fields.first_search,
        }
      }).then(e => {
        this.fields.currentPage = 1;
        this.fields.maxPage = e.data.meta.last_page;
        this.fields.fromPage = e.data.meta.from;
        this.fields.toPage = e.data.meta.to;
        this.fields.totalAmount = e.data.meta.total;
        this.tags = e.data.data;
        this.isHide = true;
      }).catch((error) => {
        console.log(error);
      });
    },
  }
}
</script>