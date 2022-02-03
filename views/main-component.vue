<template>
  <main>
    <div class="header">
      <ul>
        <li><a href="" @click.prevent.stop="clickBar"><i class="fas fa-bars"></i></a></li>
      </ul>
      <p>管理者</p>
    </div>
    <div class="main">
      <div class="content-header">
        <h1>一覧</h1>
      </div>
      <div class="content">
        <div class="card">
          <div class="card-header">
            一覧
          </div>
          <div class="card-body">
            <table>
              <thead>
                <tr>
                  <th>製品名</th>
                  <th>型番</th>
                  <th>URL</th>
                  <th>必要数</th>
                  <th>在庫数</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>カーボン抵抗(炭素皮膜抵抗)</td>
                  <td>１／４Ｗ１００Ω(１００本入)</td>
                  <td>https://akizukidenshi.com/catalog/g/gR-25101/</td>
                  <td>250</td>
                  <td>600</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
module.exports = {
  methods: {
    clickBar: function(){
      this.$emit('click-bar')
    }
  }
}
</script>