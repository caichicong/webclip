<?php
ob_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">

<title>保存网页</title>

</head>
<body>
<form action="save.php" method="post" accept-charset="utf-8">
  请输入http开头的地址 : <input size="70" type="text" name="url" value="">        
    <input type="submit" value="保存">
</form>
<?php
include 'common.php';

$stm = $db->query('select * from urls order by addtime DESC');
$stm->execute();
$urls = $stm->fetchAll(PDO::FETCH_ASSOC);
?>
<ul>
<?php
foreach($urls as $url) {
    $static_url = translate_to_static_url($url['url']);
    printf('<li><a href="%s" target="_blank">%s</a> %s</li>', $static_url, $url['title'], $url['addtime']);
    printf('<li> http://%s <a href="delete.php?url=%s">del</a> </li>', $url['url'],  $url['url']);
}
?>
</ul>

</body>
</html>
<?php
$cache_index = ob_get_contents();
ob_end_flush();
$fp = fopen('index.html', 'w+');
fwrite($fp, $cache_index);
fclose($fp);
?>

