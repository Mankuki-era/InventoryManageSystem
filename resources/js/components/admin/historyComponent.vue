<template>
  <main class="main-history">
    <div class="main-contena">
      <div class="main-title">History Management</div>
      <div class="submain-contena">
        <div class="submain-contena-logo"><i class="fas fa-history submain-contena-icon"></i></div>
        <div class="submain">
          <p class="submain-title">History</p>
          <div class="flex-contena">
            <div class="left-contena">
              <div class="form-contena">
                <div class="year-select-box">
                  <select class="year_selection" v-model="fields.selectY" @change="yearClick" required>
                    <option v-for="(year, index) in fields.year_fields" :key="index">
                      {{ year }}
                    </option>
                  </select>
                  <div class="underline"></div>
                  <label for="">年を選択</label>
                </div>
                <div class="day-index-box">
                  <li v-for="(date, index) in fields.date_fields" :key="index" v-bind:class="{ selected: date.id === selectHistory.id}">
                    <a href="" @click.prevent.stop="dateClick(date.id)">{{ date.create_D }}  {{ date.create_T }}</a>
                  </li>
                </div>
              </div>
            </div>
            <div class="right-contena">
              <div class="table-contena" v-bind:class="{show: showFlag, none: noneFlag}">
                <div class="create-info-contena">
                  <h1>{{ selectHistory.create_Y }}/{{ selectHistory.create_D }} 発注表</h1>
                  <p>作成者：{{ selectHistory.user_name }}</p>
                </div>
                <div class="table">
                  <table>
                    <thead>
                      <tr>
                        <th>製品名</th>
                        <th>型番</th>
                        <th>備考</th>
                        <th class="min-cell">単価</th>
                        <th class="min-cell">数量</th>
                        <th class="min-cell">合計</th>
                        <th>URL</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(table, index) in selectHistory.table_content" :key="index">
                        <td>{{ table.name }}</td>
                        <td>{{ table.model }}</td>
                        <td>{{ table.remarks }}</td>
                        <td>{{ table.price }}</td>
                        <td>{{ table.quantity }}</td>
                        <td>{{ table.sumprice }}</td>
                        <td><a href="">{{ table.url }}</a></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ selectHistory_sumprice }}</td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="preview-contena" v-show="!selectFlag">
                <div class="preview-box">
                  <i class="fas fa-file-excel preview-icon fa-4x"></i>
                  <p>プレビュー表示領域</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data: function(){
    return {
      history: {},
      fields: {
        year_fields: [],
        date_fields: [],
        selectY: ''
      },
      selectHistory: {},
      selectHistory_sumprice: 0,
      selectFlag: false,
      showFlag: false,
      noneFlag: true,
    }
  },
  mounted() {
    this.$emit('class-event', 'admin');
    this.loadHistory();
  },
  methods: {
    loadHistory: function() {
      this.$emit("adminLoading-event", true);
      axios.get('/api/history').then(e => {
        this.history = e.data.data;
        var year_array = [];
        this.history.forEach(field => {
          year_array.push(field.create_Y);
        });
        this.fields.year_fields = [...new Set(year_array)];
        this.$emit("adminLoading-event", false);
      }).catch((error) => {
        console.log(error);
      });
    },
    yearClick: function(){
      this.history.forEach(field => {
        if(this.fields.selectY === field.create_Y){
          this.fields.date_fields.push(field);
        }
      });
    },
    dateClick: function(id) {
      this.selectHistory_sumprice = 0;
      this.history.forEach(history => {
        if(history.id === id){
          this.selectHistory = history;
          history.table_content.forEach(table => {
            this.selectHistory_sumprice += table.sumprice;
          });
          this.selectFlag = true;
        }
      });

      this.showFlag = false;
      this.noneFlag = false;
      setTimeout(() => {
        this.showFlag = true;
      }, 300);
    },
  }
}
</script>