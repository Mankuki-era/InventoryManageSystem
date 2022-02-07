<template>
  <div class="type01-contena">
    <ul class="sample-area">
      <li class="sample-download"><a href="../../doc/format.xlsx" download><img src="../img/excel.png" alt="画像">XLSXサンプルをダウンロード</a></li>
    </ul>
    <div class="preview-area">
      <div class="msg-box">
        <p class="err-msg" v-show="fields.fileErr">{{ fields.errAmount }}箇所でエラーが発生しました.</p>
        <p class="success-msg" v-show="!fields.fileErr && preview.length > 0">データは正常です.</p>
      </div>
      <div class="preview-box">
        <p class="no-preview" v-if="preview.length === 0">プレビュー表示エリア</p>
        <table v-else>
          <thead>
            <tr>
              <th></th>
              <th v-for="(column, index) in columnArray" :key="index">{{ column }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(data, index) in preview" v-bind:key="index">
              <td>{{ index + 1 }}</td>
              <td v-for="column in columnArray" :key="column" :class="{ err: data[column].err !== ''}">{{ data[column].val }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="file-area">
      <label><input type="file" id="file" @change="handleFile">ファイル選択</label><span>{{ fields.fileName }}</span>
    </div>
    <ul class="button-box">
      <li><a href="" :class="{disabled: preview.length === 0 || fields.fileErr}" @click.prevent.stop="createData">追加</a></li>
    </ul>
  </div>
</template>

<script>
module.exports = {
  initData: function(){
    return {
      columnArray: ['製品名','URL','必要数','在庫数','カテゴリー','お気に入り'],
      preview: [],
      originData: [],
      fields: {
        fileName: '選択されていません',
        fileErr: false,
        errAmount: 0
      },
    };
  },
  data: function() {
    return this.$options.initData();
  },
  methods: {
    resetData: function(){
      Object.assign(this.$data, this.$options.initData());
    },
    fixdata: function(resultData) {
      let o = "",
          l = 0,
          w = 10240;
      for (; l < resultData.byteLength / w; ++l) o += String.fromCharCode.apply(null, new Uint8Array(resultData.slice(l * w,
          l * w + w)));
      o += String.fromCharCode.apply(null, new Uint8Array(resultData.slice(l * w)));
      return o;
    },
    to_json: function(workbook, X) {
      let result = {};
      workbook.SheetNames.forEach(function (sheetName) {
        const roa = X.utils.sheet_to_json(
          workbook.Sheets[sheetName],
          {
              raw: true,
          });
        if (roa.length > 0) {
          result[sheetName] = roa;
        }
      });
      return result;
    },
    handleFile: function(e) {
      this.preview = [];
      this.originData = [];
      this.fields.fileErr = false;
      this.fields.errAmount = 0;
      const X = XLSX;
      const files = e.target.files;
      const f = files[0];
      this.fields.fileName = f.name;
      const reader = new FileReader();
      const loadReader = (e) => {
        const resultData = e.target.result;
        const arr = this.fixdata(resultData);
        const wb = X.read(btoa(arr), {
          type: 'base64',
          cellDates: true,
        });
        const output = this.to_json(wb, X);
        for (let row of output['Sheet1']) {
          var array = this.checkData(row);
          this.preview.push(array);
          this.originData.push(row);
        }
      };
      reader.readAsArrayBuffer(f);
      reader.onload = loadReader;
      document.getElementById("file").value = '';
    },
    checkData: function(data){
      var array = {};
      this.columnArray.forEach((value, index) => {
        var err_msg = '';
        if((value === '製品名' || value === '在庫数') && data[value] === undefined){
          err_msg = '入力値がありません';
          this.fields.fileErr = true;
          this.fields.errAmount += 1;
        };
        if(value === 'お気に入り' && !(data[value] === undefined || data[value] === 1)){
          err_msg = '入力ミスです';
          this.fields.fileErr = true;
          this.fields.errAmount += 1;
        };
        array[value] = {
          val: data[value],
          err: err_msg
        };
      });
      return array;
    },
    createData: function(){
      this.$emit('loading-event', true);
      this.$emit('message-event', null, null, true);
      setTimeout(() => {
        axios.post(`http://localhost:${port}/backend/controllers/item.php`,{
          func: 'create-type01',
          datas: this.originData
        }).then((res) => {
          console.log('作成完了');
          this.resetData();
          this.$emit('loading-event', false);
          this.$emit('message-event', '登録が完了しました.', true, false);
        });
      }, 2000);
    },
  }
}
</script>