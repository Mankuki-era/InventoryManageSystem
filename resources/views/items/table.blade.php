
<table>
  <?php
    $len_max = array(
      "name" => 0,
      "model" => 0,
      "price" => 14,
      "stocks" => 8,
      "url" => 0,
      "pro" => 6,
      "late" => 6,
      "all" => 6,
      "grade" => 0,
      "thema" => 0,
      "comment" => 8,
      "tag1" => 6,
      "tag2" => 6,
      "tag3" => 6,
      "tag4" => 6,
      "tag5" => 6,
    );
    foreach($items as $item){
      $i = 0;
      $len_max["name"] = $len_max["name"] < mb_strwidth($item->name) ? mb_strwidth($item->name) : $len_max["name"];
      $len_max["model"] = $len_max["model"] < mb_strwidth($item->model) ? mb_strwidth($item->model) : $len_max["model"];
      $len_max["price"] = $len_max["price"] < mb_strwidth($item->price) ? mb_strwidth($item->price) : $len_max["price"];
      $len_max["stocks"] = $len_max["stocks"] < mb_strwidth($item->stocks) ? mb_strwidth($item->stocks) : $len_max["stocks"];
      $len_max["url"] = $len_max["url"] < mb_strwidth($item->url) ? mb_strwidth($item->url) : $len_max["url"];
      $needs_all = null;
      $needs_pro = null;
      $needs_late = null;
      if($item->require_count){
          $data = unserialize($item->require_count);
          $needs_all = $data['all'];
          $needs_pro = $data['pro'];
          $needs_late = $data['late'];
      }
      $len_max["pro"] = $len_max["pro"] < mb_strwidth($needs_pro) ? mb_strwidth($needs_pro) : $len_max["pro"];
      $len_max["late"] = $len_max["late"] < mb_strwidth($needs_late) ? mb_strwidth($needs_late) : $len_max["late"];
      $len_max["all"] = $len_max["all"] < mb_strwidth($needs_all) ? mb_strwidth($needs_all) : $len_max["all"];
      $len_max["grade"] = $len_max["grade"] < mb_strwidth($item->second_category) ? mb_strwidth($item->second_category) : $len_max["grade"];
      $len_max["thema"] = $len_max["thema"] < mb_strwidth($item->third_category) ? mb_strwidth($item->third_category) : $len_max["thema"];
      $len_max["comment"] = $len_max["comment"] < mb_strwidth($item->comment) ? mb_strwidth($item->comment) : $len_max["comment"];
      $tags = [];
      foreach($item->tags as $tag){
        if($tag->tag_name != $item->first_category && $tag->tag_name != $item->second_category && $tag->tag_name != $item->third_category){
          array_push($tags, $tag->tag_name);
        }
      }
      for($count = 0; $count < count($tags); $count++){
        if($count == 0){
          $len_max["tag1"] = $len_max["tag1"] < mb_strwidth($tags[$count]) ? mb_strwidth($tags[$count]) : $len_max["tag1"];
        }elseif($count == 1){
          $len_max["tag2"] = $len_max["tag2"] < mb_strwidth($tags[$count]) ? mb_strwidth($tags[$count]) : $len_max["tag2"];
        }elseif($count == 2){
          $len_max["tag3"] = $len_max["tag3"] < mb_strwidth($tags[$count]) ? mb_strwidth($tags[$count]) : $len_max["tag3"];
        }elseif($count == 3){
          $len_max["tag4"] = $len_max["tag4"] < mb_strwidth($tags[$count]) ? mb_strwidth($tags[$count]) : $len_max["tag4"];
        }elseif($count == 4){
          $len_max["tag5"] = $len_max["tag5"] < mb_strwidth($tags[$count]) ? mb_strwidth($tags[$count]) : $len_max["tag5"];
        };
      }
    }
    $len_max["name"] += 4;
    $len_max["model"] += 4;
    $len_max["price"] += 4;
    $len_max["stocks"] += 4;
    $len_max["url"] += 4;
    $len_max["grade"] += 4;
    $len_max["thema"] += 4;
    $len_max["comment"] += 4;
    $len_max["tag1"] += 4;
    $len_max["tag2"] += 4;
    $len_max["tag3"] += 4;
    $len_max["tag4"] += 4;
    $len_max["tag5"] += 4;
  ?>
  <thead>
    <tr>
      <th style="width: <?= (string)$len_max["name"] . "px;"?>">名前</th>
      <th style="width: <?= (string)$len_max["model"] . "px;"?>">型番</th>
      <th style="width: <?= (string)$len_max["price"] . "px;"?>">値段(税込)[円]</th>
      <th style="width: <?= (string)$len_max["stocks"] . "px;"?>">在庫数</th>
      <th style="width: <?= (string)$len_max["url"] . "px;"?>">URL</th> 
      <th style="width: <?= (string)$len_max["pro"] . "px;"?>">前期</th> 
      <th style="width: <?= (string)$len_max["late"] . "px;"?>">後期</th> 
      <th style="width: <?= (string)$len_max["all"] . "px;"?>">通年</th> 
      <th style="width: <?= (string)$len_max["grade"] . "px;"?>">学年学科</th>
      <th style="width: <?= (string)$len_max["thema"] . "px;"?>">科目名</th>
      <th style="width: <?= (string)$len_max["comment"] . "px;"?>">商品説明</th>
      <th style="width: <?= (string)$len_max["tag1"] . "px;"?>">タグ1</th>
      <th style="width: <?= (string)$len_max["tag2"] . "px;"?>">タグ2</th>
      <th style="width: <?= (string)$len_max["tag3"] . "px;"?>">タグ3</th>
      <th style="width: <?= (string)$len_max["tag4"] . "px;"?>">タグ4</th>
      <th style="width: <?= (string)$len_max["tag5"] . "px;"?>">タグ5</th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
      <tr>
        <td>{{ $item->name }}</td>
        <td>{{ $item->model }}</td>
        <td>{{ $item->price }}</td>
        <td>{{ $item->stocks }}</td>
        <td>{{ $item->url }}</td>
        <?php
          $needs_all = null;
          $needs_pro = null;
          $needs_late = null;
          if($item->require_count){
              $data = unserialize($item->require_count);
              $needs_all = $data['all'];
              $needs_pro = $data['pro'];
              $needs_late = $data['late'];
          }
        ?>
        <td>{{ $needs_pro }}</td>
        <td>{{ $needs_late }}</td>
        <td>{{ $needs_all }}</td>
        <td>{{ $item->second_category }}</td>
        <td>{{ $item->third_category }}</td>
        <td>{{ $item->comment }}</td>
        @for($count = 3; $count < count($item->tags); $count++)
          <td>{{ $item->tags[$count]->tag_name }}</td>
        @endfor
        @for($count = 0; $count < (5 - count($item->tags)); $count++)
          <td></td>
        @endfor
      </tr>
    @endforeach
  </tbody>
</table>