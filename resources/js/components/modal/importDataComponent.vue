<template>
  <div class="import-form-contena">
    <a href="#" class="refresh-button" @click.prevent.stop="importAction">Import</a>
    <div class="modal-content">
      <h1>Choose Excel File</h1>
      <div class="loading-contena">
        <div class="icon-contena" v-bind:class="{ hidden: !isHide }">
          <img src="/image/excel-icon.jpg" alt="">
          <i class="fas fa-arrow-alt-circle-right arrow-icon"></i>
          <i class="fas fa-database database-icon"></i>
        </div>
        <div class="import-loader" v-bind:class="{ hidden: isHide }"></div>
        <p class="loading-message" v-bind:class="{ hidden: isHide }">Now is Importing...</p>
      </div>
      <p class="caution_message" v-if="cautionFlag">{{ cautionMessage }}</p>
      <p class="caution_message" v-else></p>
      <div class="file-form">
        <label>
          <input type="file" name="file" ref="file" @change="fileSelected">ファイルを選択
        </label>
        <p>{{ fileName }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      thema_secondArray: [],
      thema_thirdArray: {},
      fileName: '選択されていません.',
      cautionMessage: '',
      file: null,
      cautionFlag: false,
      isHide: true,
      alertFlag: false
    }
  },
  mounted() {
    this.loadThema();
  },
  methods: {
    loadThema: function() {
      axios.get('/api/themaCategory').then(e => {
        this.thema_secondArray = e.data.thema_secondArray;
        this.thema_thirdArray = e.data.thema_thirdArray;
      }).catch((error) => {
        console.log(error);
      });
    },
    fileSelected(e) {
      this.alertFlag = false;
      this.file = e.target.files[0];
      this.fileName = this.file.name;
      this.cautionFlag = false;

      var self = this;

      handleFile(e, self);

      var X = XLSX;

      // ファイル選択時のメイン処理
      function handleFile(e, self) {

          var files = e.target.files;
          var f = files[0];

          var reader = new FileReader();
          reader.onload = function (e) {
              var data = e.target.result;
              var wb;
              var arr = fixdata(data);
              wb = X.read(btoa(arr), {
                  type: 'base64',
                  cellDates: true,
              });

              var output = "";
              output = to_json(wb);

              output.Sheet1.some((row, index) => { //forEachはダメ breakできない
                var alertMessage = '';
                var alertRow = 0;
                var alertFlag = false;

                if(!row["名前"] && !row["型番"] && !row["値段(税込)[円]"] && !row["在庫数"] && !row["URL"] && !row["前期"] && !row["後期"] && !row["通年"] && !row["学年学科"] && !row["科目名"] && !row["商品説明"] && !row["タグ1"] && !row["タグ2"] && !row["タグ3"] && !row["タグ4"] && !row["タグ5"]) {
                  return true;
                }

                if(!row["名前"]){
                  alertMessage = "[名前]が記載されていません.\n";
                  alertFlag = true;
                }
                if(!row["在庫数"]){
                  alertMessage += "[在庫数]が記載されていません.\n";
                  alertFlag = true;
                }
                if(!row["学年学科"]){
                  alertMessage += "[学年学科]が記載されていません.\n";
                  alertFlag = true;
                }
                if((row["前期"] && row["通年"]) || (row["後期"] && row["通年"])){
                  alertMessage += "必要数は半期ごともしくは通年で入力してください.\n";
                  alertFlag = true;
                }
                if(!self.thema_secondArray.includes(row["学年学科"])) {
                  alertMessage += "[学年学科]がデータベースに存在しません.\n";
                  alertFlag = true;
                }else{
                  if(!self.thema_thirdArray[row["学年学科"]].includes(row["科目名"])) {
                    alertMessage += "[科目名]がデータベースに存在しません.\n";
                    alertFlag = true;
                  }
                }
                if(!row["科目名"]){
                  alertMessage += "[科目名]が記載されていません.\n";
                  alertFlag = true;
                }
                if(alertFlag){
                  alertRow = index + 2;
                  if (!alert(alertRow + "行目\n" + alertMessage)) {
                    self.alertFlag = true;
                    self.fileName = '選択されていません.';
                    self.$refs.file.value = null;
                  }
                }
              });

              if(!self.alertFlag) {
                alert("インポート可能です.");
              }

          };

          reader.readAsArrayBuffer(f);
      }

      // ファイルの読み込み
      function fixdata(data) {
          var o = "",
              l = 0,
              w = 10240;
          for (; l < data.byteLength / w; ++l) o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w,
              l * w + w)));
          o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w)));
          return o;
      }

      // ワークブックのデータをjsonに変換
      function to_json(workbook) {
          var result = {};
          workbook.SheetNames.forEach(function (sheetName) {
              var roa = X.utils.sheet_to_json(
                  workbook.Sheets[sheetName],
                  {
                      raw: true,
                  });
              if (roa.length > 0) {
                  result[sheetName] = roa;
              }
          });
          return result;
      }
    },
    importAction: function(){
      this.cautionFlag = false;
      if(this.file === null){
        this.cautionMessage = 'ファイルを選択してください.';
        this.cautionFlag = true;
        return;
      }
      if(this.alertFlag){
        this.cautionMessage = 'インポートするデータを修正してください.';
        this.cautionFlag = true;
        return;
      }
      if(this.file.type !== "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){
        this.cautionMessage = 'Excelファイルを選択してください.';
        this.cautionFlag = true;
        return;
      }
      this.isHide = false
      let formData = new FormData();
      formData.append('file',this.file);

      axios.post('/api/import', formData).then(e => {
        this.$emit('refresh-event');
        setTimeout(() => {
          this.$emit('message-event', 'データのインポートが完了しました.', true);
          this.isHide = true;
          this.$emit('close-event');
        }, 100);
      }).catch((error) => {
        console.log(error);
      });
    }
  }
}
</script>