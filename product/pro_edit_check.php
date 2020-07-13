<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>サンプル</title>
</head>
<body>

<?php

//前の画面で入力されたデータ（「form」=>「postメソッド」の中）を$_POST（POSTリクエスト）で取り出し、変数にコピー
//・GETリクエスト：データがURLにも引き渡される
//・POSTリクエスト：データがURLには引き渡されない
//よって、パスワード等を含む場合は「POSTリクエスト」を使用
$pro_code = $_POST['code'];
$pro_name=$_POST['name'];
$pro_price = $_POST['price'];
$pro_image_name_old = $_POST['image_name_old'];
$pro_image = $_FILES['image'];

//サニタイジング（Sanitizing、無害化、セキュリティ対策）
$pro_code = htmlspecialchars($pro_code);
$pro_name=htmlspecialchars($pro_name);
$pro_price=htmlspecialchars($pro_price);

//1.商品名チェック
//入力が成功すると、商品名を出力
if ($pro_name == '') {
    print '商品名が入力されていません。<br/>';
} else {
    print '商品名:';
    print $pro_name;
    print '<br/>';
}


if ($pro_image['size'] > 0)
// 単位はByte
{
    if ($pro_image['size'] > 1000000) {
        print '画像が大き過ぎます。';
    } else {
        move_uploaded_file($pro_image['tmp_name'], './image/' . $pro_image['name']);
        //move_uploaded_file(移動元，移動先)
        //tmp = temporary(一時的な)
        //$pro_image['tmp_name'] => 仮にアップロードされている画像本体の場所と名前
        print '<img src="./image/' . $pro_image['name'] . '">';
        print '<br/>';
    }
}



if (preg_match('/^[0-9]+$/', $pro_price) == 0) {
    //もし半角数字じゃなかったら
    //preg_match => 正なら１，誤なら０を返す
    //perl互換の正規表現（regex）
    print '価格をきちんと入力してください。<br/>';
} else {
    print '価格:';
    print $pro_price;
    print '円<br/>';
}

if ( $pro_name == ''|| preg_match('/^[0-9]+$/', $pro_price) == 0) {
    //もし半角数字じゃなかったら
    print '<form>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    //「onclick="history.back()"」は入力したデータを消さずに前の画面に戻る
    print '</form>';
} else {
    print '上記のように変更します。<br/>';
    print '<form method="post" action="pro_edit_done.php">';
    print '<input type="hidden" name="code" value="' . $pro_code . '">';
    print '<input type="hidden" name="name" value="' . $pro_name . '">';
    print '<input type="hidden" name="price" value="' . $pro_price . '">';
    print '<input type="hidden" name="image_name_old" value="' . $pro_image_name_old . '">';
    print '<input type="hidden" name="image_name" value="' . $pro_image['name'] . '">';
    print '<br/>';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="OK">';
    //「submit」が、押された瞬間送信するのに対し（無条件で「form」の「action」を実行）
    //「button」は、押した時の処理を自分で記述しない限り送信されない（自分で動作を作成）
    print '</form>';
}

?>

</body>
</html>