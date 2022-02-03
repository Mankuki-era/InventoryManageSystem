
<table>
  <?php
    $len_max = array(
      "name" => 4,
      "model" => 4,
      "remarks" => 6,
      "price" => 6,
      "quantity" => 6,
      "url" => 6,
    );
    foreach($carts as $cart){
      $len_max["name"] = $len_max["name"] < mb_strwidth($cart->item->name) ? mb_strwidth($cart->item->name) : $len_max["name"];
      $len_max["model"] = $len_max["model"] < mb_strwidth($cart->item->model) ? mb_strwidth($cart->item->model) : $len_max["model"];
      $len_max["remarks"] = $len_max["remarks"] < mb_strwidth($cart->remarks) ? mb_strwidth($cart->remarks) : $len_max["remarks"];
      $len_max["price"] = $len_max["price"] < mb_strwidth($cart->item->price) ? mb_strwidth($cart->item->price) : $len_max["price"];
      $len_max["quantity"] = $len_max["quantity"] < mb_strwidth($cart->quantity) ? mb_strwidth($cart->quantity) : $len_max["quantity"];
      $len_max["url"] = $len_max["url"] < mb_strwidth($cart->item->url) ? mb_strwidth($cart->item->url) : $len_max["url"];
    }
    $len_max["name"] += 4;
    $len_max["model"] += 4;
    $len_max["remarks"] += 4;
    $len_max["price"] += 4;
    $len_max["quantity"] += 4;
  ?>
  <tr>

  </tr>
  <thead>
    <tr>
      <th width="20" ></th>
      <th style="width: <?= (string)$len_max["name"] . "px;"?>">製品名</th>
      <th style="width: <?= (string)$len_max["model"] . "px;"?>">型番</th>
      <th style="width: <?= (string)$len_max["remarks"] . "px;"?>">備考</th>
      <th style="width: <?= (string)$len_max["price"] . "px;"?>">単価</th>
      <th style="width: <?= (string)$len_max["quantity"] . "px;"?>">数量</th>
      <th>合計</th>
      <th style="width: <?= (string)$len_max["url"] . "px;"?>">URL</th>
    </tr>
  </thead>
  <tbody>
    @foreach($carts as $cart)
      <tr>
        <td></td>
        <td>{{ $cart->item->name }}</td>
        @if($cart->item->model)
        <td>{{ $cart->item->model }}</td>
        @else
        <td></td>
        @endif
        @if($cart->remarks)
        <td>{{ $cart->remarks }}</td>
        @else
        <td></td>
        @endif
        <td>{{ $cart->item->price }}</td>
        <td>{{ $cart->quantity }}</td>
        <td>{{ $cart->quantity * $cart->item->price }}</td>
        @if($cart->item->url)
        <td><a href=<?= $cart->item->url ?>>{{ $cart->item->url }}</a></td>
        @else
        <td></td>
        @endif
      </tr>
    @endforeach
    <?php
      $sum = 0;
      foreach($carts as $cart){
        $sum += $cart->item->price * $cart->quantity;
      }
    ?>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>{{ $sum }}</td>
    </tr>
  </tbody>
</table>